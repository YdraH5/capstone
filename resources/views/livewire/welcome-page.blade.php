<div>
<div class="bg-gray-100 text-white min-h-screen">
    <div class="bg-gray-100 text-white min-h-screen">
    <div class="bg-gray-100 text-white px-16 pt-16 relative animate-on-scroll">
    <div class="min-w-full relative">
        <!-- Shared Background -->
        <div class="bg-gradient-to-t from-[#557F8F] to-[#E4FBFF] text-black rounded-[24px] shadow-lg flex items-center relative z-10">
            <!-- Text Section -->
            <div class="flex-1 pr-0 pl-8">
                <p class="text-sm mb-4 opacity-75">Brought to you by NRN Building,</p>
                <p style="font-family:Poppins, sans-serif; font-weight:400;font-size:2rem;" class=" mb-4 leading-tight">Find 
                <span style="font-family:'Playfair Display', serif; font-style:italic; font-weight:700;" class="">
                   Comfort  
                </span><br>
                in every
                <span style="font-family:'Playfair Display', serif; font-style:italic; font-weight:700;" class="">
                   Corner  
                </span><br>
                <p style="font-family:Poppins, sans-serif; font-weight:100;font-size:1rem;">
                Your next home is here. Explore apartments built for living, loving and thriving
                </p>
                </p>
            </div>

            <!-- Image Section -->
            <div class=" max-w-md relative z-20 -ml-8 w-1/3">
                <img  src="images/OVERVIEW.png" 
                    alt="Apartment Image" 
                    class="object-cover rounded-[25px] -mt-12 pr-0 w-full h-full" />
            </div>
        </div>
    </div>
</div>
<!-- Designed for Comfort Section -->
<div class="bg-gray-100 text-black px-16 py-16 animate-on-scroll">
    <div class="min-w-full grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
        <!-- Left Image (Slightly Higher) -->
        <div class="md:col-span-1 flex justify-start -mt-16"> <!-- Adjusted margin -->
            <img src="images/NRNBUILDING.png" alt="Building" class="rounded-lg w-3/4 w-128 h-64 object-cover">
        </div>

        <!-- Center Text -->
        <div class="md:col-span-1 text-center">
            <h2 class="text-3xl font-bold mb-4">Designed for <span class="text-[#89CFF0]">Comfort</span>, built for <span class="text-[#89CFF0]">You</span>.</h2>
            <p class="text-lg leading-relaxed">
                NRN Building in Mission Hills, Roxas City features 30 elegant rooms, dedicated parking, and free air conditioning for your comfort.
            </p>
        </div>

        <!-- Right Image (Slightly Lower) -->
        <div class="md:col-span-1 flex justify-end mt-16"> <!-- Adjusted margin -->
            <img src="images/LIVING.jpg" alt="Living Room Area" class="rounded-lg w-3/4 w-128 h-64 object-cover">
        </div>
    </div>
</div>

<div class="text-black flex flex-col items-center justify-center p-5 text-center my-2 animate-on-scroll" id="near-establishments">
    <h3 class="font-heavy text-2xl mb-1 text-black">
        Nearby Establishments
    </h3>
    <hr class="w-1/3 border-t-2 border-gray-300 mb-4">

    <div class="carousel-container overflow-hidden relative px-16">
        <div class="carousel-wrapper flex transition-transform duration-500">
            <!-- Loop through the nearby establishments -->
            @foreach($nearby as $establishment)
                <div class="carousel-item w-full md:w-1/3 px-4">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200 flex flex-col h-full">
                        <!-- Image Section -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $establishment->image_url) }}" alt="{{ $establishment->name }}" class="w-full h-52 object-cover mb-4 clickable-image">
                        </div>
                        <!-- Text Section -->
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $establishment->name }}</h3>
                            <p class="text-gray-600 flex-grow">Located just {{$establishment->distance}} kilometers from the NRN Building, {{ $establishment->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Carousel Navigation Buttons -->
        <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 px-16 bg-gray-800 text-white rounded-full shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m15 19-7-7 7-7" />
            </svg>
        </button>
        <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 p-4 bg-gray-800 text-white rounded-full shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
            </svg>
        </button>
    </div>
</div>


<script>
    // Carousel logic
    const carouselWrapper = document.querySelector('.carousel-wrapper');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    let currentIndex = 0;

    // Set initial width for carousel to display 3 items by default
    const itemsToShow = 3;
    const itemWidth = carouselItems[0].clientWidth;

    // Show the first 3 items
    const showItems = () => {
        carouselWrapper.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
    };

    // Next button
    nextButton.addEventListener('click', () => {
        if (currentIndex < carouselItems.length - itemsToShow) {
            currentIndex++;
            showItems();
        }
    });

    // Previous button
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            showItems();
        }
    });

    // Show items initially
    showItems();
