<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostExtra;
use Illuminate\Http\Request;
use App\Models\TermRelationship;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\PostRequestService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\TermRelationshipService;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\PostSavingFailedException;
use App\Pipelines\Admin\Post\AddAuthorAndPostType;
use App\Pipelines\Admin\Post\ChangeStatusIfCantPublish;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('post_management')) {
            abort(403);
        }

        return view('admin.blog.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('post_add')) {
            abort(403);
        }

        return view('admin.blog.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        if (!auth()->user()->can('post_add')) {
            abort(403);
        }

        $validatedData = Validator::validate($request->all(),
            $post->rules() + $post->extraRules()
        );

        DB::beginTransaction();

        try {
            $post = app(Pipeline::class)
                ->send(PostRequestService::filterMainTableData($validatedData))
                ->through([
                    ChangeStatusIfCantPublish::class,
                    AddAuthorAndPostType::class,
                ])
                ->then(fn($validatedData) => Post::create($validatedData));

            if (! $post) {
                throw new PostSavingFailedException(__('Sorry! Post couldn\'t be created'));
            }

            PostExtra::insert( PostRequestService::filterExtraTableData($validatedData, $post->id, 'post_id') );

            $termIds = TermRelationshipService::getTermIdsForPost($validatedData);
            TermRelationship::insert( TermRelationshipService::prepareData($termIds, $post->id, config('term-objects.post')) );

            $request->session()->flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $post->post_title]));

            DB::commit();
        } catch (PostSavingFailedException $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
            DB::rollBack();
        } catch (\Exception $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
            DB::rollBack();
        }

        return redirect()->route('admin.blog.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('post_view')) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!auth()->user()->can('post_edit')) {
            abort(403);
        }

        return view('admin.blog.posts.edit', compact('post'));
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
        if (!auth()->user()->can('post_edit')) {
            abort(403);
        }

        $post = Post::withTrashed()->findOrFail($id);

        // restore
        if ($request->has('restore')) {
            $post->restore();
            return redirect()->route('admin.blog.posts.index');
        }

        $validatedData = Validator::validate($request->all(),
            $post->rules() + $post->extraRules()
        );

        try {
            $result = app(Pipeline::class)
                ->send(PostRequestService::filterMainTableData($validatedData))
                ->through([
                    ChangeStatusIfCantPublish::class,
                    AddAuthorAndPostType::class,
                ])
                ->then(fn($validatedData) => $post->update($validatedData));

            if (! $result) {
                throw new PostSavingFailedException(__('Error! Post couldn\'t be updated'));
            }

            $postExtraData = collect(PostRequestService::filterExtraTableData($validatedData, $post->id, 'post_id'));

            $postExtraData->each(function ($value) use ($post) {
                if ($value['key_name'] == '_post_password') {
                    $value['key_value'] = Hash::make($value['key_value']);
                }

                PostExtra::updateOrCreate(['key_name' => $value['key_name'], 'post_id' => $post->id], ['key_value' => $value['key_value']]);
            });

            $post->extra()->keysNotIn(array_keys($request->all()))->delete();

            $termIds = TermRelationshipService::getTermIdsForProduct($validatedData);
            TermRelationshipService::updateTerms($termIds, $post->id, config('term-objects.post'));

            $request->session()->flash('alert-success', trans('alert-messages.successfully-updated', ['entity' => $post->post_title]));
        } catch (PostSavingFailedException $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
        } catch (\Exception $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.blog.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('post_delete')) {
            abort(403);
        }

        $post = Post::withTrashed()->findOrFail($id);

        if (request()->has('force_delete')) {
            $result = $post->forceDelete();
        } else {
            $result = $post->delete();
        }

        if ($result) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => $post->post_title]));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.blog.posts.index');
    }
}
