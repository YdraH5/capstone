<div>
    <!-- Main modal -->
    <div class="hidden fixed inset-y-24 duration-150 ease-in-out z-10 right-0 bottom-0 left-0 flex justify-center" id="modal">
        <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
            <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
            <h1 class="text-2xl font-bold mb-4 text-center">Apartment</h1>
                <!-- Form -->
            <form id="modalForm" class="space-y-4 ">
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
                            <button id="closeModalButton" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
