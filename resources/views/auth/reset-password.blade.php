<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-200 p-5 sm:p-8">
            <div class="text-center">
                <!-- Logo -->
                <div class="mb-4">
                    <img src="{{ asset('images/shop_logo_imagee889.png') }}" alt="F1GENZ Shoes" title="F1GENZ Shoes" class="h-12 mx-auto">
                </div>
                
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900">{{ __('Đặt lại mật khẩu') }}</h1>
                <p class="mt-2 text-sm text-gray-600">{{ __('Nhập email và tạo mật khẩu mới cho tài khoản của bạn.') }}</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
                @csrf

                <!-- Token đặt lại mật khẩu -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 py-2.5 text-base" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="email@domain.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mật khẩu mới -->
                <div>
                    <x-input-label for="password" :value="__('Mật khẩu mới')" />
                    <x-text-input id="password" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 py-2.5 text-base" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Xác nhận mật khẩu -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 py-2.5 text-base" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3.5 text-base mt-2">
                    {{ __('Đặt lại mật khẩu') }}
                </x-primary-button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    {{ __('Quay về đăng nhập') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
