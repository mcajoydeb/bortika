@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.add') . ' ' . trans('menu.category') }}
@endsection

@section('page-title')
    {{ trans('form-actions.add') . ' ' . trans('menu.category') }}
@endsection

@push('page-styles')
    @include('admin.partials.plugin-styles')
@endpush

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.categories.index') }}">{{ trans('menu.categories') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.add') . ' ' . trans('menu.category') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.blog.category.form')
@endsection

@push('page-scripts')
    @include('admin.partials.plugin-scripts')
@endpush
