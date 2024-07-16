<div>
    
    <!-- Main modal -->
<x-modal name="add-apartment" title="Add Apartment">
        <x-slot:body>
                <!-- Form -->
                <form id="modalForm" class="space-y-4" wire:submit.prevent="save">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                        <div>
                            <label class="block font-medium opacity-70">Category Name</label>
                            <select wire:model="category_id" placeholder="Category" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                <option value="" disabled selected hidden>Category</option>
                                @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="error text-red-900">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium opacity-70">Building</label>
                            <select wire:model="building" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
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
                            <select wire:model="status" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
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
                        <button x-on:click="$dispatch('close-modal',{name:'add-apartment'})" wire:click = "close()"type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                    </div>
                </form>
                
        </x-slot:body>
</x-modal>

   
</div>
