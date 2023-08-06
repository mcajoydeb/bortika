<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\TermSavingFailedException;
use App\Models\Term;
use App\Models\TermExtra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pipelines\Admin\PostCategory\AddTermTypePostCategory;
use App\Services\TermRequestService;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('post_category_management')) {
            abort(403);
        }

        return view('admin.blog.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('post_category_add')) {
            abort(403);
        }

        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('post_category_add')) {
            abort(403);
        }

        $validatedData = Validator::validate($request->all(),
            (new Term())->rules() + (new TermExtra())->categoryRules('post')
        );

        try {
            $term = app(Pipeline::class)
                ->send( TermRequestService::filterMainTableData($validatedData) )
                ->through([
                    AddTermTypePostCategory::class
                ])
                ->then(fn($validatedData) => Term::create($validatedData));

            if (! $term) {
                throw new TermSavingFailedException(__('Sorry! Category couldn\'t be created'));
            }

            $term->extra()->insert( TermRequestService::filterExtraTableData($validatedData, $term->id, 'term_id') );

            Session::flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $term->name]));

        } catch (TermSavingFailedException $e) {
            debugForLocalEnv($e);
            Session::flash('alert-error', $e->getMessage());
        } catch (\Exception $e) {
            debugForLocalEnv($e);
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.blog.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('post_category_view')) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('post_category_edit')) {
            abort(403);
        }

        $term = Term::findOrFail($id);

        return view('admin.blog.categories.edit', compact('term'));
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
        if (!auth()->user()->can('post_category_edit')) {
            abort(403);
        }

        $term = Term::findOrFail($id);

        $validatedData = Validator::validate($request->all(), $term->rules() + (new TermExtra())->categoryRules('post'));

        try {
            $result = $term->update( TermRequestService::filterMainTableData($validatedData) );

            if (! $result) {
                throw new TermSavingFailedException(__("Error! Category couldn't be updated"));
            }

            $termExtraData = collect(TermRequestService::filterExtraTableData($validatedData, $term->id, 'term_id'));

            $termExtraData->each(function($value) use ($term) {
                $term->extra()->updateOrCreate(
                    ['term_id' => $value['term_id'], 'key_name' => $value['key_name']],
                    ['key_value' => $value['key_value']]
                );
            });

            $request->session()->flash('alert-success', trans('alert-messages.successfully-updated', ['entity' => $term->name]));

        } catch (TermSavingFailedException $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
        } catch (\Exception $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.blog.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('post_category_delete')) {
            abort(403);
        }

        $term = Term::findOrFail($id);
        $result = $term->delete();

        if ($result) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => $term->name]));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.blog.categories.index');
    }
}
