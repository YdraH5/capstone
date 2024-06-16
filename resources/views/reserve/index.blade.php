@section('title', 'Reservation Form')
@include('layouts-waiting.app')

@foreach ($apartment as $data)
@foreach ($category as $info)
<x-input-error :messages="$errors->get('user_id')" class="mt-2" />
<form action="{{route('reserve.create')}}" method="post">
    @csrf
    @method('post')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded px-8 py-6">
            <div class="mb-4">
                <h2 class="text-lg font-bold">Apartment Reservation Receipt</h2>
                <p class="text-gray-500">Please review your reservation details:</p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Full Name
                </label>
                <input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
                <input type="number" name="apartment_id" value="{{$data->id}}" hidden>
                <input type="text" name="payment_status" value="paid" hidden>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly id="name" type="text" value="{{Auth::user()->name}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email Address
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" value="{{Auth::user()->email}}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="apartment">
                    Apartment Type
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{$info->name}}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pricePerMonth">
                    Price Per Month ($)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pricePerMonth" type="number" min="0" step="0.01" value="{{$data->price}}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkin">
                    Check-In Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkin" type="date" name="check_in">
                <x-input-error :messages="$errors->get('check_in')" class="mt-2" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkout">
                    Check-Out Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkout" type="date" name="check_out">
                <x-input-error :messages="$errors->get('check_out')" class="mt-2" />
            </div>
            @if ($errors->has('reservation'))
                <div class="text-red-500">{{ $errors->first('reservation') }}</div>
            @endif
            <div class="mb-4 hidden">
                <input type="hidden" hidden id="totalBalanceInput" name="payment_status">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="paymentStatus">Payment Status</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="paymentStatus" name="payment_status">
                    <option value="Paid">Pay in Full</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">Reservation Fee</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="totalPrice" type="text" readonly name="total_price">
                <span id="chargeMessage" class="text-red-500"></span>
                <span id="balanceMessage" class="text-green-500"></span>
            </div>
            <div class="mb-4" x-data="{ agreed: false }">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <input type="checkbox" x-model="agreed">
                    I agree to the <button type="button" class="text-blue-500 hover:underline" x-on:click="$dispatch('open-modal', {name: 'terms-conditions'})">terms and conditions</button>.
                </label>
                <div class="flex items-center justify-between mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" :disabled="!agreed">
                        Confirm Reservation
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('visitors.display', ['apartment' => $data->id]) }}">
                        Cancel
                    </a>
                </div>
                <x-modal name="terms-conditions" title="Terms and Conditions">
                    <x-slot name="body">
                        <div class="p-4">
                            <p class="text-lg text-gray-600 font-semibold mb-4">
                                By confirming this reservation, you agree to the following terms and conditions:
                            </p>
                            <p class="text-gray-600 mb-8">
                                1. You agree to pay the full reservation fee as stated in the reservation details.<br>
                                2. The reservation is non-refundable and cannot be transferred to another person.<br>
                                3. You must check-in on the specified date and check-out on the specified date. Any changes to these dates must be communicated at least 48 hours in advance.<br>
                                4. You are responsible for any damages to the apartment during your stay. Additional charges may apply if any damages are found.<br>
                                5. All personal information provided will be handled in accordance with our privacy policy.
                            </p>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal', {name: 'terms-conditions'})">Close</button>
                            </div>
                        </div>
                    </x-slot>
                </x-modal>
            </div>
        </div>
    </div>
</form>
@endforeach
@endforeach
<script src="{{ asset('js/total.js') }}"></script>
