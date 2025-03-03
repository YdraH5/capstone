<div>
    <x-modal name="add-establishment" title="Add Nearby Establishment">
        <x-slot:body>
            <!-- Form -->
            <form id="establishmentForm" class="space-y-4" wire:submit.prevent="save">
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
                        <input type="file" wire:model="image" 
                            class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('image') <span class="error text-red-900">{{ $message }}</span> @enderror
                        
                        <!-- Preview Section -->
                        <div class="mt-4">
                            @if ($image)
                                <p class="text-sm text-gray-600 mb-2">Image Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="w-40 h-40 object-cover rounded">
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
</div>
