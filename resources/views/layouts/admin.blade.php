<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminKit CSS -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.sidebar') <!-- Tùy bạn -->
        <div class="main">
            @include('layouts.partials.navbar') <!-- Tùy bạn -->
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
</body>
</html>
