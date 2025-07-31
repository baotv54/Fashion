@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa mã: {{ $coupon->code }}</h2>
    <form action="{{ route('coupons.update', $coupon) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.coupons.form') <!-- Tham chiếu tới form.blade.php -->
    </form>
</div>
@endsection