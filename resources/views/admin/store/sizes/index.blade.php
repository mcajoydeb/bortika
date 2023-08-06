@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.sizes') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.sizes') }}
    <a href="{{ route('admin.product-sizes.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.size') }}</a>
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_store') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans('menu.products') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.sizes') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.store.size.index')
@endsection
