<!-- resources/views/payments.blade.php -->

<div>
    <div>
        <!-- Search Bar -->
        <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <div class="flex gap-2 text-gray-700">
                <h1 class="text-2xl font-semibold text-black">Payments</h1>
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
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->status }}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($payment->created_at)->format('F j, Y')}}</td>
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
                    <button wire:click ="close()"x-on:click="$dispatch('close-modal',{name:'view-receipt'})" type="button"
                        class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4">Close</button>
                    @if($currentStatus === 'approval')
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
        <div>
        {{ $payments->links()}}
        </div>
    </div>
</div>
