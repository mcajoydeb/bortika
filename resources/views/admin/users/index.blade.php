@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.users') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.users') }}
    @can('user_add')
    <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.user') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.users') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.user.index')
@endsection
