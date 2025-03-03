<div>
    <!-- Search Bar -->
    <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Nearby Establishments</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-establishment'})"title="add announcement">
        @include('buttons.add')
    </button> 
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
                <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success text-green-700 mb-4 p-4 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>    
            @endif
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Name</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Description</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Distance</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Image</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($nearbyEstablishments as $establishment)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $establishment->name }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $establishment->description }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ $establishment->distance }} km</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <img src="{{ asset('storage/' . $establishment->image_url) }}" alt="{{ $establishment->name }}" class="w-20 h-20 object-cover rounded-md" />
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <button
                            x-data="{ id: {{$establishment->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-establishment' })"
                            title="edit"
                            wire:click="edit(id)"
                            type="button">@include('buttons.edit')
                        </button>
                        <button
                            x-data="{ id: {{$establishment->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-nearby' })"
                            wire:click="delete(id)"
                            title ="Delete" 
                            type="button"
                            class="my-2">
                            @include('buttons.delete')
                        </button>
                        @if($isEditing)
                        <x-modal name="edit-establishment" title="Edit Nearby Establishment">
                            <x-slot:body>
                                <!-- Form -->
                                <form id="establishmentForm" class="space-y-4" wire:submit.prevent="update">
                                    <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                                        <div>
                                            <label class="block font-medium opacity-70">Name</label>
                                            <input type="text" wire:model="name" placeholder="Name" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block font-medium opacity-70">Description</label>
                                            <textarea wire:model="description" placeholder="Description" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-24 flex items-center pl-3 text-sm border-gray-300 rounded border"></textarea>
                                            @error('description') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block font-medium opacity-70">Distance (in km)</label>
                                            <input type="number" wire:model="distance" placeholder="Distance in km" step="0.01" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            @error('distance') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block font-medium opacity-70">Image</label>
                                            
                                            <!-- File Input -->
                                            <input type="file" wire:model="image_url" 
                                                class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            @error('image_url') <span class="error text-red-900">{{ $message }}</span> @enderror
                                            
                                            <!-- Preview Section -->
                                            <div class="mt-4">
                                            @if ($image_url && method_exists($image_url, 'temporaryUrl'))
                                                <img src="{{ $image_url->temporaryUrl() }}" alt="Preview">
                                            @elseif ($image_url && is_string($image_url))
                                                <img src="{{ asset('storage/' . $image_url) }}" alt="Preview">
                                            @endif
                                            </div>
                                        </div>


                                    </div>
                                    <div class="flex items-center justify-between py-8">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        <button x-on:click="$dispatch('close-modal',{name:'add-establishment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                                    </div>
                                </form>
                            </x-slot:body>
                        </x-modal>
                        @endif
                        @if($isDeleting)
                            <x-modal name="delete-nearby" title="Delete Nearby Establishment">
                                <x-slot name="body">
                                    <div class="p-4">
                                        <p class="text-lg font-semibold mb-4">Are you sure you want to delete this establishment in the system?</p>
                                        <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                        
                                        <div class="flex justify-end">
                                            <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-apartment'})">Cancel</button>
                                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-modal>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
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
            {{ $nearbyEstablishments->links() }}
        </div>
    </div>
</div>
