<div>
    <div class="bg-slate-200">
        <select wire:model.live="page" class="w-32 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
            <option value="history">History</option>
            <option value="to pay">To pay</option>
        </select>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse ">
            @if($page === 'history')
            
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Date') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Category') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Payment Method') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Amount') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                <tr class="hover:bg-indigo-100 ">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->created_at}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->category}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->payment_method}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->amount}}</td>
                </tr>
                @endforeach

            </tbody>

            @endif

            @if($page === 'to pay')
            
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Date') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Category') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Payment Method') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Amount') }}</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr class="bg-white hover:bg-gr`ay-300 odd:bg-white even:bg-slate-50">
                <tr class="hover:bg-indigo-100 ">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->created_at}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->category}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->payment_method}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$payment->amount}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                        <button class="bg-green-300 w-20">
                        pay</button></td>
                </tr>
                   
                </tr>
                @endforeach
            </tbody>
            @endif 
        </table>
    </div>
</div>
