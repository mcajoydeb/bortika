@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.add') . ' ' . trans('menu.role') }}
@endsection

@section('page-title')
    {{ trans('form-actions.add') . ' ' . trans('menu.role') }}
@endsection

@push('page-styles')
    @include('admin.roles.partials.role-styles')
@endpush

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">{{ trans('menu.roles') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.add') . ' ' . trans('menu.role') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.role.form')
@endsection

@push('page-scripts')
    @include('admin.roles.partials.role-scripts')
@endpush
