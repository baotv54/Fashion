<div class="card mb-4 shadow-sm">
    <div class="card-header bg-danger text-white">
        <h5>Xóa tài khoản</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">
            Khi tài khoản của bạn bị xóa, toàn bộ dữ liệu sẽ bị xóa vĩnh viễn. Vui lòng chắc chắn rằng bạn đã sao lưu các thông tin quan trọng trước khi thực hiện thao tác này.
        </p>

        <!-- Nút mở modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Xóa tài khoản
        </button>

        <!-- Modal xác nhận -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Xác nhận xóa tài khoản</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa tài khoản không? Vui lòng nhập mật khẩu để xác nhận.</p>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
                                @if ($errors->userDeletion->has('password'))
                                    <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger">Xóa tài khoản</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
