@extends('public.layouts.master-public-layout')

@section('page-title')
{{ trans('public-basic.shop') }}
@endsection

@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ trans('public-basic.home') }}</a>
                    <span>{{ trans('public-basic.shop') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section Begin -->

@livewire('frontend.shop')

@endsection
