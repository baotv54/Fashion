    <!-- Bảng hóa đơn -->
    <div class="col-xxl-12">
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Đơn hàng gần đây</h5>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Mã đơn</th>
                            <th>Ngày</th>
                            <th>Khách hàng</th>
                            <th>Trạng thái</th>
                            <th>Phương thức</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestOrders as $order)
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" title="Chi tiết đơn hàng">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </button>

                                <!-- Modal Chi tiết đơn hàng -->
                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Chi tiết đơn hàng: #{{ $order->order_code }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered mb-4">
                                                    <tr>
                                                        <th>Người đặt</th>
                                                        <td>{{ $order->user->name ?? 'Khách vãng lai' }}
                                                            <br>
                                                            <small>{{ $order->email }}</small>
                                                            <br>
                                                            <small>{{$order->phone}}</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ngày đặt</th>
                                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Trạng thái</th>
                                                        <td>
                                                            @php
                                                            $map = [
                                                            'ordered' => 'Đã đặt',
                                                            'processing' => 'Đang xử lý',
                                                            'confirmed' => 'Đã xác nhận',
                                                            'shipping' => 'Đang giao',
                                                            'delivered' => 'Đã giao',
                                                            'cancelled' => 'Đã hủy',
                                                            'returned' => 'Trả hàng',
                                                            ];
                                                            @endphp
                                                            <span class="badge bg-label-{{ $order->status == 'cancelled' ? 'danger' : 'primary' }}">
                                                                {{ $map[$order->status] ?? 'Không xác định' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Phương thức thanh toán</th>
                                                        <td>{{ ucfirst($order->payment_method) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tổng tiền</th>
                                                        <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Hành động</th>
                                                        <td>
                                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @php
                                                                $nextStatus = [
                                                                'ordered' => 'processing',
                                                                'processing' => 'confirmed',
                                                                'confirmed' => 'shipping',
                                                                'shipping' => 'delivered',
                                                                ];

                                                                $statusLabel = [
                                                                'ordered' => 'Đang xử lý',
                                                                'processing' => 'Đã xác nhận',
                                                                'confirmed' => 'Đang giao hàng',
                                                                'shipping' => 'Đã giao',
                                                                ];

                                                                $current = $order->status;
                                                                @endphp

                                                                @if (array_key_exists($current, $nextStatus))
                                                                <input type="hidden" name="status" value="{{ $nextStatus[$current] }}">
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    Cập nhật: {{ $statusLabel[$current] }}
                                                                </button>
                                                                @elseif ($current === 'delivered')
                                                                <span class="badge bg-label-success">Đã hoàn tất</span>
                                                                @elseif ($current === 'cancelled')
                                                                <span class="badge bg-label-danger">Đã hủy</span>
                                                                @elseif ($current === 'returned')
                                                                <span class="badge bg-label-warning">Trả hàng</span>
                                                                @else
                                                                <span class="badge bg-label-secondary">Không xác định</span>
                                                                @endif
                                                            </form>
                                                        </td>
                                                </table>

                                                <h6 class="mb-3">Danh sách sản phẩm:</h6>
                                                <table class="table table-sm table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sản phẩm</th>
                                                            <th>Biến thể</th>
                                                            <th>Giá</th>
                                                            <th>Số lượng</th>
                                                            <th>Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderDetails as $detail)
                                                        <tr>
                                                            <td>{{ $detail->product_name }}</td>
                                                            <td>{{ $detail->variation_name ?? 'Mặc định' }}</td>
                                                            <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="text-end">
                                                    <strong>Tổng cộng: {{ number_format($order->total, 0, ',', '.') }} VNĐ</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="{{ route('orders.details', $order->id) }}"><span>#{{ $order->order_code }}</span></a></td>
                            <td><span class="text-nowrap">{{ $order->created_at->format('d/m/Y, H:i') }}</span></td>
                            <td>
                                <div class="d-flex justify-content-start align-items-center order-name text-nowrap">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($order->user->name ?? 'K', 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="m-0">
                                            <a href="#" class="text-heading">{{ $order->user->name ?? 'Khách vãng lai' }}</a>
                                        </h6>
                                        <small>{{ $order->email }}</small>
                                        <small>{{$order->phone}}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                $map = [
                                'ordered' => ['text' => 'Đã đặt', 'color' => 'primary'],
                                'processing' => ['text' => 'Đang xử lý', 'color' => 'info'],
                                'confirmed' => ['text' => 'Đã xác nhận', 'color' => 'success'],
                                'shipping' => ['text' => 'Đang giao', 'color' => 'warning'],
                                'delivered' => ['text' => 'Đã giao', 'color' => 'success'],
                                'cancelled' => ['text' => 'Đã hủy', 'color' => 'danger'],
                                ];
                                $status = $map[$order->status] ?? ['text' => 'Không xác định', 'color' => 'secondary'];
                                @endphp
                                <span class="badge px-2 bg-label-{{ $status['color'] }}">
                                    {{ $status['text'] }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-nowrap">
                                    <span class="ms-1">{{ ucfirst($order->payment_method) }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /Invoice table -->