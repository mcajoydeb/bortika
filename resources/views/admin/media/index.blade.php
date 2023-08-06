@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.all') . ' ' . trans('menu.media') }}
@endsection

@section('page-title')
    {{ trans('menu.all') . ' ' . trans('menu.media') }}
    @can('media_add')
    <a href="{{ route('admin.media.create') }}" class="btn btn-sm btn-outline-primary">{{ trans('menu.add') . ' ' . trans('menu.media') }}</a>
    @endcan
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.manage_media') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.media') }}</li>
        </ol>
    </div>
@endsection

@section('page-content')
    @livewire('admin.media.index')
@endsection
