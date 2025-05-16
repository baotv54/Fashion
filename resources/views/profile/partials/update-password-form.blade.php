<div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5>Đổi mật khẩu</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" id="current_password" class="form-control" autocomplete="current-password">
                @error('current_password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" id="password" class="form-control" autocomplete="new-password">
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                @error('password_confirmation')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>

            @if (session('status') === 'password-updated')
                <span class="text-success ms-3">Đã lưu.</span>
            @endif
        </form>
    </div>
</div>
