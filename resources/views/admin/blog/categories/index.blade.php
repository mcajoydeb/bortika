@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.categories') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.categories') }}
    @can('post_category_add')
    <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.category') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.categories') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.blog.category.index')
@endsection
