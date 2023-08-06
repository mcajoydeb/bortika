@extends('public.layouts.master-public-layout')

@section('page-title')
    {{ trans('public-basic.login') }}
@endsection

@section('content')
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i>{{ trans('public-basic.home') }}</a>
                    <span>{{ trans('public-basic.login') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>{{ trans('public-basic.login') }}</h2>
                    <form method="POST" action="{{ route('public.login') }}">
                        @csrf
                        <div class="group-input">
                            <label for="email">{{ trans('user.email') }} *</label>
                            <input type="text" id="email" name="email" autofocus
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
                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <label for="save-pass">
                                    {{ trans('auth.remember_me') }} ?
                                    <input type="checkbox" id="save-pass" name="remember">
                                    <span class="checkmark"></span>
                                </label>
                                <a href="#" class="forget-pass">{{ trans('auth.forget_password') }}?</a>
                            </div>
                        </div>
                        <button type="submit" class="site-btn login-btn">{{ trans('auth.sign_in') }}</button>
                    </form>
                    <div class="switch-login">
                        <a href="{{ route('public.register') }}" class="or-login"> {{ trans('auth.create_an_account') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
