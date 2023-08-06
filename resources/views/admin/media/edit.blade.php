@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.edit') . ' ' . trans('menu.media') }}
@endsection

@section('page-title')
    {{ trans('form-actions.edit') . ' ' . trans('menu.media') }}
@endsection

@push('page-styles')
<link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
<style>
    /* Ensure the size of the image fit the container perfectly */
    img {
        display: block;
        max-width: 100%; /* This rule is very important, please don't ignore this */
    }
</style>
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
    @livewire('admin.media.edit', compact('media'))
@endsection

@push('page-scripts')
    <script src="{{ asset('js/cropper.js') }}"></script>
@endpush
