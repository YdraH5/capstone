@section('title', '')
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
            </div><tr>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Full Name
                </label>
                <input type="number" name="user_id" value="{{Auth::user()->id}}"hidden>
                <input type="number" name="apartment_id" value="{{$data->id}}"hidden>
                <input type="text" name="payment_status" value="paid"hidden>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text"value="{{Auth::user()->name}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email Address
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email"value="{{Auth::user()->email}}"readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="apartment">
                    Apartment Type
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"value="{{$info->name}}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="pricePerMonth">
                    Price Per Month ($)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pricePerMonth" type="number" min="0" step="0.01"value="{{$data->price}}"readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkin">
                    Check-In Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkin" type="date"name="check_in">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="checkout">
                    Check-Out Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkout" type="date"name="check_out">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="paymentStatus">Payment Status</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="paymentStatus" name="payment_status">
                    <option value="Paid">Pay in Full</option>
                    <option value="Balance">Downpayment(20%)</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">Total Price</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="totalPrice" type="text" readonly name="total_price">
                <span id="chargeMessage" class="text-red-500"></span>
                <span id="balanceMessage" class="text-green-500"></span>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 text-sm mb-2">
                    By clicking "Confirm Reservation", you agree to our <a href="/terms" class="text-blue-500 hover:underline">terms and conditions</a>.
                </p>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Confirm Reservation
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{route('visitors.display',['apartment'=>$data->id])}}">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>

@endforeach
@endforeach
<script src="{{ asset('js/total.js') }}"></script>
