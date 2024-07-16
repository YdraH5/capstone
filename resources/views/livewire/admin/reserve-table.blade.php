<div>
    <div>
        <div class="flex justify-start mb-5 mx-2 mt-2">
            <input wire:model.debounce.300ms="search" type="search" placeholder="Search...."
                class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mx-2 border-separate">
                <thead>
                    @if (session('success'))
                    <tr>
                        <td colspan="8" class="text-center bg-green-200 text-green-700 py-2">
                            {{ session('success') }}
                        </td>
                    </tr>
                    @endif
                    <tr class="bg-gray-300 rounded">
                        <th class="text-center border border-black-900">NAME</th>
                        <th class="text-center border border-black-900">EMAIL</th>
                        <th class="text-center border border-black-900">ROOM INFO</th>
                        <th class="text-center border border-black-900">CHECK IN</th>
                        <th class="text-center border border-black-900">CHECK OUT</th>
                        <th class="text-center border border-black-900">PAYMENT STATUS</th>
                        <th class="text-center border border-black-900">TOTAL AMOUNT</th>
                        <th class="text-center border border-black-900">Action</th>
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
                        @if($reservation->status === 'approval')
                        <td class="text-center border border-black-900 bg-yellow-100">Need approval</td>
                        @else
                        <td class="text-center border border-black-900">{{$reservation->status}}</td>
                        @endif
                        <td class="text-center border border-black-900">₱{{$reservation->total_price}}</td>
                        <td class="text-center border border-black-900">
                            <button wire:click="showReceipt('{{ asset($reservation->receipt) }}', '{{ $reservation->status }}', '{{ $reservation->reservation_id }}')"
                                x-data x-on:click="$dispatch('open-modal',{name:'view-receipt'})">
                                @include('components.view-icon')
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $reservations->links('components.pagination') }}
        </div>
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
                        wire:click="approve({{ $id }})"
                        x-on:click="$dispatch('close-modal',{name:'view-receipt'})">Approve</button>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-modal>
