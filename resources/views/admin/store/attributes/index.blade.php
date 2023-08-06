@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.attributes') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.attributes') }}
    <a href="{{ route('admin.product-attributes.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.attribute') }}</a>
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_store') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans('menu.products') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.attributes') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.store.attribute.index')
@endsection
