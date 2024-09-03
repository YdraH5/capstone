<div>
    <x-modal name="add-category" title="Add Category">
        <x-slot:body>
            <form id="modalForm" class="space-y-4 "wire:submit.prevent="save">
                <div class="">
                        <div>
                            <label class="block font-medium opacity-70">Category Name</label>
                            <input type="text" wire:model="name" class=" text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" placeholder="Category Name">
                            @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror 
                        </div>
                        <div>
                            <label class="block font-medium opacity-70">Price</label>
                            <input type="number" wire:model="price" placeholder="Price" class=" text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            @error('price') <span class="error text-red-900">{{ $message }}</span> @enderror 
                        </div>
                        <div>
                            <label class="block font-medium opacity-70">Description</label>
                            <textarea rows="4" class=" text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-32 flex items-center pl-3 text-sm border-gray-300 rounded border"wire:model="description" placeholder="Write apartment description here"></textarea>
                            @error('description') <span class="error text-red-900">{{ $message }}</span> @enderror 
                        </div>
                        <div class="flex items-center justify-between py-8">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                            <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
