<div> 
     <!-- Search Bar -->
     <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Occupants</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        
        <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-apartment'})"title ="Add appartment">
            @include('buttons.add')
        </button> 
    </div>
    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
                @if (session('success'))
                <div class="alert alert-success text-green-700">
                    {{ session('success') }}
                </div>    
                @endif
                
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Renter</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Contact Info</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Email</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Room Type</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Room Info</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartment as $apartments)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->renters_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->phone_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building_name}}-{{$apartments->room_number}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                            <div class="flex justify-center gap-1"> 
                          
                        </div>
                    </td>
                </tr>
                @endforeach  
            </tbody>

    </table>
    
    </div>
    {{ $apartment->links()}}
  </div>
  
</div>
