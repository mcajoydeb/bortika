@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.products') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.products') }}
    @can('product_add')
    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.product') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_store') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.products') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.store.product.index')
@endsection
