<div> 
     <!-- Search Bar -->
     <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
        <div class="no-print flex gap-2 text-gray-700">
            <h1 class="no-print text-2xl font-semibold text-black">Occupants</h1>
        </div>
        <div class="relative w-1/2 ml-auto">
            <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                class="no-print w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            <svg class="no-print absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
            </svg>
        </div>
        <button onclick="window.print()" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print Report
        </button>
    </div>
    <div class=" print-only p-4 mb-4 bg-gray-50 rounded-lg shadow-sm">
    <h2 class="text-lg font-semibold text-gray-700">Occupants Report Summary</h2>
    <div class="print-only grid grid-cols-2 gap-4 md:grid-cols-4 mt-3 text-sm">
        <div class="bg-indigo-100 p-4 rounded-lg text-center">
            <span class="font-medium text-gray-800">Total Occupants</span>
            <div class="text-lg font-bold text-indigo-600">{{ $summary['totalOccupants'] }}</div>
        </div>
        <div class="bg-red-100 p-4 rounded-lg text-center">
            <span class="font-medium text-gray-800">Overdue Renters Count</span>
            <div class="text-lg font-bold text-red-600">{{ $summary['overdueRenters'] }}</div>
        </div>
        <div class="bg-green-100 p-4 rounded-lg text-center">
            <span class="font-medium text-gray-800">Up to Date Renters</span>
            <div class="text-lg font-bold text-green-600">{{ $summary['updatedPayments'] }}</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded-lg text-center">
            <span class="font-medium text-gray-800">Total Unpaid Amount</span>
            <div class="text-lg font-bold text-yellow-600">₱{{ number_format($summary['totalUnpaidAmount'], 2) }}</div>
        </div>
        <div class="bg-blue-100 p-4 rounded-lg text-center">
            <span class="font-medium text-gray-800">Avg. Overdue Days</span>
            <div class="text-lg font-bold text-blue-600">{{ $summary['averageOverdueDays'] }} days</div>
        </div>
    </div>
