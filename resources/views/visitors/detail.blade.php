@section('title', 'Full Details')

@include('layouts-visitor.app')

@foreach ($apartment as $detail)
<div class="flex flex-col bg-yellow-100 lg:flex-row items-center justify-center bg-white shadow-lg rounded-lg min-h-screen">
    <div class="w-full lg:w-1/2 h-screen">
        <div id="default-carousel" class="relative h-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-full rounded-lg">
                @if (isset($images[$detail->id]) && $images[$detail->id]->isNotEmpty())
                    @foreach ($images[$detail->id] as $image)
                        <div class="hidden duration-200 ease-in-out h-full" data-carousel-item>
                            <img src="{{ asset($image->image) }}" class="block w-full h-full object-cover" alt="">
                        </div>
                    @endforeach
                @endif
            </div>
            @if (isset($images[$detail->id]) && $images[$detail->id]->isNotEmpty())
                <!-- Slider indicators -->
                <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                    @for ($i = 0; $i < $images[$detail->id]->count(); $i++)
                        <button type="button" class="w-3 h-3 rounded-full bg-gray-800" aria-label="Slide {{ $i + 1 }}" data-carousel-slide-to="{{ $i }}"></button>
                    @endfor
                </div>
            @endif
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-white/30 group-hover:bg-white/50 rounded-full">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </span>
            </button>
            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-white/30 group-hover:bg-white/50 rounded-full">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
    <div class="w-full lg:w-1/2 text-center lg:text-left p-8 flex flex-col justify-center">
        <h1 class="text-3xl font-bold text-gray-800">{{ $detail->categ_name }}</h1>
        <p class="mt-4 text-gray-600">{{ $detail->description }}</p>
        <p class="mt-4 text-gray-600 font-semibold">Monthly Rent: ₱{{ $detail->price }}.00</p>
        <p class="mt-4 text-gray-600 font-semibold">Available Rooms: {{ $available }}</p>
        <div class="mt-6">
            @if ($available > 0)
                <a href="{{ route('reserve.index', ['apartment' => $detail->id]) }}">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Reserve
                    </button>
                </a>
            @else
                <button class="bg-gray-300 text-gray-600 px-6 py-3 rounded-full cursor-not-allowed opacity-50" disabled>
                    No Rooms Available
                </button>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        x-data x-on:click="$dispatch('open-modal', { name: 'notify-me' })">
                    Notify Me
                </button>
                <x-modal name="notify-me" title="Notify Me!">
                    <x-slot name="body">
                        <div class="p-4">
                            <p class="text-lg text-gray-600 font-semibold mb-4">
                                By opting in for notifications, you agree to receive emails regarding the availability of rooms in this apartment. We respect your privacy and will not share your email address with third parties.
                            </p>
                            <p class="text-gray-600 mb-8">
                                You can unsubscribe from these notifications at any time by following the link provided in the email. For more details on how we handle your personal information, please refer to our privacy policy.
                            </p>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal', { name: 'notify-me' })">Cancel</button>
                                <a href="{{ route('emails.notify') }}" class="bg-blue-500 hover:bg-blue-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    Accept
                                </a>
                            </div>
                        </div>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </div>
</div>
@endforeach

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
