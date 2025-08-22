<!-- <h2 class="mb-3">Quản trị Live Chat - Danh sách cuộc trò chuyện</h2> -->

<style>
    .table { width: 100%; }
    .table thead th { position: sticky; top: 0; z-index: 1; background: #f8fafc; box-shadow: inset 0 -1px 0 #e5e7eb; }
    .table tbody tr { opacity: 0; transform: translateY(6px); animation: rowIn .24s ease-out forwards; }
    .table tbody tr:hover { background: #f8fafc; }
    .table tbody tr td, .table thead th { transition: background-color .2s ease; }
    .table .btn { transition: transform .12s ease, box-shadow .12s ease; }
    .table .btn:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,.08); }

    /* Stagger effect for first 12 rows */
    .table tbody tr:nth-child(1)  { animation-delay: 0s; }
    .table tbody tr:nth-child(2)  { animation-delay: .03s; }
    .table tbody tr:nth-child(3)  { animation-delay: .06s; }
    .table tbody tr:nth-child(4)  { animation-delay: .09s; }
    .table tbody tr:nth-child(5)  { animation-delay: .12s; }
    .table tbody tr:nth-child(6)  { animation-delay: .15s; }
    .table tbody tr:nth-child(7)  { animation-delay: .18s; }
    .table tbody tr:nth-child(8)  { animation-delay: .21s; }
    .table tbody tr:nth-child(9)  { animation-delay: .24s; }
    .table tbody tr:nth-child(10) { animation-delay: .27s; }
    .table tbody tr:nth-child(11) { animation-delay: .30s; }
    .table tbody tr:nth-child(12) { animation-delay: .33s; }

    @keyframes rowIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .filters { display: flex; gap: 8px; margin-bottom: 16px; }
    .badge-open { background: #10b981; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .badge-closed { background: #ef4444; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
    .user-cell { display: flex; align-items: center; gap: 8px; }
    .user-cell img { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb; }
</style>

<!-- <form method="get" class="filters">
    <input type="number" name="product_id" value="{{ request('product_id') }}" class="form-control" placeholder="Lọc theo ID sản phẩm">
    <select name="status" class="form-select" style="max-width: 200px;">
        <option value="">-- Tất cả trạng thái --</option>
        <option value="open" {{ request('status')==='open' ? 'selected' : '' }}>Mở</option>
        <option value="closed" {{ request('status')==='closed' ? 'selected' : '' }}>Đóng</option>
    </select>
    <button class="btn btn-primary">Lọc</button>
    <a href="{{ route('admin.plc.index') }}" class="btn btn-secondary">Bỏ lọc</a>
</form> -->

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($threads as $t)
                    <tr>
                        <td>
                            @php
                                $name = $t->user->name ?? 'Khách ẩn danh';
                                $avatar = $t->user->avatar ?? null;
                                if ($avatar) {
                                    if (\Illuminate\Support\Str::startsWith($avatar, 'public/')) {
                                        $avatar = substr($avatar, 7);
                                    }
                                    $isUrl = \Illuminate\Support\Str::startsWith($avatar, ['http://','https://','/']);
                                    // Avatar đang được lưu tại public_path('avatars') theo ProfileController
                                    $avatarUrl = $isUrl ? $avatar : asset('avatars/' . ltrim($avatar, '/'));
                                }
                            @endphp
                            <div class="user-cell">
                                @if(!empty($avatar))
                                    <img src="{{ $avatarUrl }}" alt="avatar" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=E5E7EB&color=374151&size=64';">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=E5E7EB&color=374151&size=64" alt="avatar">
                                @endif
                                <span>{{ $name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($t->status==='open')
                                <span class="badge-open">Mở</span>
                            @else
                                <span class="badge-closed">Đóng</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.plc.index', array_merge(request()->query(), ['id' => $t->id])) }}" class="btn btn-sm btn-outline-primary">Chi tiết</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Chưa có cuộc trò chuyện nào</td>  
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
