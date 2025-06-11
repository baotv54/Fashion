<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('Frontend.partials.head')
</head>
<body>
    @include('Frontend.partials.header')

    <main class="main-layout">
        @yield('content')
    </main>

    @include('Frontend.partials.footer')
</body>
</html> 