</script>

<style>
    .carousel-container {
        position: relative;
        width: 100%;
    }

    .carousel-wrapper {
        display: flex;
        transition: transform 0.5s ease;
    }

    .carousel-item {
        flex: 0 0 auto;
    }

    .carousel-prev, .carousel-next {
        top: 50%;
        position: absolute;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
    }

    .carousel-prev {
        left: 10px;
    }

    .carousel-next {
        right: 10px;
    }
</style>

            <hr class="w-full border-t-2 border-gray-300 mt-1">

        <!-- Apartments Section -->
    <div class="bg-gray-100 py-8">
        <div id="rooms" class="text-black flex flex-col items-center justify-center p-5 text-center my-2 ">
        <h3 class="font-heavy text-2xl mb-1 text-black"id="reserve">
        Apartments We Recommend for You
        </h3>
        <hr class="w-1/2 border-t-2 border-gray-300 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-w-full px-16">
    @foreach ($categories as $category)
    <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:bg-slate-200">
        <div id="default-carousel-{{$category->category_id}}" class="relative group" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-56 sm:h-64 xl:h-80 2xl:h-96 shadow-md">
                @foreach ($images[$category->category_id] as $image)
                <div class="hidden duration-200 ease-in-out" data-carousel-item>
                    <img src="{{ asset($image->image) }}" style="width:100%;height:100%;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2 clickable-image" alt="...">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            <div class="flex absolute bottom-5 left-1/2 transform -translate-x-1/2 space-x-3 z-30">
                @for ($i = 0; $i < $images[$category->category_id]->count(); $i++)
                    <button type="button" class="w-2 h-2 rounded-full bg-white" aria-current="false" aria-label="Slide {{$i+1}}" data-carousel-slide-to="{{$i}}"></button>
                @endfor
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group-hover:opacity-100 opacity-0 transition-opacity" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </span>
            </button>
            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group-hover:opacity-100 opacity-0 transition-opacity" data-carousel-next>
                <span class="inline-flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-yellow-100/30 group-hover:bg-yellow-100/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </button>
        </div>
        <!-- Description -->
        <div class="p-2 sm:p-6">
            <h3 class="text-left text-xl sm:text-2xl font-semibold mb-2 text-gray-700">{{ $category->category_name }}</h3> <!-- Left-aligned text -->
            <div class="flex items-center mb-4">
                <h6 class="text-lg sm:text-xl font-semibold text-gray-700 mr-2">Price:</h6>
                <p class="text-md sm:text-lg text-gray-800">₱{{ number_format($category->price, 2) }}/month</p>
            </div>
            <button wire:click="viewDetails({{ $category->category_id }})" 
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">
                View Details
            </button>
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
            @if($owner)
                <div class="bg-white py-8 text-center text-black">
                    <h2 class="text-3xl font-semibold mb-4 text-black">CONTACT US</h2>

                    <p>Owner:{{ $owner->name }} </p>
                    <p>Email:{{ $owner->email }} </p>
                    <p>Mobile Number:{{ $owner->phone_number }} </p>
                </div>
            @else
                <p class="text-gray-500">No owner information available.</p>
            @endif

        </div>
    </div>

    
</div>
    <!-- Full-screen Modal -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <img id="modal-image" class="max-w-full max-h-full">
        <span id="close-modal" class="absolute top-2 right-4 text-white text-2xl cursor-pointer">&times;</span>
    </div>
    
</div>


