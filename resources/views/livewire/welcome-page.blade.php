<div>
<div class="bg-white-200 text-white min-h-screen">
    <div class="bg-white-200 text-white min-h-screen">
        {{-- overview of apartment v2--}}
        <div id="overview"class="bg-white-200">
            <!-- Carousel Section -->
            <div id="carousel" class="relative w-full flex items-center justify-center overflow-hidden bg-slate-300">
                
                <!-- Main Image with Dark Side Overlay -->
                <div class="relative w-full">
                    <img id="carousel-image" src="images/NRNBUILDING3.png" alt="Location Image" class="object-contain w-full h-full max-h-[90vh] clickable-image" />
                    
                    <!-- Dark Overlay for the sides (vignette effect) -->
                    <div class="absolute inset-0 pointer-events-none bg-gradient-to-r from-black/70 via-transparent to-black/20"></div>
                </div>

                <!-- Previous Button -->
                <button id="prev-button" class="absolute left-2 md:left-4 top-1/2 transform -translate-y-1/2 bg-yellow-800 hover:bg-yellow-700 text-white rounded-full p-2 md:p-3 shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Next Button -->
                <button id="next-button" class="absolute right-2 md:right-4 top-1/2 transform -translate-y-1/2 bg-yellow-800 hover:bg-yellow-700 text-white rounded-full p-2 md:p-3 shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        
        </div>
        <hr class="w-full border-t-2 border-gray-300 mt-2 ">

            <!-- Description Section -->
            <div id="about_us"class="text-black flex flex-col items-center justify-center p-5 text-center my-2 ">
                <h3 class="font-heavy text-2xl mb-1">
                About NRN Building
                </h3>
                <hr class="w-1/3 border-t-2 border-gray-300 my-1">
                <p class="font-light leading-7 text-lg mb-5 mx-16">
                Experience the epitome of comfort at our exclusive apartment building in Mission Hills, Roxas City. With 30 elegantly designed rooms, NRN have 2 apartment buildings each of the building have its own parking space reserved for renters. All room have a free aircon that renters could use anytime.
                </p>
            </div>
        <hr class="w-full border-t-2 border-gray-300">

        <div class="text-black flex flex-col items-center justify-center p-5 text-center my-2 " id="near-establishments">
            <h3 class="font-heavy text-2xl mb-1 text-black">
            Nearby Establishments
            </h3>
            <hr class="w-1/3 border-t-2 border-gray-300 mb-4">
    
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8 mx-auto">
                <!-- First 3 Locations (Visible) -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <img src="images/airport.jpg" alt="Roxas Airport" class="w-full h-52 object-cover mb-4 clickable-image">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Roxas Airport</h3>
                        <p class="text-gray-600">Located just 5.1 kilometers from the NRN Building, Roxas Airport offers a quick and scenic route to your destination.</p>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <img src="images/panubbli.jpg" alt="Panubli-on Museum" class="w-full h-52 object-cover mb-4 clickable-image">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Panubli-on Museum</h3>
                        <p class="text-gray-600">Only 3 kilometers away, this museum offers a cultural journey through the region’s rich history and heritage.</p>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <img src="images/palina.jpg" alt="Palina Greenbelt Ecopark" class="w-full h-52 object-cover mb-4 clickable-image">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Palina Greenbelt Ecopark</h3>
                        <p class="text-gray-600">Just 7.5 kilometers away, this ecopark provides easy access to serene natural beauty and outdoor activities.</p>
                    </div>
                </div>

                <!-- Hidden Locations (Initially hidden) -->
                <div class="hidden hidden-establishments bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <img src="images/SM.png" alt="SM City Roxas" class="w-full h-52 object-cover mb-4 clickable-image">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">SM City Roxas</h3>
                        <p class="text-gray-600">Located 4.9 kilometers away, SM City Roxas offers a variety of shopping, dining, and entertainment options.</p>
                    </div>
                </div>

                <div class="hidden hidden-establishments bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <img src="images/GIGANTES.png" alt="Isla Gigantes" class="w-full h-52 object-cover mb-4 clickable-image">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Isla Gigantes</h3>
                        <p class="text-gray-600">Located 71.1 kilometers from the NRN Building, this island offers a perfect getaway with pristine beaches and natural beauty.</p>
                    </div>
                </div>
            </div>
            <!-- See More / See Less Buttons -->
            <div class="text-center mt-8">
                <button id="see-more-button-establishments" class=" transition-transform transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                </svg>

                </button>
                <button id="see-less-button-establishments" class="transition-transform transform hover:scale-105 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
                </svg>

                </button>
            </div>
        </div>
            <hr class="w-full border-t-2 border-gray-300 mt-1">

        <!-- Apartments Section -->
    <div class="bg-white-200 py-8">
        <div id="rooms" class="text-black flex flex-col items-center justify-center p-5 text-center my-2 ">
        <h3 class="font-heavy text-2xl mb-1 text-black"id="reserve">
        Our Popular Apartments We Recommend for You
        </h3>
        <hr class="w-1/2 border-t-2 border-gray-300 mb-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($categories as $category)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
                    <div id="default-carousel-{{$category->category_id}}" class="relative" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="overflow-hidden relative h-56 sm:h-64 xl:h-80 2xl:h-96 ">
                            @foreach ($images[$category->category_id] as $image)
                            <div class="hidden duration-200 ease-in-out" data-carousel-item>
                                <img src="{{ asset($image->image) }}" style="width:100%;height:100%;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 clickable-image" alt="...">
                            </div>
                            @endforeach
                        </div>
                        <!-- Slider indicators -->
                        <div class="flex absolute bottom-5 left-1/2 transform -translate-x-1/2 space-x-3 z-30">
                            @for ($i = 0; $i < $images[$category->category_id]->count(); $i++)
                                <button type="button" class="w-3 h-3 rounded-full bg-yellow-100" aria-current="false" aria-label="Slide {{$i+1}}" data-carousel-slide-to="{{$i}}"></button>
                            @endfor
                        </div>
                        <!-- Slider controls -->
                        <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </button>
                    </div>
                    <!-- Description -->
                    <div class="p-2 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-semibold mb-2 text-gray-700">{{ $category->category_name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $category->description }}</p>
                        <div class="flex items-center mb-4">
                            <h6 class="text-lg sm:text-xl font-semibold text-gray-700 mr-2">Price:</h6>
                            <p class="text-md sm:text-lg text-gray-800">₱{{ number_format($category->price, 2) }}/month</p>
                        </div>
                        <a href="{{ route('visitors.display', ['apartment' => $category->category_id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <hr class="w-full border-t-2 border-gray-300 mt-1">
    
        <div id="location" class="text-black flex flex-col items-center justify-center p-5 text-center my-2 ">
            <h3 class="font-heavy text-2xl mb-1 text-black">
            NRN Building Location
            </h3>
            <hr class="w-1/3 border-t-2 border-gray-300 mb-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.8019578203007!2d122.76057597408091!3d11.56605044413493!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a5f3009ecc8dab%3A0x145584f32319a34c!2sMission%20Hills%20Ave%2C%20Roxas%20City%2C%20Capiz!5e0!3m2!1sen!2sph!4v1728137691267!5m2!1sen!2sph"width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <br/><a class="addmaps" href="https://goo.gl/maps/mffvTWWDzYZ8pcXe9" id="get-map-data">
            </a>
        </div>
    <hr class="w-full border-t-2 border-gray-300">
    <div class="bg-white py-8">
        <div class="text-center">
            <img src="images/OWNER.jpg" alt="Owner Image" class="w-32 h-32 rounded-full mx-auto mb-4 text-black">
            <h3 class="text-2xl font-bold text-black">Rose Denolo Nillos</h3>
        </div>
    </div>
    <div class="bg-white py-8 text-center text-black">
        <h2 class="text-3xl font-semibold mb-4 text-black">CONTACT US</h2>
        <p>Email: nrn.abode@gmail.com</p>
        <p>Phone: 099999999999</p>
    </div>
    
</div>
    <!-- Full-screen Modal -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <img id="modal-image" class="max-w-full max-h-full">
        <span id="close-modal" class="absolute top-2 right-4 text-white text-2xl cursor-pointer">&times;</span>
    </div>
    
</div>


