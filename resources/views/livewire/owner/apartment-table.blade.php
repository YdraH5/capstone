<div> 
     <!-- Search Bar -->
     <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm no-print">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Apartments</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        <button onclick="window.print()" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print Report
        </button>
        <button class="no-print" x-data x-on:click="$dispatch('open-modal',{name:'add-apartment'})"title ="Add appartment">
            @include('buttons.add')
        </button> 
    </div>
    <!-- Table -->
     <!-- Hidden in Web, Visible in Print -->
     <div class="print-only bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-6 text-indigo-600">Apartment Report</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-blue-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-blue-600">Available</h3>
                <p class="text-4xl font-bold">{{ $availableCount }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-green-600">Occupied</h3>
                <p class="text-4xl font-bold">{{ $occupiedCount }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-yellow-600">Reserved</h3>
                <p class="text-4xl font-bold">{{ $reservedCount }}</p>
            </div>
            <div class="bg-red-100 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-red-600">Unavailable</h3>
                <p class="text-4xl font-bold">{{ $unavailableCount }}</p>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
                @if (session('success'))
                <div class="alert alert-success text-green-700">
                    {{ session('success') }}
                </div>    
                @endif
                
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('room_number')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Number
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="room_number" />
                        </div>
                    </th>               
                    <th wire:click="doSort('building')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Building
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building" />
                        </div>
                    </th>  
                    <th wire:click="doSort('categ_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Category
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="categ_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('renters_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Renters/Reservist
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="renters_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Occupants
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>
                    <th class="no-print py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($apartment as $apartments)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->room_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                    @if($apartments->renters_name == NULL)
                    <td class="py-3 px-4 text-center border-b border-gray-300">Vacant</td>
                    @else
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                            {{$apartments->renters_name}}
                    @endif
                        </td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->status}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                        @php
                        $occupants = App\Models\Reservation::where('user_id', $apartments->renter_id)
                            ->select('occupants')
                            ->get();
                        @endphp
                        @foreach ($occupants as $reservation)
                            {{ $reservation->occupants }}
                        @endforeach
                        </td>
                        <td class="no-print py-3 px-4 text-center border-b border-gray-300">
                            <div class="flex justify-center gap-1"> 
                            <button
                                x-data="{ id: {{$apartments->id}} }"
                                x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-apartment' })"
                                wire:click="edit(id)"
                                title ="Edit" 
                                type="button"
                                class="my-2">
                            @include('buttons.edit')
                            </button>
                            @if($isEditing)
                            <x-modal name="edit-apartment" title="Edit Apartment">
                                <x-slot:body>
                                        <!-- Form -->
                                        <form id="modalForm" class="space-y-4" wire:submit.prevent.live="update">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                                                <div>
                                                    <label class="block font-medium opacity-70">Category Name</label>
                                                    <select wire:model="category_id" placeholder="Category" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                        <option value="" disabled selected hidden>Category</option>
                                                        @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id') <span class="error text-red-900">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block font-medium opacity-70">Category Name</label>
                                                    <select wire:model="building_id" placeholder="Building" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                        <option value="" disabled selected hidden>Building</option>
                                                        @foreach ($buildings as $building)
                                                        <option value="{{$building->id}}">{{$building->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id') <span class="error text-red-900">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block font-medium opacity-70">Room Number</label>
                                                    <input type="number" wire:model="room_number" placeholder="Room #" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                    @error('room_number') <span class="error text-red-900">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block font-medium opacity-70">Status</label>
                                                    <select wire:model="status" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                        <option value="" disabled selected hidden>Status</option>
                                                        <option value="Available">Available</option>
                                                        <option value="Unavailable">Unavailable</option>
                                                        <option value="Maintenance">Maintenance</option>
                                                    </select>
                                                    @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between py-8">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                                <button x-on:click="$dispatch('close-modal',{name:'add-apartment'})"type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                                            </div>
                                        </form> 
                                </x-slot:body>
                            </x-modal>
                             @endif
                             
                            <button
                                x-data="{ id: {{$apartments->id}} }"
                                x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-apartment' })"
                                wire:click="delete(id)"
                                title ="Delete" 
                                type="button"
                                class="my-2">
                                @include('buttons.delete')
                            </button>
                            @if($isDeleting)
                            <x-modal name="delete-apartment" title="Delete Apartment">
                                <x-slot name="body">
                                    <div class="p-4">
                                        <p class="text-lg font-semibold mb-4">Are you sure you want to delete this apartment?</p>
                                        <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                        
                                        <div class="flex justify-end">
                                            <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-apartment'})">Cancel</button>
                                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-modal>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach  
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="py-4">
        <div class="flex items-center mb-3">
            <label for="perPage" class="mr-2 mt-2 text-sm font-medium text-gray-700 no-print">Per Page:</label>
            <select id="perPage" wire:model.live="perPage" class="no-print border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
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
