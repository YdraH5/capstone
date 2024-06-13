@section('title', 'Full Details')

@include('layouts-visitor.app')

@foreach ($apartment as $detail)
<div class="flex flex-col lg:flex-row items-center justify-center space-y-6 lg:space-y-0 lg:space-x-10 bg-white shadow-lg rounded-lg p-8 min-h-screen">
    <div class="max-w-2xl w-full">
        <div id="default-carousel" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-80 rounded-lg">
                @foreach ($images[$detail->id] as $image)
                <div class="hidden duration-200 ease-in-out" data-carousel-item>
                    <img src="{{ asset($image->image) }}" style="width:100%;height:100%;" class="block w-full h-full object-cover absolute top-0 left-0 rounded-lg" alt="Apartment Image">
                </div>
                @endforeach
            </div>
            
            <!-- Slider indicators -->
            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                @for ($i = 0; $i < $images[$detail->id]->count(); $i++)
                <button type="button" class="w-3 h-3 rounded-full bg-gray-800" aria-label="Slide {{ $i + 1 }}" data-carousel-slide-to="{{ $i }}"></button>
                @endfor
            </div>
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
    <div class="max-w-2xl w-full text-center lg:text-left">
        <h1 class="text-3xl font-bold text-gray-800">{{ $detail->categ_name }}</h1>
        <p class="mt-4 text-gray-600">{{ $detail->description }}</p>
        <p class="mt-4 text-gray-600 font-semibold">Monthly Rent: ₱{{ $detail->price }}.00</p>
        <p class="mt-4 text-gray-600 font-semibold">Available Rooms: {{ $available }}</p>
        <div class="mt-6">
            <a href="{{ route('reserve.index', ['apartment' => $detail->id]) }}">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Reserve
                </button>
            </a>
        </div>
    </div>
</div>
@endforeach

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
