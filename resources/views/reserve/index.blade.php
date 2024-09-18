@section('title', 'Reservation Form')
@include('layouts-waiting.app')

@foreach ($apartment as $data)
@foreach ($category as $info)
<x-input-error :messages="$errors->get('user_id')" class="mt-2" />
<form action="{{ route('reserve.create') }}" method="post" enctype="multipart/form-data">
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
                <input type="number" name="user_id" value="{{ Auth::user()->id }}" hidden>
                <input type="number" name="apartment_id" value="{{ $data->id }}" hidden>
                <input type="text" name="payment_status" value="paid" hidden>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly id="name" type="text" value="{{ Auth::user()->name }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email Address
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="apartment">
                    Apartment Type
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $info->name }}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pricePerMonth">
                    Price Per Month (₱)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pricePerMonth" type="number" min="0" step="0.01" value="{{ $data->price }}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkin">
                    Check-In Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkin" type="date" name="check_in">
                <x-input-error :messages="$errors->get('check_in')" class="mt-2" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">Reservation Fee(₱)</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="totalPrice" type="text" readonly name="total_price"value="{{$data->price * .05}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkout">
                    Rental Period(months)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="rental_period" type="number" min="1"name="rental_period">
                <x-input-error :messages="$errors->get('rental_period')" class="mt-2" />
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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="paymentMethod">
                    Payment Method
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="paymentMethod" name="payment_method" onchange="toggleImageUpload()">
                    <option value="" disabled selected hidden>Select Payment Method</option>
                    <option value="gcash">Gcash</option>
                    <option value="stripe">Stripe</option>
                </select>
            </div>
            <div class="mb-4" id="gcashUpload" style="display: none;">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="gcashReceipt">
                    Upload Gcash Receipt
                </label>
                <input type="file" name="receipt" id="gcashReceipt" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                    <div class="mb-4" id="gcashDetails" >
                        <p class="text-gray-700 text-sm font-bold mb-2">Scan the QR code below or note down the Gcash number for payment:</p>
                        <img src="{{ asset('images/GCASH.jpg') }}" alt="GCash QR Code" class="mb-2">
                        <p class="text-gray-700 font-semibold">GCash Number: 09123456789</p>
                    </div>
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
                                3. You must check-in on the specified date and check-out on the specified rental period. Any changes to these dates must be communicated at least 48 hours in advance.<br>
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
<script>
    function toggleImageUpload() {
        var paymentMethod = document.getElementById("paymentMethod").value;
        var gcashUpload = document.getElementById("gcashUpload");
        if (paymentMethod === "gcash") {
            gcashUpload.style.display = "block";
        } else {
            gcashUpload.style.display = "none";
        }
    }
     // Function to get today's date and the date one week from now
     function setMinCheckInDate() {
            var today = new Date();
            var oneWeekFromNow = new Date();
            
            // Add 7 days to the current date for the minimum allowed date
            oneWeekFromNow.setDate(today.getDate() + 7);

            // Format the dates as yyyy-mm-dd
            var minDate = today.toISOString().split('T')[0];
            var minAllowedDate = oneWeekFromNow.toISOString().split('T')[0];

            // Set the min attribute to today's date or one week from now
            document.getElementById('checkin').setAttribute('min', minAllowedDate);
        }

        // Call the function on page load
        window.onload = setMinCheckInDate;
</script>


