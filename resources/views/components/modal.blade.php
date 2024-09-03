@props(['name', 'title'])

<div 
    x-data="{ show: false, name: '{{$name}}' }"
    x-show="show"
    x-on:open-modal.window="show = ($event.detail.name === name)"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 bg-gray-900 bg-opacity-50"
    style="display:none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-90"
>

    <!-- Modal Background Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-30"></div>

    <!-- Modal Content -->
    <div class="relative z-10 w-full max-w-lg p-6 bg-white rounded-lg shadow-lg transform transition-all">
        <!-- Close Button -->
        <button 
            x-on:click="show = false" 
            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 focus:outline-none"
            aria-label="Close"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Header -->
        @if(isset($title))
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{$title}}
        </h2>
        @endif

        <!-- Modal Body -->
        <div class="py-4">
            {{$body}}
        </div>
    </div>
</div>
