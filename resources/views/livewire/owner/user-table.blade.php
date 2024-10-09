<div>
    <!-- Search Bar -->
    <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Users</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        
        <button
            x-data x-on:click="$dispatch('open-modal',{name:'add-admin'})"title ="Add Admin Account"
            >
             @include('components.add-renter')
        </button>
                            
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white  shadow-lg">
        <table class="min-w-full mx-2 border-collapse ">
            <thead>
                    @if (session('success'))
                    <tr>
                        <td colspan="8" class="text-center bg-green-200 text-green-700 py-2">
                            {{ session('success') }}
                        </td>
                    </tr>
                    @endif
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Name
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="name" />
                    </th>
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Email
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                    </th>
                    <th wire:click="doSort('Role')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Role
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="role" />
                    </th>
                    <th wire:click="doSort('date')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Date Created
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="date" />
                    </th>
                </tr>
            </thead>


            <tbody>
                @foreach($users as $user)
                @if($user->role !== 'owner')
                <tr class="hover:bg-indigo-100 ">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$user->name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$user->email}}</td>
                    @if($user->role === 'reserve')
                    <td class="py-3 px-4 text-center border-b border-gray-300">customer</td>
                    @else
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$user->role}}</td>
                    @endif
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$user->date}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>   
    </div>  

<!-- Pagination -->
<div class="py-4">
    <div class="flex items-center mb-3">
        <label for="perPage" class="mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
        <select id="perPage" wire:model.live="perPage" class="border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            <option value="" disabled selected>Select</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
        </select>
    </div>
    <div class="mt-4">
    {{ $users->links()}}
    </div>
</div>


