<div>
    <!-- Main modal -->
    <x-modal name="add-announcement" title="Add Announcement">
        <x-slot:body>
            <!-- Form -->
            <form id="announcementForm" class="space-y-4" wire:submit.prevent="save">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                    <!-- Category -->
                    <div>
                        <label class="block font-medium opacity-70">Category</label>
                        <select wire:model="category" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="all">All</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <!-- Title -->
                    <div>
                        <label class="block font-medium opacity-70">Title</label>
                        <input type="text" wire:model="title" placeholder="Announcement Title" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('title') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <!-- Content -->
                    <div>
                        <label class="block font-medium opacity-70">Content</label>
                        <textarea wire:model="content" placeholder="Announcement Content" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-20 flex items-center pl-3 text-sm border-gray-300 rounded border"></textarea>
                        @error('content') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <!-- Priority -->
                    <div>
                        <label class="block font-medium opacity-70">Priority</label>
                        <select wire:model="priority" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>Select Priority</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                        @error('priority') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block font-medium opacity-70">Status</label>
                        <select wire:model="status" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <!-- Start Date -->
                    <div>
                        <label class="block font-medium opacity-70">Start Date</label>
                        <input type="date" wire:model="start_date" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('start_date') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-between py-8">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    <button x-on:click="$dispatch('close-modal',{name:'add-announcement'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
