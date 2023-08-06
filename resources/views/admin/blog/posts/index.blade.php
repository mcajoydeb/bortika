@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.post') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.post') }}
    @can('post_add')
    <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.post') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.blogs') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.posts') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.blog.post.index')
@endsection
