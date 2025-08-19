<div class="card mb-4 shadow-sm">
    <!-- <div class="card-header bg-success text-white">
        <h5>Cập nhật thông tin</h5>
    </div> -->
    <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="update-profile-form">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="avatar" class="form-label">Ảnh đại diện</label>
                <div class="mb-2">
                    @if ($user->avatar)
                        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar" width="100"
                            class="rounded-circle">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default" width="100"
                            class="rounded-circle">
                    @endif
                </div>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                @error('avatar')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="form-control"
                    value="{{ old('phone', $user->phone) }}" required>
                @error('phone')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <small class="text-muted">
                            Địa chỉ email của bạn chưa được xác minh.
                            <button type="submit" form="send-verification" class="btn btn-link p-0">Nhấn vào đây để gửi
                                lại email xác minh.</button>
                        </small>
                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success mt-1">Email xác minh đã được gửi lại.</div>
                        @endif
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success ms-3">Đã lưu.</span>
            @endif
        </form>
    </div>
</div>
