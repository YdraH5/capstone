<div>
    <div class="bg-slate-200">
        <select wire:model.live="page" class="w-32 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
            <option value="history">History</option>
            <option value="to pay">To pay</option>
            <option value="upcoming">Upcoming</option>
        </select>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-seperate max-w-7xl">
            @if($page === 'history')
            
            <thead>
                <tr class="bg-gray-300 rounded">
                    <th class="text-center border border-black-900 border-2">{{ __('Date') }}</th>
                    <th class="text-center border border-black-900 border-2">{{ __('Category') }}</th>
                    <th class="text-center border border-black-900 border-2">{{ __('Payment Method') }}</th>
                    <th class="text-center border border-black-900 border-2">{{ __('Amount') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                <tr class="bg-white hover:bg-gr`ay-300 odd:bg-white even:bg-slate-50">
                    <td class="text-center border border-black-900 border-2">{{$payment->created_at}}</td>
                    <td class="text-center border border-black-900 border-2">{{$payment->category}}</td>
                    <td class="text-center border border-black-900 border-2">{{$payment->payment_method}}</td>
                    <td class="text-center border border-black-900 border-2">{{$payment->amount}}</td>
                </tr>
                @endforeach

            </tbody>

            @endif

            @if($page === 'to pay')
            
            <thead>
                <tr class="bg-gray-300 rounded">
                    <th class="text-center border border-black-900 border-2">{{ __('Category') }}</th>
                    <th class="text-center border border-black-900 border-2">{{ __('Amount') }}</th>
                    <th class="text-center border border-black-900 border-2">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="bg-white hover:bg-gr`ay-300 odd:bg-white even:bg-slate-50">
                    <td class="text-center border border-black-900 border-2">{{$payment->category}}</td>
                    <td class="text-center border border-black-900 border-2">{{$payment->amount}}</td>
                    <td>Pay</td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div>
</div>
