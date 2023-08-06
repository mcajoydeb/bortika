@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.add') . ' ' . trans('menu.media') }}
@endsection

@section('page-title')
    {{ trans('form-actions.add') . ' ' . trans('menu.media') }}
@endsection

@push('page-styles')
<link rel="stylesheet" href="{{ asset('theme/plugins/dropzone/css/main.css') }}">
@endpush

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_media') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">{{ trans('menu.media') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.add') . ' ' . trans('menu.media') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.media.create')
@endsection

@push('page-scripts')
<x-admin.media.drop-zone-js-init />
@endpush
