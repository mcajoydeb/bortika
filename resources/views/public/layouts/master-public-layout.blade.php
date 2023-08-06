<!DOCTYPE html>
<html lang="zxx">
<head>
    @include('public.layouts.partials.head-meta')
    <title>@yield('page-title')</title>
    @include('public.layouts.partials.public-styles')
    @livewireStyles
    @stack('page-styles')
</head>

<body>
    @include('public.layouts.partials.preloader')
    @include('public.layouts.partials.header')

    @yield('content')

    @include('public.layouts.partials.footer')
    @include('public.layouts.partials.public-scripts')
    @livewireScripts
    @stack('page-scripts')
</body>

</html>
