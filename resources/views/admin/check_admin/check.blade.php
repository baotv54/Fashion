@php
    use Illuminate\Support\Facades\Auth;

    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Bạn không có quyền truy cập.');
    }
@endphp
