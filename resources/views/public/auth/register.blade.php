@extends('public.layouts.master-public-layout')

@section('page-title')
    {{ trans('public-basic.register') }}
@endsection

@section('content')
<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> {{ trans('public-basic.home') }}</a>
                    <span> {{ trans('public-basic.register') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->

<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="register-form">
                    <h2> {{ trans('public-basic.register') }}</h2>
                    <form method="POST" action="{{ route('public.register') }}">
                        @csrf
                        <div class="group-input">
                            <label for="name">{{ trans('user.name') }} *</label>
                            <input type="text" id="name" name="name"
                                class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="group-input">
                            <label for="email">{{ trans('public-basic.email') }} *</label>
                            <input type="text" id="email" name="email"
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="group-input">
                            <label for="password">{{ trans('user.password') }} *</label>
                            <input type="password" id="password" name="password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="group-input">
                            <label for="password_confirmation">{{ trans('user.password_confirmation') }} *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                            class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                        <button type="submit" class="site-btn register-btn">{{ trans('public-basic.register') }}</button>
                    </form>
                    <div class="switch-login">
                        <a href="{{ route('public.login') }}" class="or-login">Or {{ trans('public-basic.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->
@endsection
