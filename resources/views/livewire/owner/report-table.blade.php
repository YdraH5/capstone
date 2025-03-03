<div>
    <!-- Search Bar -->
    <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="flex gap-2 text-gray-700">
            <h1 class="text-2xl font-semibold text-black">Complaints</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
    </div>
    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow-lg">
        <table class="min-w-full mx-2 border-collapse">
            <thead> 
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Complainants
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="name" />
                    </th>
                    <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Room Info
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                    </th>
                    <th wire:click="doSort('report_category')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Report Category
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="report_category" />
                    </th>
                    <th wire:click="doSort('description')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Description
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="description" />
                    </th>                    
                    <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Status
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                    </th>                    
                    <th wire:click="doSort('date')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                        <div class="inline-flex items-center justify-center">
                        Date
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="date" />
                    </th>                    
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr class="hover:bg-indigo-100 ">
                    @if($report->is_anonymous === "false")
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->name}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->building_name}}-{{$report->room_number}}</td>
                    @else
                        <td class="py-3 px-4 text-center border-b border-gray-300">Anonymous</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">Anonymous</td>
                    @endif
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->report_category}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->description}}</td>
                    @if($report->status === 'Fixed')
                    <td class="py-3 px-4 text-center border-b border-gray-300 bg-green-100">{{$report->status}}</td>
                        @else
                        <td class="py-3 px-4 text-center border-b border-gray-300 text-yellow-800">{{$report->status}}</td>
                        @endif
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($report->date)->diffForHumans() }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <x-modal name="solve-report" title="Solve Report">
                            <x-slot:body>
                                <form id="modalForm" class="space-y-4 "wire:submit.prevent="action">
                                    <div>
                                        <input type="hidden"wire:model="status">
                                        <div>
                                            <label class="block font-medium opacity-70">Status</label>
                                            <select wire:model="status" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                                <option value="" disabled selected hidden>Status</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Sent Labor">Sent Labor</option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Fixed">Fixed</option>
                                            </select>
                                            @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror
                                        </div> 
                                    </div>
                                    <div class="flex items-center justify-between py-8">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                                    </div>
                                </form>
                            </x-slot:body>
                        </x-modal>
                        <div class="btn-group flex justify-center">
                            <button
                            x-data="{ id: {{$report->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'solve-report' })"
                            wire:click="edit(id)"
                            type="button"
                            class="px-5 py-2.5 text-center me-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                          </svg>
                          
                            </button>
                            
                        </div>
                    </td>           
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
        {{ $reports->links()}}
        </div>
    </div>
</div>
