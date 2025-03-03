<!-- resources/views/payments.blade.php -->

<div>
    <div>
        <!-- Search Bar -->
        <div class="no-print flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <div class="flex gap-2 text-gray-700">
                <h1 class="no-print text-2xl font-semibold text-black">Payments</h1>
            </div>
            <div class="no-print relative w-1/2 ml-auto">
                <input id="search-input" wire:model.debounce.300ms.live="search" type="search" placeholder="Search..."
                    class="w-full h-12 pl-4 pr-12 py-2 text-gray-700 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" width="1.25rem" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                </svg>
            </div>
            <button onclick="window.print()" class="no-print bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Print Report
            </button>
            <!-- button to add payment -->
            <button class="no-print" x-data x-on:click="$dispatch('open-modal',{name:'add-payment'})"title ="Add Payment"{{$open=true;}}>
                @include('buttons.add')
            </button> 
        </div>
        <div class="print-only bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-6 text-indigo-600">Payments Report</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="chart-container">
                    <h3 class="text-lg font-medium text-center">Rental Fee Earnings</h3>
                    <img src="{{ $rentalChartUrl }}" alt="Rental Fee Earnings Chart" class="mx-auto">
                </div>

                <div class="chart-container">
                    <h3 class="text-lg font-medium text-center">Reservation Fee Earnings</h3>
                    <img src="{{ $reservationChartUrl }}" alt="Reservation Fee Earnings Chart" class="mx-auto">
                </div>
            </div>
        </div>
        <br class="print-only">
         <br class="print-only">
         <br class="print-only">
         <br class="print-only">
         <br class="print-only">
         <br class="print-only">
         <br class="print-only">
        <!-- Table -->

        <div class="overflow-x-auto bg-white shadow-lg">
            <table class="min-w-full mx-2 border-collapse">
                 @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <thead>
                    <tr class="bg-indigo-500 text-white uppercase text-sm">
                        <th wire:click="doSort('user_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Name
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="user_name" />
                        </th>                        
                        <th wire:click="doSort('amount')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Amount
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="amount" />
                        </th>
                        <th wire:click="doSort('building_name')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Room info
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="building_name" />
                        </th>
                        <th wire:click="doSort('category')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Category
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="category" />
                        </th>                        
                        <th wire:click="doSort('payment_method')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Payment method
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="payment_method" />
                        </th>  
                        <th wire:click="doSort('created_at')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Date
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="created_at" />
                        </th>                      
                        <th wire:click="doSort('status')" class="py-3 px-4 text-center border-b border-indigo-600 cursor-pointer">
                            <div class="inline-flex items-center justify-center">
                            Status
                            <x-datatable-item :sortColumn="$sortColumn" :sortDirection="$sortDirection" columnName="status" />
                        </th>
                        
                        <th class="no-print py-3 px-4 text-center border-b border-indigo-600">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="hover:bg-indigo-100 ">
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->user_name }}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">₱{{ $payment->amount }}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->building_name }}-{{ $payment->room_number}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->category }}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->payment_method }}</td>
                        
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($payment->created_at)->format('F j, Y')}}</td>
                        @if($payment->status === 'paid')
                        <td class="py-3 px-4 text-center border-b border-gray-300 text-green-500">{{ $payment->status }}</td>
                        @endif
                         <td class="no-print py-3 px-4 text-center border-b border-gray-300">
                            <div class="flex justify-center gap-1"> 
                                <button wire:click="showReceipt('{{ asset($payment->receipt) }}','{{$payment->id}}','{{$payment->status}}')"
                                    x-data x-on:click="$dispatch('open-modal',{name:'view-receipt'})"
                                    @if($payment->payment_method === 'stripe'||$payment->status === 'unpaid') disabled title="disabled" @endif
                                    >
                                    @include('components.view-icon')
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach   
                </tbody>
            </table>       
        </div>
        <x-modal name="view-receipt" title="Receipt">
        <x-slot name="body">
            <div class="p-4 flex flex-col items-center">
                @if($currentReceipt)
                <img src="{{ $currentReceipt }}" alt="Receipt Image" style="max-height: 400px; max-width: 100%;">
                @endif
                <div class="flex justify-end py-2">
                    <button wire:click ="reject({{$payment_id}})"x-on:click="$dispatch('close-modal',{name:'view-receipt'})" type="button"
                    class="bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded mr-4 ">Reject</button>
                    @if($currentStatus === 'pending'||$currentStatus === 'Rejected' )
                    <button type="button"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded"
                        wire:click="approve({{ $payment_id }})"
                        x-on:click="$dispatch('close-modal',{name:'view-receipt'})">Approve
                    </button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-modal>
        <div class="flex items-center mb-3">
            <label for="perPage" class="no-print mr-2 mt-2 text-sm font-medium text-gray-700">Per Page:</label>
            <select id="perPage" wire:model.live="perPage" class="no-print border border-gray-300 rounded px-2 py-1 h-8 w-20 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Select</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
        </div>
        <div>
        {{ $payments->links()}}
        </div>
    </div>
</div>
