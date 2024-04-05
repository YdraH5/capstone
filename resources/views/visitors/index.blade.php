@section('title', 'Home')
  @include('layouts-visitor.app')
<div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 bg-white shadow rounded-lg p-4">
  <!-- Filter options -->
  <div class="w-full md:w-auto flex items-center space-x-2">
      <label for="price" class="text-gray-700 font-medium">Price:</label>
      <select id="price" name="price" class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-blue-500 w-full md:w-40">
          <option value="0">Any</option>
          <option value="1">$</option>
          <option value="2">$$</option>
          <option value="3">$$$</option>
      </select>
  </div>
  
  <div class="w-full md:w-auto flex items-center space-x-2">
      <label for="rating" class="text-gray-700 font-medium">Rating:</label>
      <select id="rating" name="rating" class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-blue-500 w-full md:w-40">
          <option value="0">Any</option>
          <option value="1">1 Star</option>
          <option value="2">2 Stars</option>
          <option value="3">3 Stars</option>
          <option value="4">4 Stars</option>
          <option value="5">5 Stars</option>
      </select>
  </div>
  
  <div class="w-full md:w-auto flex items-center space-x-2">
      <label for="type" class="text-gray-700 font-medium">Type:</label>
      <select id="type" name="type" class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-blue-500 w-full md:w-40">
          <option value="0">Any</option>
          <option value="1">Studio Type 1</option>
          <option value="2">Studio Type 2</option>
          <option value="3">Big Room</option>
      </select>
  </div>
  
  <!-- Apply Button -->
  <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-60">
      Apply Filters
  </button>
</div>
@foreach($apartment as $apartments)

<div class="flex flex-col lg:flex-row items-center justify-center space-y-4 lg:space-y-0 lg:space-x-8 bg-white shadow-md rounded-lg p-4">
<div class="max-w-2xl w-full">

	<div id="default-carousel" class="relative" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
            @foreach ($images[$apartments->id] as $image)
            <div class="hidden duration-200 ease-in-out" data-carousel-item>
                <img src="{{ asset($image->image) }}"style="width:200px;height:200px;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
            </div>
            @endforeach
        </div>
        <!-- Slider indicators -->
        
        <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
            @for ($i = 0;$i < $images[$apartments->id]->count(); $i++)
             <button type="button" value="{{$i}}" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            @endfor
        </div>
        <!-- Slider controls -->
        <button type="button" class="flex absolute top-0 left-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 opacity-30 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span class="hidden">Previous</span>
            </span>
        </button>
        <button type="button" class="flex absolute top-0 right-0 z-30 justify-center items-center px-4 h-full cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 opacity-30 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="hidden">Next</span>
            </span>
        </button>
    </div>

	
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</div>
  <!-- Description -->
  <div class="w-full lg:w-1/2">
    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{$apartments->categ_name}}</h2>
    <span class="text-gray-700 font-medium">Description</span>
      <p class="text-gray-700 mb-4">{{$apartments->description}}</p>
      <div class="flex items-center space-x-4">
          <span class="text-gray-700 font-medium">Rating:</span>
          <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 1l1.82 5.59h5.81L12.93 9.5l1.56 5.41H11.82L10 16.03 8.18 14.91H4.56l1.56-5.41L2.37 6.59h5.81L10 1z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-700">4.5</span>
          </div>
      </div>
      
      <div class="flex items-center space-x-4">
          <span class="text-gray-700 font-medium">Price:</span>
          <span class="text-gray-700">{{$apartments->price}}</span>
      </div>
      <a href="{{route('visitors.display',['apartment'=>$apartments->id])}}">
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            View Details
        </button>
        </a>
  </div>
</div>
@endforeach



