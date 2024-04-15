<div>
    <div>
        <div>
            <input wire:model.debounce.100ms.live="search" type="search"placeholder="Search...." class="mb-5 mt-2 text-black-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-1/3 h-8 flex items-center pl-3 text-sm border-black rounded border">
        </div>
        <table class="table-auto w-full border-seperate max-w-10xl">
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
    
</div>
