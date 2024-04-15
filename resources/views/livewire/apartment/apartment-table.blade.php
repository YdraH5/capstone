<div> 
  <div>
    <input wire:model.debounce.100ms.live="search" type="search"placeholder="Search...." class="mb-5 mt-2 text-black-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-1/3 h-8 flex items-center pl-3 text-sm border-black rounded border">
  </div>
  <div class="overflow-x-auto">
    <table class="table-auto w-full border-seperate max-w-7xl">
        <thead> 
        @if (session('success'))
        <div class="alert alert-success text-green-700">
            {{ session('success') }}
        </div>    
        @endif
          <tr class="bg-gray-300 rounded">
              <th class="text-center border border-black-900 border-2">Category Name</th>
              <th class="text-center border border-black-900 border-2">Renter</th>
              <th class="text-center border border-black-900 border-2">Room Number</th>
              <th class="text-center border border-black-900 border-2">Price</th>
              <th class="text-center border border-black-900 border-2">Building</th>
              <th class="text-center border border-black-900 border-2">Status</th>
              <th class="text-center border border-black-900 border-2">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach($apartment as $apartments)
          <tr>
              <td class="text-center border border-black-900 border-2">{{$apartments->categ_name}}</td>
                  @if($apartments->renters_name == NULL)
                  <td class="text-center border border-black-900 border-2 text-red-500">
                      Vacant
                  </td>
                  @else
                  <td class="text-center border border-black-900 border-2">
                      {{$apartments->renters_name}}
                  </td>
                  @endif
              <td class="text-center border border-black-900 border-2">{{$apartments->room_number}}</td>
              <td class="text-center border border-black-900 border-2">{{$apartments->price}}/month</td>
              <td class="text-center border border-black-900 border-2">{{$apartments->building}}</td>
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
                                        <label class="block font-medium opacity-70">Price</label>
                                        <input type="number" wire:model="price" placeholder="Price" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                        @error('price') <span class="error text-red-900">{{ $message }}</span> @enderror 
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
                                            <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                            </x-slot:body>
                          </x-modal>
                        @endif
                      <form action="{{route('admin.apartment.delete',['apartment'=>$apartments->id])}}" method="post">
                          @csrf 
                          @method('delete')
                            <button class="my-2">
                              @include('buttons.delete')
                            </button>
                </div>
                      </form>
              </td>
          </tr>
          @endforeach  
      </tbody>

    </table>
  </div>
  
</div>
