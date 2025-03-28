@extends('layouts.app')

@section('title', 'Danh mục giày')

@section('content')
    <h2 class="mb-4">Danh mục giày</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Danh mục cha</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <strong>{{ $category->name }}</strong>
                                @if ($category->children->count() > 0)
                                    <ul>
                                        @foreach ($category->children as $child)
                                            <li>{{ $child->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{{ $category->parent ? $category->parent->name : 'Danh mục gốc' }}</td>
                            <td>
                                <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
