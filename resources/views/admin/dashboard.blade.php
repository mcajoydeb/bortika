@extends('admin.layouts.master-admin-layout')

@section('title')
    {{ trans('menu.dashboard') }}
@endsection

@section('page-title')
    {{ trans('menu.dashboard') }}
@endsection

@section('breadcrumb')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ trans('menu.home') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('menu.dashboard') }}</li>
        </ol>
    </div>
@endsection
