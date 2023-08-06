@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.roles') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.roles') }}
    @can('role_add')
        <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.role') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.roles') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.role.index')
@endsection
