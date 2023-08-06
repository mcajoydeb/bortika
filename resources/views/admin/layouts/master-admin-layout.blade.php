<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts.head-meta')
    @include('admin.layouts.styles')
    @livewireStyles
    @stack('page-styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed {{ Cookie::get('sidebar-collapse') }}">
    <div class="wrapper">

        @include('admin.layouts.navbar')
        @include('admin.layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">
                                @yield('page-title')
                            </h1>
                        </div>
                        @yield('breadcrumb')
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <x-admin.alert.alert></x-admin>
                    @yield('page-content')
                </div>
            </section>

        </div>

        @include('admin.layouts.footer')
    </div>

    <x-admin.general.loader />

    @include('admin.layouts.scripts')
    @livewireScripts
    @include('admin.partials.livewire-browser-events')
    @stack('page-scripts')
</body>
</html>
