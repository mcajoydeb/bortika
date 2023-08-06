<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\TermExtra;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.store.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.store.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $termData = Validator::validate($request->all(), (new Term())->rules());

        $termExtraData = Validator::validate($request->all(), (new TermExtra())->categoryRules('product'));

        $term = Term::create($termData + ['type' => config('term-types.product_category')]);

        if ($term) {
            TermExtra::insert(TermExtra::prepareInputFromKeyName($termExtraData, $term->id));
            Session::flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $term->name]));
        } else {
            Session::flash('alert-error', trans('form.error-message'));
        }

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::findOrFail($id);
        return view('admin.store.categories.edit', compact('term'));
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
        $term = Term::findOrFail($id);

        $termData = Validator::validate($request->all(), $term->rules());
        $termExtraData = collect(Validator::validate($request->all(), (new TermExtra())->categoryRules('product')));

        $result = $term->update($termData);

        if ($result) {
            $termExtraData->each(function($value, $key) use ($term) {
                $term->extra()->whereKeyName($key)->update(['key_value' => $value]);
            });
            $request->session()->flash('alert-success', trans('alert-messages.successfully-updated', ['entity' => $term->name]));
        } else {
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $result = $term->delete();

        if ($result) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => $term->name]));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.product-categories.index');
    }
}
