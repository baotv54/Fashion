@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Danh sách màu sắc</h2>

    <a href="{{ route('colors.create') }}" class="btn btn-primary mb-3">Thêm màu mới</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên màu</th>
                <th>Mã màu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colors as $color)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $color->name }}</td>
                <td>
                    <span style="display: inline-block; width: 30px; height: 30px; background: {{ $color->code }}"></span>
                    {{ $color->code }}
                </td>
                <td>
                    <a href="{{ route('colors.edit', $color->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('colors.destroy', $color->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