</div>

    <!-- Table -->
       <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success text-green-700 mb-4 p-4 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>    
    @endif
    <div class="overflow-x-auto bg-white shadow-lg">
    <table class="min-w-full mx-2 border-collapse">
        <thead> 
 
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                <!-- Table Headers -->
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
                        Lease Status
                        <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                    </div>
                </th>    
                <th class="no-print py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                    Action
                </th>                   
            </tr>
        </thead>
        <tbody>
            @php
            use App\Models\DueDate;
            use Carbon\Carbon;
            @endphp
            @foreach($apartment as $apartments)
            <tr class="hover:bg-indigo-100">
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->renters_name}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->phone_number}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->email}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->categ_name}}</td>
                <td class="py-3 px-4 text-center border-b border-gray-300">{{$apartments->building_name}}-{{$apartments->room_number}}</td>
                <td class="no-print py-3 px-4 text-center border-b border-gray-300">
                    @php
                        $unpaidDues = DueDate::where('user_id', $apartments->user_id)
                            ->where('status', 'not paid')
                            ->where(function ($query) {
                                $query->where('payment_due_date', '<', now())
                                    ->orWhere('payment_due_date', '=', now()->format('Y-m-d'));
                            })->get();
                        $unpaidMonthsCount = $unpaidDues->count();
                    @endphp

                    @if($unpaidMonthsCount > 0)
                        <a href="#" x-data x-on:click="$dispatch('open-modal',{name:'unpaid-modal-{{ $apartments->user_id }}'})" class="text-red-600 hover:underline hover:text-red-800">
                            {{ $unpaidMonthsCount }} Unpaid Months
                        </a>
                    @else
                        <a href="#" x-data x-on:click="$dispatch('open-modal',{name:'paid-modal-{{ $apartments->user_id }}'})" class="text-green-600 hover:underline hover:text-green-800">
                            Payment Up to date
                        </a>
                    @endif
                </td>
                <td class="print-only py-3 px-4 text-center border-b border-gray-300">
                    @php
                        $unpaidDues = DueDate::where('user_id', $apartments->user_id)
                            ->where('status', 'not paid')
                            ->where(function ($query) {
                                $query->where('payment_due_date', '<', now())
                                    ->orWhere('payment_due_date', '=', now()->format('Y-m-d'));
                            })->get();

                        $unpaidMonthsCount = $unpaidDues->count();
                    @endphp

                    @if($unpaidMonthsCount > 0)
                        @foreach($unpaidDues as $due)
                            @php
                                $dueDate = Carbon::parse($due->getAttribute('payment_due_date'));
                                $daysOverdue = $dueDate->diffInDays(now());
                                $amountDue = number_format($due->getAttribute('amount_due'), 2);
                            @endphp
                            {{ $daysOverdue }} days overdue of ₱{{ $amountDue }}
                        @endforeach
                    @else
                        Payments up to date
                    @endif
                </td>


                <td class="no-print py-3 px-4 text-center border-b border-gray-300">
                    <div class="flex justify-center gap-1">
                        <button x-data x-on:click="$dispatch('open-modal',{name:'out-modal'})">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                        </button>

                        <x-modal name="out-modal" title="Departure">
                            <x-slot name="body">
                                <p>Are the renters leaving the apartment today?</p>
                                <div class="flex justify-end space-x-2">
                                    <button x-on:click="$dispatch('close-modal',{name:'out-modal'})" class="bg-gray-500 text-white px-4 py-2 rounded">No</button>
                                    <button wire:click="out({{ $apartments->apartment_id }})" class="bg-blue-500 text-white px-4 py-2 rounded">Yes</button>
                                </div>
                            </x-slot>
                        </x-modal>
                    </div>
                </td>
            </tr>
                            
            <!-- Unpaid Modal -->
            <x-modal name="unpaid-modal-{{ $apartments->user_id }}" title="Overdue for {{ $apartments->renters_name }}">
                <x-slot name="body">
                    <div class="space-y-4">
                        @foreach($unpaidDues as $due)
                            @php
                                $dueDate = Carbon::parse($due->getAttribute('payment_due_date'));
                                $formattedDueDate = $dueDate->format('F j, Y');
                                $status = ucfirst($due->getAttribute('status'));
                                $daysOverdue = $dueDate->diffInDays(now());
                                $amountDue = number_format($due->getAttribute('amount_due'), 2);
                            @endphp
                            <div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-700">Due Date:</span>
                                    <span class="text-gray-900">{{ $formattedDueDate }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="font-semibold text-gray-700">Amount:</span>
                                    <span class="text-black">₱{{ $amountDue }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="font-semibold text-gray-700">Status:</span>
                                    <span class="text-black">{{ $status }}</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="font-semibold text-gray-700">Days Overdue:</span>
                                    <span class="text-red-600">{{ $daysOverdue }} days overdue</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Send Email Button -->
                    <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="sendReminderEmail({{ $apartments->user_id }}, {{ $unpaidDues->isNotEmpty() ? $daysOverdue : 0 }})"
                            class="bg-blue-500 text-white px-4 py-2 rounded relative">
                        <!-- Default Button Text -->
                        <span wire:loading.remove wire:target="sendReminderEmail">Send Reminder</span>

                    </button>


                        <button x-on:click="$dispatch('close-modal',{name:'unpaid-modal-{{ $apartments->user_id }}'})" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
                    </div>
                </x-slot>
            </x-modal>

            <!-- Paid Modal -->
            <x-modal name="paid-modal-{{ $apartments->user_id }}" title="Payment Status for {{ $apartments->renters_name }}">
                <x-slot name="body">
                    <div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-center text-green-600">All payments are up to date for {{ $apartments->renters_name }}.</p>
                    </div>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button x-on:click="$dispatch('close-modal',{name:'paid-modal-{{ $apartments->user_id }}'})" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
                    </div>
                </x-slot>
            </x-modal>

            @endforeach
        </tbody>
    </table>


    </div>

    <div class="py-4">
        <div class="flex items-center mb-3">
            <label for="perPage" class="no-print mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
            <select id="perPage" wire:model.live="perPage" class="no-print border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
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
