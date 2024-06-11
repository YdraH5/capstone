
<div class="bg-gray-900 text-white min-h-screen">
    <div class="relative h-screen">
        <div id="hero-carousel" class="carousel relative h-full overflow-hidden">
            <div class="carousel-slide active" style="background-image: url('images/NRNBUILDING.png');"></div>
            <div class="carousel-slide hidden" style="background-image: url('images/NRN LOGO.png');"></div>
            <div class="carousel-slide hidden" style="background-image: url('images/test.jpg');"></div>
            <div class="absolute inset-0 bg-black opacity-60"></div>
            <div class="relative z-10 flex items-center justify-center h-full">
                <div class="text-center text-white">
                    <h1 class="text-5xl font-bold mb-4">Welcome to NRN Abode</h1>
                    <p class="text-lg mb-6">Experience luxury and indulgence at our exquisite apartment in the heart of the Philippines. Immerse yourself in opulence and enjoy world-class amenities and services tailored to your every need.</p>
                </div>
            </div>
            <button id="prev-slide" class="prev absolute top-1/2 left-0 transform -translate-y-1/2 text-4xl font-bold text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-r focus:outline-none">&#10094;</button>
            <button id="next-slide" class="next absolute top-1/2 right-0 transform -translate-y-1/2 text-4xl font-bold text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-l focus:outline-none">&#10095;</button>
        </div>
    </div>

    
    
         <!-- Apartments Section -->
         <div id="apartments" class="container mx-auto py-16 px-4">
            <h2 class="text-4xl font-semibold text-center mb-12">Our Popular Apartments We Recommend for You</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($categories as $category)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div id="default-carousel-{{$category->category_id}}" class="relative" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="overflow-hidden relative h-56 sm:h-64 xl:h-80 2xl:h-96">
                            @foreach ($images[$category->category_id] as $image)
                            <div class="hidden duration-200 ease-in-out" data-carousel-item>
                                <img src="{{ asset($image->image) }}" style="width:100%;height:100%;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <!-- Slider indicators -->
                        <div class="flex absolute bottom-5 left-1/2 transform -translate-x-1/2 space-x-3 z-30">
                            @for ($i = 0; $i < $images[$category->category_id]->count(); $i++)
                                <button type="button" class="w-3 h-3 rounded-full bg-white" aria-current="false" aria-label="Slide {{$i+1}}" data-carousel-slide-to="{{$i}}"></button>
                            @endfor
                        </div>
                        <!-- Slider controls -->
                        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-6 h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-6 h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </button>
                    </div>
                    <!-- Description -->
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold mb-2 text-gray-700">{{ $category->category_name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                        <div class="flex items-center mb-4">
                            <h6 class="text-xl font-semibold text-gray-700 mr-2">Price:</h6>
                            <p class="text-lg text-gray-800">{{ $category->price }}</p>
                        </div>
                        {{-- <div class="flex items-center mb-4">
                            <span class="text-yellow-500">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < 4.5) <!-- Assuming a static rating of 4.5 -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 1l1.82 5.59h5.81L12.93 9.5l1.56 5.41H11.82L10 16.03 8.18 14.91H4.56l1.56-5.41L2.37 6.59h5.81L10 1z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.9 1.97L12 6.56l4.14.38a.3.3 0 01.17.54l-3.02 2.77.89 4.47a.3.3 0 01-.45.33l-3.95-2.29-3.95 2.29a.3.3 0 01-.45-.33l.89-4.47-3.02-2.77a.3.3 0 01.17-.54l4.14-.38L9.9 1.97a.3.3 0 01.54 0z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </span>
                            <span class="text-gray-700 ml-2">4.5</span>
                        </div> --}}
                        <a href="{{ route('visitors.display', ['apartment' => $category->category_id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        