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
                <thead>
                    <tr class="bg-indigo-500 text-white uppercase text-sm">
                        <th class="py-3 px-4 text-center border-b border-indigo-600">USERNAME</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">AMOUNT</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">Room Info</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">CATEGORY</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">PAYMENT METHOD</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">STATUS</th>
                        <th class="py-3 px-4 text-center border-b border-indigo-600">DATE</th>
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
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{ $payment->date }}</td>
                    </tr>
                    @endforeach   
                </tbody>
            </table>       
        </div>
        <div>
            {{ $payments->links('components.pagination') }}
        </div>
    </div>
</div>
