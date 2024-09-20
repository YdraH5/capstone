<div>
  <!-- Search Bar -->
  <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
    <div class="flex gap-2 text-gray-700">
        <h1 class="text-2xl font-semibold text-black">Buildings Management</h1>
    </div>
    <div class="relative w-1/2 ml-auto">
        <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
            class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
        </svg>
    </div>
    
    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-building'})">
        @include('buttons.add')
    </button> 
    </div>

    {{-- table --}}
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
              @if (session('success'))
              <div class="alert alert-success text-green-500">
                  {{ session('success') }}
              </div>    
              @endif
              <tr class="bg-indigo-500 text-white uppercase text-sm">
                <th class="py-3 px-4 text-center border-b border-indigo-600">Building Name</th>
                <th class="py-3 px-4 text-center border-b border-indigo-600">Number of Units</th>
                <th class="py-3 px-4 text-center border-b border-indigo-600">WIth parking Space?</th>
                <th class="py-3 px-4 text-center border-b border-indigo-600">Date</th>
                <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach($buildings as $building)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                      {{$building->name}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                      {{$building->units}}
                    </td>
                    @if($building->parking_space === 1)
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                      YES
                    </td>
                    @else
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        NO
                    </td>
                    @endif
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        {{$building->created_at->format('F j, Y')}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                      <div class="flex justify-center items-center">
                        <button
                            x-data="{ id: {{$building->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-building' })"
                            wire:click="edit(id)"
                            type="button">@include('buttons.edit')
                        </button>
                        @if ($isEditing)
                        <x-modal name="edit-building" title="Edit Building">
                            <x-slot:body>
                                    <!-- Form -->
                                    <form id="modalForm" class="space-y-4" wire:submit.prevent="update">
                                        <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                                            <div>
                                                <label class="block font-medium opacity-70">Building Name</label>
                                                <input type="text" wire:model="name" placeholder="Building Name" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block font-medium opacity-70">Number of Units</label>
                                                <input type="number" wire:model="units" placeholder="Number of Units" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                @error('units') <span class="error text-red-900">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="block font-medium opacity-70">Parking Space</label>
                                                <select wire:model="parking_space" class=" text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                    <option value="" disabled selected hidden>WIth Parking Space?</option>
                                                    <option value="1">Yes</option>
                                                    <option value="2">No</option>
                                                </select>
                                                @error('parking_space') <span class="error text-red-900">{{ $message }}</span> @enderror
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
                            x-data="{ id: {{$building->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-building' })"
                            wire:click="delete(id)"
                            type="button"
                            class="my-2">
                              @include('buttons.delete')
                        </button>
                        @if ($isDeleting)
                        <x-modal name="delete-building" title="Delete Building">
                            <x-slot name="body">
                                <div class="p-4">
                                    <p class="text-lg font-semibold mb-4">Are you sure you want to delete this building?</p>
                                    <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                    
                                    <div class="flex justify-end">
                                        <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-category'})">Cancel</button>
                                        <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                    </div>
                                </div>
                            </x-slot>
                        </x-modal>
                        @endif
                      </div>
                    </td>
                    @endforeach        
                </tr>
            </tbody>
        </table>
        {{-- {{ $buildings->links('components.pagination')}}   --}}
</div>
