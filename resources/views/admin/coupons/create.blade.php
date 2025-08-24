@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container">
    <h2>Thêm mã giảm giá mới</h2>

    <form action="{{ route('coupons.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
        @include('admin.coupons.form')
    </form>
</div>
@endsection
