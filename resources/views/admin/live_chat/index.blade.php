@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị Live Chat - Danh sách</title>
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
    <style>
        .container { max-width: 1200px; margin: 24px auto; }
        .table { width: 100%; }
        .filters { display: flex; gap: 8px; margin-bottom: 16px; }
        .badge-open { background: #10b981; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .badge-closed { background: #ef4444; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-3">Quản trị Live Chat - Danh sách cuộc trò chuyện</h2>

    <form method="get" class="filters">
        <input type="number" name="product_id" value="{{ request('product_id') }}" class="form-control" placeholder="Lọc theo Product ID">
        <select name="status" class="form-select" style="max-width: 200px;">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="open" {{ request('status')==='open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ request('status')==='closed' ? 'selected' : '' }}>Closed</option>
        </select>
        <button class="btn btn-primary">Lọc</button>
        <a href="{{ route('admin.plc.index') }}" class="btn btn-secondary">Reset</a>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>User ID</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($threads as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            <td>{{ $t->product_id }}</td>
                            <td>{{ $t->user_id ?? '-' }}</td>
                            <td>
                                @if($t->status==='open')
                                    <span class="badge-open">open</span>
                                @else
                                    <span class="badge-closed">closed</span>
                                @endif
                            </td>
                            <td>{{ $t->created_at }}</td>
                            <td>{{ $t->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.plc.show', $t->id) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Chưa có thread nào</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $threads->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
@endsection
