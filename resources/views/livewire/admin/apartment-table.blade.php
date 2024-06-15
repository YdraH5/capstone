<div> 
    <div class="flex justify-start mx-2 mb-5 mt-2">
        <input wire:model.debounce.300ms.live="search" type="search" placeholder="Search...."
            class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
    </div>
    <div class="overflow-x-auto ">
    <table class="table-auto w-full mx-2 border-seperate">
    <thead> 
        @if (session('success'))
        <div class="alert alert-success text-green-700">
            {{ session('success') }}
        </div>    
        @endif
            <tr class="bg-gray-300 rounded">
              <th class="text-center border border-black-900 border-2">Category Name</th>
              <th class="text-center border border-black-900 border-2">Renter</th>
              <th class="text-center border border-black-900 border-2">Building</th>
              <th class="text-center border border-black-900 border-2">Room Number</th>
              <th class="text-center border border-black-900 border-2">Status</th>
              <th class="text-center border border-black-900 border-2">Actions</th>
          </tr>
    </thead>
    <tbody>
        @foreach($apartment as $apartments)
            <tr class="bg-white hover:bg-gr`ay-300 odd:bg-white even:bg-slate-50">
                <td class="text-center border border-black-900 border-2">{{$apartments->categ_name}}</td>
            @if($apartments->renters_name == NULL)
                <td class="text-center border border-black-900 border-2 text-red-500">Vacant</td>
            @else
                <td class="text-center border border-black-900 border-2">
                      {{$apartments->renters_name}}
            @endif
                </td>
                <td class="text-center border border-black-900 border-2">{{$apartments->building}}</td>
                <td class="text-center border border-black-900 border-2">{{$apartments->room_number}}</td>
                <td class="text-center border border-black-900 border-2">{{$apartments->status}}</td>
                <td class=" border border-black-900 border-2">
                <div class="flex justify-center"> 
                    <button
                        x-data="{ id: {{$apartments->id}} }"
                        x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-apartment' })"
                        wire:click="edit(id)"
                        type="button"
                        class="my-2">
                    @include('buttons.edit')
                    </button>
                    @if ($isEditing)
                        <x-modal name="edit-apartment" title="Edit Apartment">
                            <x-slot:body>
                              <form id="modalForm" class="space-y-4 "wire:submit.prevent="update">
                                <div class="lg:columns-2 xl:columns-2">
                                    <div> 
                                        <label class="block font-medium opacity-70">Category Name</label>
                                        <select wire:model="category_id" placeholder="Category"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            <option value="" disabled selected hidden>Category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div>
                                        <label class="block font-medium opacity-70">Status</label>
                                        <select wire:model="building"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            <option value="" disabled selected hidden>Building</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                        @error('building') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div>
                                        <label class="block font-medium opacity-70">Room Number</label>
                                        <input type="text" wire:model="room_number" placeholder="Room #" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                        @error('room_number') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div>
                                        <label class="block font-medium opacity-70">Status</label>
                                        <select wire:model="status"class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                            <option value="" disabled selected hidden>Status</option>
                                            <option value="Available">Available</option>
                                            <option value="Unavailable">Unavailable</option>
                                            <option value="Maintenance">Maintenance</option>
                                        </select>
                                        @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                        <div class="flex items-center justify-between py-8">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                            <button wire:click="closeModal" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                              </form>
                            </x-slot:body>
                        </x-modal>
                    @endif
                    <button
                        x-data="{ id: {{$apartments->id}} }"
                        x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-apartment' })"
                        wire:click="delete(id)"
                        type="button"
                        class="my-2">
                          @include('buttons.delete')
                    </button>
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
                </div>
              </td>
          </tr>
        @endforeach  
      </tbody>

    </table>
    
    </div>
    {{ $apartment->links('components.pagination')}}
  </div>
  
</div>
