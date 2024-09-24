<div> 
     <!-- Search Bar -->
     <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Occupants</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
            <!-- Send Bills Button -->
            <div class="flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-2 rounded-lg flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                x-data x-on:click="$dispatch('open-modal',{name:'send-bill'})"
                {{$isSend = true;}}
                >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                </svg>
                    <span>Send Rent Bill</span>
                </button>
            </div>
            @if($isSend)
            <x-modal name="send-bill" title="Set Due Date">
                <x-slot:body>
                <!-- Form -->
                    <form id="modalForm" class="space-y-4" wire:submit.prevent="send">
                        <label class="block font-medium opacity-70">Due Date</label>
                        <input type="date" wire:model="payment_due_date" class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 w-full h-10 pl-3 border border-gray-300 rounded-md">
                        @error('payment_due_date') <span class="error text-red-900">{{ $message }}</span> @enderror
                          <!-- Action Buttons -->
                        <div class="flex items-center justify-between py-4">
                            <button x-on:click="$dispatch('close-modal', {name: 'add-renter'})" 
                                    class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md">
                                Close
                            </button>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                Submit
                            </button>

                        </div>
                    </form>
                </x-slot:body>
            </x-modal>
            @endif
    </div>
    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
                @if (session('success'))
                <div class="alert alert-success text-green-700">
                    {{ session('success') }}
                </div>    
                @endif
                
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('renters_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="renters_name" />
                        </div>
                    </th>  
                    <th wire:click="doSort('phone_number')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Phone number
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="phone_number" />
                        </div>
                    </th>  
                    <th wire:click="doSort('email')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Email
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="email" />
                        </div>
                    </th>                     
                    <th wire:click="doSort('categ_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Type
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="categ_name" />
                        </div>
                    </th>                     
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Room Info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </div>
                    </th>
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                            Rent Fee
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </div>
                    </th>                     
                    <!-- <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($apartment as $apartments)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->renters_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->phone_number}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->email}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building_name}}-{{$apartments->room_number}}
                    </td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">

                    @if(\App\Models\DueDate::where('user_id', $apartments->user_id)
                                            ->where('status', 'not paid')
                                            ->count() > 0)
                        {{ \App\Models\DueDate::where('user_id', $apartments->user_id)
                                            ->where('status', 'not paid')
                                            ->count() }} Unpaid Months
                    @else
                        Payment Updated
                    @endif
                    </td>
                    <!-- <td class="py-3 px-4 text-center border-b border-gray-300">
                        <div class="flex justify-center gap-1"> 
                                <button wire:click="showReceipt('{{ asset($apartments->receipt) }}','{{$apartments->due_id}}','{{$apartments->status}}')"
                                x-data x-on:click="$dispatch('open-modal',{name:'view-receipt'})"
                                @if($apartments->payment_method === 'stripe'||$apartments->payment_method === null) disabled title="disabled" @endif
                                >
                                @include('components.view-icon')
                            </button>
                        </div>
                    </td> -->
                </tr>
                @endforeach  
            </tbody>

    </table>
    
    </div>

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
        {{ $apartment->links()}}
        </div>
    </div>
  </div>
  
</div>
