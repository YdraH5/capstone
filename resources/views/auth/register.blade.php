<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h2 class="text-3xl font-bold mb-6">Sign up</h2>
        <!-- Name -->
        <div class="mt-2">
            <x-input-label for="name" :value="__('Name')" />
            <input type="text" :value="old('name')" class="mb-3 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autofocus autocomplete="name" name="name"placeholder="Juan Dela Cruz">
            @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>

        <!-- Email Address -->
        <div class="mt-2">
            <x-input-label for="email" :value="__('Email')" />
            <input type="email" :value="old('email')" class="mb-3 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autofocus autocomplete="username" name="email"placeholder="example.email@gmail.com">
            @error('email') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>
        {{-- Phone number --}}
        <div class="mt-2">
            <x-input-label for="mobile" :value="__('Mobile Number (PH)')" />
            <input type="number" placeholder="09XX-XXX-XXXX" pattern="09[0-9]{9}" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" name="phone_number"maxlength="11"minlength="11" required>
            @error('mobile') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>
        <!-- Password -->
        <div class="mt-2">
            <x-input-label for="password" :value="__('Password')" />
            <input type="password" class="mb-3 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autocomplete="new-password" name="password"placeholder="atleast 8 characters">
            @error('password') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>

        <!-- Confirm Password -->
        <div class="mt-2">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <input type="password" class="mb-3 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"required autocomplete="new-password" name="password_confirmation"placeholder="Confirm Password">
            @error('password_confirmation') <span class="error text-red-900">{{ $message }}</span> @enderror 
        </div>

        <div class="flex items-center justify-end mt-2">

            <button class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Sign up
            </button>
        </div>
    </form>
    <p class="mt-2 text-sm text-gray-600">Already have an account? <a wire:navigate href="{{ route('login') }} "class="text-blue-500 hover:underline">Sign in</a></p>
    <p class="mt-6 text-xs text-gray-500">By signing up, you agree with the <a href="#" class="text-blue-500 hover:underline">Terms of Use</a> & <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a></p>
</x-guest-layout>
