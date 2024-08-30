<title>Login</title>

<x-guest-layout >


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if (session('success'))
    <div class="text-green-700">
        {{ session('success') }}
    </div>   
    @endif 
    <h2 class="text-3xl font-bold mb-6">Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <input type="email" :value="old('email')"placeholder="example.email@gmail.com" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autofocus autocomplete="username" name="email">
            @error('email') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <input type="password" placeholder="Password"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autofocus name="password">
            @error('password') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
        <div class="flex items-center justify-end mt-4">

            <button class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Sign in
            </button>
        </div>
    </form>
    <p class="mt-4 text-sm text-gray-600">Don't have an account? <a wire:navigate href="{{ route('register') }} "class="text-blue-500 hover:underline">Sign up</a></p>
</x-guest-layout>

