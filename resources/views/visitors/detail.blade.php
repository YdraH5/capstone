@section('title', 'Full details')
@include('layouts-visitor.app')

@foreach ($apartment as $detail)

<div class="flex flex-col lg:flex-row items-center justify-center space-y-4 lg:space-y-0 lg:space-x-8 bg-white shadow-md rounded-lg p-4">
    <div class="max-w-2xl w-full">
    
      <div id="default-carousel" class="relative" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="overflow-hidden relative h-56 rounded-lg sm:h-64 xl:h-80 2xl:h-96">
                @foreach ($images[$detail->id] as $image)
                <div class="hidden duration-200 ease-in-out" data-carousel-item>
                    <img src="{{ asset($image->image) }}"style="width:200px;height:200px;" class="block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
                @endforeach
            </div>
            <!-- Slider indicators -->
            
            <div class="flex absolute bottom-5 left-1/2 z-30 space-x-3 -translate-x-1/2">
                @for ($i = 0;$i < $images[$detail->id]->count(); $i++)
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
  </div>
  <div class="flex flex-row items-center justify-center space-y-4 lg:space-y-0 lg:space-x-8 bg-white shadow-md rounded-lg p-4">
    <div class="max-w-2xl w-full">
      <div class="relative text-center">
        <h1 class="text-red-500">SENTENCE NOT CONSTRUCT YET!!!</h1>
        <a href="{{route('reserve.form',['apartment'=>$detail->id])}}">
          <input type="button" value="Reserve"class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mt-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </a>
      </div>
    </div>
  </div>     
@endforeach
