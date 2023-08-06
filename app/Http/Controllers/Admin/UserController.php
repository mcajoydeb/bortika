<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\UserSavingFailedException;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pipelines\Admin\User\HashUserPassword;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('user_management')) {
            abort(403);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('user_add')) {
            abort(403);
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('user_add')) {
            abort(403);
        }

        $data = Validator::validate($request->all(), (new User)->rules());

        DB::beginTransaction();

        try {
            $user = app(Pipeline::class)
                ->send($data)
                ->through([
                    HashUserPassword::class
                ])
                ->then(fn($data) => User::create($data));

            if (! $user) {
                throw new UserSavingFailedException(__("Error! Sorry user couldn't be added"));
            }

            $user->syncRoles($request->roles);

            $request->session()->flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $user->name]));

            DB::commit();
        } catch (UserSavingFailedException $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('user_view')) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('user_edit')) {
            abort(403);
        }

        $user = User::exceptSuperAdmin()->notLoggedUser()->findOrFail($id);
        return view('admin.users.edit', compact('user'));
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
        if (!auth()->user()->can('user_edit')) {
            abort(403);
        }

        $user = User::withTrashed()->exceptSuperAdmin()->notLoggedUser()->findOrFail($id);

        // restore
        if ($request->has('restore')) {
            $user->restore();
            return redirect()->route('admin.user.index');
        }

        $data = Validator::validate($request->all(), $user->rules());

        try {
            $response = app(Pipeline::class)
                ->send($data)
                ->through([
                    HashUserPassword::class
                ])
                ->then(fn($data) => $user->update($data));

            if (! $response) {
                throw new UserSavingFailedException(__("Error! user couldn't be updated"));
            }

            $user->syncRoles($request->roles);

            $request->session()->flash('alert-success', trans('alert-messages.successfully-updated', ['entity' => $user->name]));

        } catch (UserSavingFailedException $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', $e->getMessage());
        } catch (\Exception $e) {
            debugForLocalEnv($e);
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('user_delete')) {
            abort(403);
        }

        $user = User::withTrashed()->findOrFail($id);

        if (request()->has('force_delete')) {
            $response = $user->forceDelete();
        } else {
            $response = $user->delete();
        }

        if ($response) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => $user->name]));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.user.index');
    }
}
