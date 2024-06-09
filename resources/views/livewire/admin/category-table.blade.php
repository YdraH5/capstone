<div>
    <div class="overflow-x-auto ">
        <table class="mx-2 table-auto h-full w-full border-seperate">
          <thead> 
          @if (session('success'))
          <div class="alert alert-success text-green-500">
              {{ session('success') }}
          </div>    
          @endif
            <tr>
                <th class="text-center border border-black-900 border-2">Category Name</th>
                <th class="text-center border border-black-900 border-2">Description</th>
                <th class="text-center border border-black-900 border-2">Images</th>
                <th class="text-center border border-black-900 border-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="bg-white hover:bg-gray-300 odd:bg-white even:bg-slate-50">
              <td class="text-center border border-black-900 border-2">
                  {{$category->name}}
                </td>
                <td class="text-center border border-black-900 border-2">
                  {{$category->description}}
                </td>
                <td class="text-center border border-black-900 border-2">
                  <div class="flex justify-center items-center">
                    <a wire:navigate href="{{url('admin/categories/'.$category->id.'/upload')}}" class="text-blue-500">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                      </svg>              
                    </a>
                  </div>
                </td>
                <td class="border border-black-900 border-2">
                  <div class="flex justify-center items-center">
                    <button
                        x-data="{ id: {{$category->id}} }"
                        x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-category' })"
                        wire:click="edit(id)"
                        type="button">@include('buttons.edit')
                    </button>
                        @if ($isEditing)
                        <x-modal name="edit-category" title="Edit Category">
                            <x-slot:body>
                                <form wire:submit.prevent="update">
                                    <div>
                                        <input type="hidden"wire:model="id">
                                        <label label="block font-medium">Category Name</label>
                                        <input type="text" wire:model="name" placeholder="Name"class="text-black focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                        @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div>
                                        <label class="block font-medium">Description</label>
                                        <textarea rows="4" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-32 flex items-center pl-3 text-sm border-gray-300 rounded border"wire:model="description" placeholder="Write apartment description here"></textarea>
                                        @error('description') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div class="flex items-center justify-between py-8">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                                        </button>
                                    </div>
                                </form>
                            </x-slot:body>
                        </x-modal>
                        @endif
                    <button
                        x-data="{ id: {{$category->id}} }"
                        x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-category' })"
                        wire:click="delete(id)"
                        type="button"
                        class="my-2">
                          @include('buttons.delete')
                    </button>
                    <x-modal name="delete-category" title="Delete Category">
                        <x-slot name="body">
                            <div class="p-4">
                                <p class="text-lg font-semibold mb-4">Are you sure you want to delete this category?</p>
                                <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                
                                <div class="flex justify-end">
                                    <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-category'})">Cancel</button>
                                    <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                </div>
                            </div>
                        </x-slot>
                    </x-modal>
                  </div>
                </td>
                @endforeach        
            </tr>
        </tbody>
      </table>
      {{ $categories->links('components.pagination')}}

      </div>
      
</div>
