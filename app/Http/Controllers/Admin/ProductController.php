<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ProductSavingFailedException;
use App\Models\Product;
use App\Models\ProductExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\TermRelationship;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Services\ProductRequestFilterService;
use App\Services\ProductTabVisibilityService;
use App\Services\TermRelationshipService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('product_management')) {
            abort(403);
        }

        return view('admin.store.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('product_add')) {
            abort(403);
        }

        return view('admin.store.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('product_add')) {
            abort(403);
        }

        $validatedData = Validator::validate($request->all(), (new Product)->rules($request->type));

        DB::beginTransaction();

        try {
            $product = Product::create( ProductRequestFilterService::getDataForProductTable($validatedData) );

            if (! $product) {
                throw new ProductSavingFailedException(__('Error! Product couldn\'t be added'));
            }

            ProductExtra::insert( ProductRequestFilterService::filterExtraTableData($validatedData, $product->id, 'product_id') );

            $termIds = TermRelationshipService::getTermIdsForProduct($validatedData);
            TermRelationship::insert( TermRelationshipService::prepareData($termIds, $product->id, config('term-objects.product')) );

            if (ProductTabVisibilityService::showVariations($validatedData['type'])) {
                $variationArr = $request->_variations;

                foreach ($variationArr as $variationData) {
                    $variationDataArr = unserialize($variationData);
                    $variationDataArr['type'] = $product->type;
                    $variationDataArr['parent_id'] = $product->id;

                    $variation = Product::create( ProductRequestFilterService::getDataForProductTable($variationDataArr) );
                    ProductExtra::insert( ProductRequestFilterService::filterExtraTableData($variationDataArr, $variation->id, 'product_id') );

                    $attributeIds = TermRelationshipService::prepareAttributeIds($variationDataArr['_attributes'] ?? []);
                    TermRelationship::insert( TermRelationshipService::prepareData($attributeIds, $variation->id, config('term-objects.product')) );
                }
            }

            $request->session()->flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $product->title]));

            DB::commit();

            $route = redirect()->route('admin.products.index');
        } catch (ProductSavingFailedException $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
            $route = redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
            $route = redirect()->back();
        }

        return $route;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('product_view')) {
            abort(403);
        }

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!auth()->user()->can('product_edit')) {
            abort(403);
        }

        return view('admin.store.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('product_edit')) {
            abort(403);
        }

        $product = Product::withTrashed()->findOrFail($id);

        // restore
        if ($request->has('restore')) {
            $product->restore();
            return redirect()->route('admin.products.index');
        }

        $validatedData = Validator::validate($request->all(), $product->rules($request->type));

        DB::beginTransaction();

        try {
            $response = $product->update( ProductRequestFilterService::getDataForProductTable($validatedData) );

            if (! $response) {
                throw new ProductSavingFailedException(__('Sorry! Product couldn\'t be updated'));
            }

            $productExtraData = ProductRequestFilterService::filterExtraTableData($validatedData, $product->id, 'product_id');

            foreach ($productExtraData as $extra) {
                ProductExtra::updateOrCreate(
                    [ 'product_id' => $product->id, 'key_name' => $extra['key_name'] ],
                    [ 'key_value' => $extra['key_value'] ]
                );
            }

            $termIds = TermRelationshipService::getTermIdsForProduct($validatedData);
            TermRelationshipService::updateTerms($termIds, $product->id, config('term-objects.product'));

            $product->extra()->keysNotIn(array_keys($request->all()))->delete();

            if (ProductTabVisibilityService::showVariations($validatedData['type'])) {
                $variationArr = $request->_variations ? $request->_variations : [];

                foreach ($variationArr as $variationData) {
                    $variationDataArr = unserialize($variationData);
                    $variationDataArr['type'] = $product->type;
                    $variationDataArr['parent_id'] = $product->id;

                    $isDeleted = $variationDataArr['is_deleted'] ?? 0;

                    if ($isDeleted) {
                        optional(Product::find($variationDataArr['id']))->delete();
                        continue;
                    }

                    $variation = Product::updateOrCreate(
                        [ 'id' => $variationDataArr['id'] ],
                        ProductRequestFilterService::getDataForProductTable($variationDataArr)
                    );

                    $variationExtraData = ProductRequestFilterService::filterExtraTableData($variationDataArr, $variation->id, 'product_id');

                    foreach ($variationExtraData as $extra) {
                        ProductExtra::updateOrCreate(
                            [ 'product_id' => $variation->id, 'key_name' => $extra['key_name'] ],
                            [ 'key_value' => $extra['key_value'] ]
                        );
                    }

                    $attributeIds = TermRelationshipService::prepareAttributeIds($variationDataArr['_attributes'] ?? []);
                    TermRelationshipService::updateTerms($attributeIds, $variation->id, config('term-objects.product'));

                    $variation->extra()->keysNotIn(array_keys($request->all()))->delete();
                }
            }

            $request->session()->flash('alert-success', trans('alert-messages.successfully-updated', ['entity' => $product->title]));

            DB::commit();

            $route = redirect()->route('admin.products.index');
        } catch (ProductSavingFailedException $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
            $route = redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
            $route = redirect()->back();
        }

        return $route;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('product_delete')) {
            abort(403);
        }

        $product = Product::withTrashed()->findOrFail($id);

        if (request()->has('force_delete')) {
            $result = $product->forceDelete();
        } else {
            $result = $product->delete();
        }

        if ($result) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => $product->title]));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.products.index');
    }
}
