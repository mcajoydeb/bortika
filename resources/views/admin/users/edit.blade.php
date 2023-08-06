@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.update') . ' ' . trans('menu.user') }}
@endsection

@push('page-styles')
    @include('admin.users.partials.user-styles')
@endpush

@section('page-title')
    {{ trans('form-actions.update') . ' ' . trans('menu.user') }}
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">{{ trans('menu.users') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.update') . ' ' . trans('menu.user') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.user.form', compact('user'))
@endsection

@push('page-scripts')
    @include('admin.users.partials.user-scripts')
@endpush
