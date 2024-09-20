<div>
<div class="bg-yellow-700 text-white min-h-screen">
    <div class="bg-yellow-100 text-white min-h-screen">
        <div class="text-center py-8">
            <h1 class="text-4xl font-bold mb-2 text-black">WELCOME TO NRN ABODE</h1>
            <p class="text-xl text-black">FIND YOUR PERFECT SPACE AT NRN BUILDING.</p>
        </div>
        {{-- overview of apartment v2--}}
        <div class="bg-orange-200 py-8">
            <h2 class="text-3xl text-center font-semibold mb-4 text-black">OVERVIEW OF NRN BUILDING</h2>
            <div id="overview-section" class="grid grid-cols-1 md:grid-cols-3 gap-2 max-w-7xl mx-auto  max-w-7xl mx-auto">
                <div class="bg-yellow-100 shadow-md rounded-lg p-2">
                    <img src="images/NRNBUILDING3.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
                </div>
                <div class="bg-yellow-100 shadow-md rounded-lg p-2">
                    <img src="images/NRNBUILDING1.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
                </div>
                <div class="bg-yellow-100 shadow-md rounded-lg p-2">
                    <img src="images/NRNBUILDING2.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
                </div>
                <div class="bg-yellow-100 shadow-md rounded-lg p-2 hidden">
                    <img src="images/NRNBUILDING.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
                </div>
                <div class="bg-yellow-100 shadow-md rounded-lg p-2 hidden">
                    <img src="images/NRNPARKING.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
                </div>
                <!-- Add more items if needed -->
            </div>
            <div class="text-center mt-4">
                <p class="text-black max-w-7xl mx-auto">
                    Experience the epitome of comfort at our exclusive apartment building in Mission Hills, Roxas City. With 30 elegantly designed rooms, NRN have 2 apartment buildings each of the building have its own parking space reserved for renters. All room have a free aircon that renters could use anytime.
                </p>
                <button id="see-more-button" class="bg-yellow-800 text-white py-2 px-4 rounded mt-4">See More</button>
                <button id="see-less-button" class="bg-yellow-800 text-white py-2 px-4 rounded mt-4 hidden">See Less</button>
            </div>
        </div>

<!-- Near Establishments -->
<div class="bg-orange-200 py-8" id="near-establishments">
    <h2 class="text-3xl text-center font-semibold mb-4 text-black">NEAR ESTABLISHMENTS</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 max-w-7xl mx-auto">
        <!-- Location 1 -->
        <div class="bg-yellow-100 shadow-md rounded-lg p-2">
            <img src="images/airport.jpg" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
            <h3 class="text-2xl font-bold text-black">Roxas Airport</h3>
            <p class="text-black">The distance from the NRN Building to Roxas Airport is just 5.1 kilometers, making for a quick and convenient trip. This short journey offers a brief yet enjoyable glimpse of the local scenery.</p>
        </div>
        <!-- Location 2 -->
        <div class="bg-yellow-100 shadow-md rounded-lg p-2">
            <img src="images/panubbli.jpg" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
            <h3 class="text-2xl font-bold text-black">Panubli-on Museum</h3>
            <p class="text-black">The Panubli-on Museum is conveniently situated just 3 kilometers away from the NRN Building, offering visitors a brief yet enriching journey through the region's cultural heritage.</p>  
        </div>
        <!-- Location 3 -->
        <div class="bg-yellow-100 shadow-md rounded-lg p-2">
            <img src="images/palina.jpg" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
            <h3 class="text-2xl font-bold text-black">Palina Greenbelt Ecopark</h3>
            <p class="text-black">The scenic Palina Greenbelt Ecopark is just 7.5 kilometers from the NRN Building, providing residents and visitors easy access to a beautiful natural retreat. This short distance makes it a convenient spot for those looking to enjoy the serene environment and outdoor activities.</p>
        </div>
        <!-- Add more locations as needed -->
        <div class="bg-yellow-100 shadow-md rounded-lg p-2 hidden">
            <img src="images/SM.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
            <h3 class="text-2xl font-bold text-black">SM City Roxas</h3>
            <p class="text-black">SM City Roxas just 4.9 kilometers away from the NRN Building, you can easily enjoy the short trip to the mall. Once there, you can indulge in a variety of shopping, dining, and entertainment options, making it a perfect spot to unwind and explore.
                Gaisano Grand City Roxas is only 3.8 kilometers from the NRN Building, making it an easy and convenient trip. The mall offers a good selection of shops, dining options, and places to relax.</p>
        </div>
        <div class="bg-yellow-100 shadow-md rounded-lg p-2 hidden">
            <img src="images/GIGANTES.png" alt="Location Image" class="w-full h-48 object-cover mb-4 clickable-image">
            <h3 class="text-2xl font-bold text-black">Isla Gigantes</h3>
            <p class="text-black">Isla Gigantes located 71.1 kilometers from the NRN Building, it's a bit of a journey, but well worth the trip. Enjoy the island adventure, where you can explore pristine beaches, crystal-clear waters, and stunning natural landscapes, making it a perfect getaway.</p>
        </div>
        <!-- Repeat for other locations -->
    </div>
    <div class="text-center mt-4">
        <button id="see-more-button-establishments" class="bg-yellow-800 text-white py-2 px-4 rounded">See More</button>
        <button id="see-less-button-establishments" class="bg-yellow-800 text-white py-2 px-4 rounded hidden">See Less</button>
    </div>
</div>

        <!-- Apartments Section -->
    <div class="bg-orange-200 py-8">
        <div id="apartments" class="container mx-auto px-4 ">
            <h2 class="text-3xl sm:text-4xl font-semibold text-center my-8 text-black" id="reserve">Our Popular Apartments We Recommend for You</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($categories as $category)
                <div class="bg-yellow-100 shadow-lg rounded-lg overflow-hidden">
                    <div id="default-carousel-{{$category->category_id}}" class="relative" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="overflow-hidden relative h-56 sm:h-64 xl:h-80 2xl:h-96">
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
                            <p class="text-md sm:text-lg text-gray-800">{{ $category->price }}</p>
                        </div>
                        <a href="{{ route('visitors.display', ['apartment' => $category->category_id]) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <div class="bg-yellow-100 py-8">
        <div class="text-center">
            <img src="images/OWNER.jpg" alt="Owner Image" class="w-32 h-32 rounded-full mx-auto mb-4 text-black">
            <h3 class="text-2xl font-bold text-black">Rose Denolo Nillos</h3>
        </div>
    </div>
    <div class="bg-yellow-100 py-8">
        <h2 class="text-3xl text-center font-semibold mb-4 text-black">ABOUT US</h2>
        <p class="text-center max-w-2xl mx-auto text-black">WE ARE NRN APARTMENT SERVICES THAT PROVIDES A COMFORTABLE ROOM FOR OUR CUSTOMERS TO STAY HAPPILY EVER AFTER.</p>
    </div>
    <div class="bg-yellow-100 py-8 text-center text-black">
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


