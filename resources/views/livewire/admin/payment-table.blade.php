<!-- resources/views/payments.blade.php -->

<div>
    <div>
        <div class="flex justify-start mx-2 mb-5 mt-2">
            <input wire:model.debounce.300ms.live="search" type="search" placeholder="Search...."
                class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        </div>
        <div class="overflow-x-auto">
            <table class="mx-2 table-auto w-full border-seperate">
                <thead>
                    <tr class="bg-gray-300 rounded">
                        <th class="text-center border border-black-900">USER NAME</th>
                        <th class="text-center border border-black-900">AMOUNT</th>
                        <th class="text-center border border-black-900">Room Info</th>
                        <th class="text-center border border-black-900">CATEGORY</th>
                        <th class="text-center border border-black-900">PAYMENT METHOD</th>
                        <th class="text-center border border-black-900">STATUS</th>
                        <th class="text-center border border-black-900">DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr class="bg-white hover:bg-gray-300 odd:bg-white even:bg-slate-50">
                        <td class="text-center border border-black-900">{{ $payment->user_name }}</td>
                        <td class="text-center border border-black-900">{{ $payment->amount }}</td>
                        <td class="text-center border border-black-900">{{ $payment->building }}-{{ $payment->room_number}}</td>
                        <td class="text-center border border-black-900">{{ $payment->category }}</td>
                        <td class="text-center border border-black-900">{{ $payment->payment_method }}</td>
                        <td class="text-center border border-black-900">{{ $payment->status }}</td>
                        <td class="text-center border border-black-900">{{ $payment->date }}</td>
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
