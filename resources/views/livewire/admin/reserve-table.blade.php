<div>
    <div>
        <div class="flex justify-start mb-5 mt-2">
            <input wire:model.debounce.300ms.live="search" type="search" placeholder="Search...."
                class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        </div>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-seperate">
            <thead>
                <tr class="bg-gray-300 rounded">
                    <th class="text-center border border-black-900">NAME</th>
                    <th class="text-center border border-black-900">EMAIL</th>
                    <th class="text-center border border-black-900">ROOOM INFO</th>
                    <th class="text-center border border-black-900">CHECK IN</th>
                    <th class="text-center border border-black-900">CHECK OUT</th>
                    <th class="text-center border border-black-900">PAYMENT STATUS</th>
                    <th class="text-center border border-black-900">TOTAL AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr class="bg-white hover:bg-gray-300 odd:bg-white even:bg-slate-50">
                    <td class="text-center border border-black-900">{{$reservation->user_name}}</td>
                    <td class="text-center border border-black-900">{{$reservation->email}}</td>
                    <td class="text-center border border-black-900">{{$reservation->building}}-{{$reservation->room_number}}</td>
                    <td class="text-center border border-black-900">{{$reservation->check_in_date}}</td>
                    <td class="text-center border border-black-900">{{$reservation->check_out_date}}</td>
                    @if($reservation->payment_status=='0')
                    <td class="text-center border border-black-900">PAID
                    </td>
                    @else
                    <td class="text-center border border-black-900">
                        {{$reservation->payment_status}}
                    </td>
                    @endif
                    <td class="text-center border border-black-900">{{$reservation->total_price}}</td>
                </tr>
                @endforeach   
            </tbody>
          </table>       
    </div>
    <div>
        {{ $reservations->links('components.pagination')}}

    </div>
    
</div>
