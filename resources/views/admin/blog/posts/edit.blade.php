@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('form-actions.update') . ' ' . trans('menu.post') }}
@endsection

@section('page-title')
    {{ trans('form-actions.update') . ' ' . trans('menu.post') }}
@endsection

@push('page-styles')
    @include('admin.blog.posts.partials.post-styles')
@endpush

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.posts.index') }}">{{ trans('menu.posts') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('form-actions.update') . ' ' . trans('menu.post') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.blog.post.form', compact('post'))
@endsection

@push('page-scripts')
    @include('admin.blog.posts.partials.post-scripts')
@endpush
