<div>
    <x-modal name="add-category" title="Add Category">
        <x-slot:body>
            <!-- Make the modal body scrollable -->
            <div>
                <form id="modalForm"  class="overflow-y-auto max-h-[400px]" wire:submit.prevent="save">
                    <div class="">
                        <!-- Category Name -->
                        <div>
                            <label class="block font-medium opacity-70">Category Name</label>
                            <input type="text" wire:model="name" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center  text-sm border-gray-300 rounded border" placeholder="Category Name">
                            @error('name') <span class="error text-red-900">{{ $message }}</span> @enderror 
                        </div>
                        
                        <!-- Price -->
                        <div>
                            <label class="block font-medium opacity-70">Price</label>
                            <input type="number" wire:model="price" placeholder="Price" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center  text-sm border-gray-300 rounded border">
                            @error('price') <span class="error text-red-900">{{ $message }}</span> @enderror 
                        </div>

                        <!-- Number of Pax -->
                        <div>
                            <label class="block mt-4">Max Number of Tenants</label>
                            <input type="number" wire:model="features.pax" placeholder="Pax" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center  text-sm border-gray-300 rounded border" min="1">
                            @error('features.pax') <span class="error text-red-900">{{ $message }}</span> @enderror
                        </div>

                        <!-- Features Checkboxes (2-column layout) -->
                        <div class="grid grid-cols-2 mt-1">
                            <label class="block">
                                <input type="checkbox" wire:model="features.cr"> CR
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.livingRoom"> Living Room
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.kitchen"> Kitchen
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.aircon"> Aircon
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.bed"> Wooden Bed
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.parking"> Parking Space
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.balcony"> Balcony
                            </label>
                            <label class="block">
                                <input type="checkbox" wire:model="features.other"> Other
                            </label>
                        </div>

                        <!-- Other Text Input -->
                        <div>
                            <input type="text" wire:model="features.otherText" placeholder="Specify other features" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center  text-sm border-gray-300 rounded border" />
                            @error('features.otherText') <span class="error text-red-900">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit & Close Buttons -->
                        <div class="flex items-center justify-between py-8">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                            <button x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </x-slot:body>
    </x-modal>
</div>
