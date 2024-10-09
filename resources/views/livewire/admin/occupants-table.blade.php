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
                    <th wire:click="doSort('renters_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="renters_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('phone_number')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Phone number
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="phone_number" />
                        </div>
                    </th>  
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>                     
                    <th wire:click="doSort('categ_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Type
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="categ_name" />
                        </div>
                    </th>                     
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Lease Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>    
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        Action
                    </th>                   
                    <!-- <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($apartment as $apartments)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->renters_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->phone_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building_name}}-{{$apartments->room_number}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">

                    @if(\App\Models\DueDate::where('user_id', $apartments->user_id)
                                            ->where('status', 'not paid')
                                            ->count() > 0)
                        {{ \App\Models\DueDate::where('user_id', $apartments->user_id)
                                            ->where('status', 'not paid')
                                            ->count() }} Unpaid Months
                    @else
                        Payment Updated
                    @endif
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <div class="flex justify-center gap-1"> 
                        <button x-data x-on:click="$dispatch('open-modal',{name:'out-modal'})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                        </button>

                        <x-modal name="out-modal" title="Departure">
                            <x-slot name="body">
                                <p>Are the renters leaving the apartment today?</p>
                                <div class="flex justify-end space-x-2">
                                    <button x-on:click="$dispatch('close-modal',{name:'out-modal'})" class="bg-gray-500 text-white px-4 py-2 rounded">No</button>
                                    <button wire:click="out({{ $apartments->apartment_id }})" class="bg-blue-500 text-white px-4 py-2 rounded">Yes</button>
                                    </div>
                            </x-slot>
                        </x-modal>

                        </div>
                    </td>
                </tr>
                @endforeach  
            </tbody>

    </table>
    
    </div>

    <div class="py-4">
        <div class="flex items-center mb-3">
            <label for="perPage" class="mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
            <select id="perPage" wire:model.live="perPage" class="border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Select</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
        <div class="mt-4">
        {{ $apartment->links()}}
        </div>
    </div>
  </div>
  
</div>
