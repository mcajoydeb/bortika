@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.update') . ' ' . trans('menu.tag') }}
@endsection

@section('page-title')
    {{ trans('form-actions.update') . ' ' . trans('menu.tag') }}
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_store') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">{{ trans('menu.products') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.update') . ' ' . trans('menu.tag') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.store.tag.form', compact('term'))
@endsection
