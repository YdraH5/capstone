<div>
  <!-- Search Bar -->
  <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
    <div class=" flex gap-2 text-gray-700">
      <h1 class="text-2xl font-semibold text-black">Announcements Management</h1>
    </div>
    <div class="relative w-1/2 ml-auto">
        <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
            class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
        </svg>
    </div>
    
    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-announcement'})"title="add announcement">
        @include('buttons.add')
    </button> 
  </div>
       <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            @if (session('success'))
                <div class="alert alert-success text-green-700">
                    {{ session('success') }}
                </div>    
            @endif
            <thead>
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Audience
                        </div>
                    </th>               
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Title
                        </div>
                    </th>  
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Content
                        </div>
                    </th>  
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Priority
                        </div>
                    </th>  
                    <th  class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Status
                        </div>
                    </th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Start Date
                        </div>
                    </th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($announcements as $announcement)
                <tr class="hover:bg-indigo-100">
                    @php
                        $category = \App\Models\Category::find($announcement->category);
                    @endphp
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        {{ $category ? $category->name : 'Unknown Category' }}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->title}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->content}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->priority}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$announcement->status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                    {{\Carbon\Carbon::parse($announcement->start_date)->format('F d, Y')}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <button
                            x-data="{ id: {{$announcement->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'edit-announcement' })"
                            title="edit"
                            wire:click="edit(id)"
                            type="button">@include('buttons.edit')
                        </button>
                            @if($isEditing)
                            <x-modal name="edit-announcement" title="Edit Announcement">
                                <x-slot:body>
                                    <!-- Form -->
                                    <form id="announcementForm" class="space-y-4" wire:submit.prevent="update">
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
                            @endif
                            @if($isDeleting)
                            <x-modal name="delete-announcement" title="Delete Announcement">
                                <x-slot name="body">
                                    <div class="p-4">
                                        <p class="text-lg font-semibold mb-4">Are you sure you want to delete this announcement?</p>
                                        <p class="text-gray-600 mb-8">This action cannot be undone. Please confirm.</p>
                                        
                                        <div class="flex justify-end">
                                            <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal',{name:'delete-apartment'})">Cancel</button>
                                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" wire:click="deleted">Delete</button>
                                        </div>
                                    </div>
                                </x-slot>
                            </x-modal>
                        @endif
                        <button
                            x-data="{ id: {{$announcement->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'delete-announcement' })"
                            wire:click="delete(id)"
                            title ="Delete" 
                            type="button"
                            class="my-2">
                            @include('buttons.delete')
                        </button>
                    </td>
                </tr>
                @endforeach  
            </tbody>
        </table>
    </div>
      
</div>
