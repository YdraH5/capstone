<div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse ">
            
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Date') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Category') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Payment Method') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Payment Status') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Amount') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                <tr class="hover:bg-indigo-100 ">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{Carbon\Carbon::parse($payment->created_at)->format('F j, Y'),}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->category}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->payment_method}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->status}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->amount}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
