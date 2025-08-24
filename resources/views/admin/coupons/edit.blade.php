@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container">
    <h2>Chỉnh sửa mã: {{ $coupon->code }}</h2>
    <form action="{{ route('coupons.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.coupons.form') <!-- Tham chiếu tới form.blade.php -->
    </form>
</div>
@endsection
