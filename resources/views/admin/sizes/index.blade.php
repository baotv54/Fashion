@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Danh sách kích thước</h2>

    <a href="{{ route('sizes.create') }}" class="btn btn-primary mb-3">Thêm kích thước mới</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên kích thước</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $size)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $size->name }}</td>
                <td>
                    <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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