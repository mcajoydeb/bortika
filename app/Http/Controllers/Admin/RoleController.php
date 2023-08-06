<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('role_management')) {
            abort(403);
        }

        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('role_add')) {
            abort(403);
        }

        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('role_add')) {
            abort(403);
        }

        $data = Validator::validate($request->all(), [
            'name' => 'required|max:255|unique:roles,name',
            'permissions' => 'present|array',
        ]);

        $role = Role::create(['name' => $data['name']]);

        if ($role) {
            $role->syncPermissions($data['permissions']);
            $request->session()->flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $role->name]));
        } else {
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('role_view')) {
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
        if (!auth()->user()->can('role_edit')) {
            abort(403);
        }

        $rolesToExclude = Auth::user()->getRoleNames()->toArray();
        $rolesToExclude[] = config('roles.super_admin.id');

        $role = Role::whereNotIn('name', $rolesToExclude)->findOrFail($id);
        return view('admin.roles.edit', compact('role'));
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
        if (!auth()->user()->can('role_edit')) {
            abort(403);
        }

        $rolesToExclude = Auth::user()->getRoleNames()->toArray();
        $rolesToExclude[] = config('roles.super_admin.id');

        $role = Role::whereNotIn('name', $rolesToExclude)->findOrFail($id);

        $data = Validator::validate($request->all(), [
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'present|array',
        ]);

        $result = $role->update(['name' => $data['name']]);

        if ($result) {
            $role->syncPermissions($data['permissions']);
            $request->session()->flash('alert-success', trans('alert-messages.successfully-added', ['entity' => $role->name]));
        } else {
            $request->session()->flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('role_delete')) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $response = $role->delete();

        if ($response) {
            Session::flash('alert-success', trans('alert-messages.successfully-deleted', ['entity' => 'Role']));
        } else {
            Session::flash('alert-error', trans('alert-messages.error-message'));
        }

        return redirect()->route('admin.role.index');
    }
}
