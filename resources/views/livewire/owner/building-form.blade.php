<div>
    <x-modal name="add-building" title="Add Building">
        <x-slot:body>
                <!-- Form -->
                <form id="modalForm" class="space-y-4" wire:submit.prevent="save">
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

</div>
