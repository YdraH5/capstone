    @section('title', 'Full Details')

    @include('layouts-visitor.app')
  <div class="flex flex-col sm:flex-row items-center justify-center bg-white shadow-lg px-32">
    <!-- Image section -->
    <div class="w-full h-auto p-2 bg-white">
        <h3 class="font-heavy text-2xl mb-1 text-black flex justify-center">
            Apartment Gallery
        </h3>
        <div class="h-auto ">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 items-start">
            @if (isset($images[$apartment->id]) && $images[$apartment->id]->isNotEmpty())
                    <!-- First image larger -->
                    <div class="relative group col-span-1 h-80 sm:h-[408px]">
                        <img src="{{ asset($images[$apartment->id][0]->image) }}" 
                            class="block w-full h-full object-cover clickable-image transition-transform duration-300 hover:scale-105" 
                            alt="Featured Apartment Image">
                        <div class="absolute top-0 left-0 mx-2 my-2 bg-black bg-opacity-50 opacity-80 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-10">
                            <span class="text-white text-sm">{{ $images[$apartment->id][0]->description ?? 'No Description Available' }}</span>
                        </div>
                    </div>

                    <!-- Remaining 4 images smaller -->
                    <div class="grid grid-cols-2 gap-2 col-span-1">
                        @foreach ($images[$apartment->id]->take(5) as $key => $image)
                            @if ($key > 0) <!-- Skip the first image since it's already displayed -->
                                <div class="relative group w-full h-52 sm:h-[200px]">
                                    <img src="{{ asset($image->image) }}" 
                                        class="block w-full h-full object-cover clickable-image transition-transform duration-300 hover:scale-105" 
                                        alt="Apartment Image">
                                    <div class="absolute top-0 left-0 mx-2 my-2 bg-black bg-opacity-50 opacity-80 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-10">
                                        <span class="text-white text-sm">{{ $image->description ?? 'No Description Available' }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

   
</div>
<!-- Main container -->
<div class="flex flex-col sm:flex-row items-start justify-between bg-white shadow-lg p-6 space-y-6 sm:space-y-0 sm:space-x-6 px-[140px] min-h-screen">

    <!-- Left side: Apartment details -->
    <div class="w-full sm:w-2/3 text-center sm:text-left flex flex-col justify-center">
        <h1 class="text-3xl font-bold text-gray-800">{{ $apartment->categ_name }}</h1>
        <p class="mt-4 text-gray-600 text-2xl">{{ $apartment->description }}</p>
        <p class="mt-4 text-gray-600 font-semibold">Monthly Rent: ₱{{ number_format($apartment->price, 2) }}</p>
        <p class="mt-4 text-gray-600 font-semibold">Available Rooms: {{ $available }}</p>
    </div>

    <!-- Right side: Livewire component (sticky) -->
    <div class="w-full sm:w-1/3 border border-gray-300 shadow-md bg-white p-4 sticky top-20 self-start">
        <div class="grid grid-cols-1">
            @livewire('view-detail', ['categoryId' => $apartment->categ_id,
                                    'available' => $available,          
                                    'room_available'=>$room_available])
        </div>
    </div>

</div>

<!-- Full-screen Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <img id="modal-image" class="max-w-full max-h-full">
    <span id="close-modal" class="absolute top-2 right-4 text-white text-2xl cursor-pointer">&times;</span>
</div>

<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>