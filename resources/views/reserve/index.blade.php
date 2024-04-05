@section('title', '')
@include('layouts-renter.app')

@foreach($apartment as $reserve)
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
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text"value="{{Auth::user()->name}}"readonly>
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
              Email Address
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email"value="{{Auth::user()->email}}"readonly >
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="apartment">
              Apartment Type
          </label>
          <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="apartment">
              <option value="1 Bedroom">1 Bedroom</option>
              <option value="2 Bedroom">2 Bedroom</option>
              <option value="Studio">Studio</option>
              <option value="Penthouse">Penthouse</option>
          </select>
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="pricePerNight">
              Price Per Month ($)
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pricePerNight" type="number" min="0" step="0.01"value="{{$reserve->price}}" readonly>
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="checkin">
              Check-In Date
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkin" type="date">
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="checkout">
              Check-Out Date
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="checkout" type="date">
      </div>
      <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="totalPrice">
              Total Price
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="totalPrice" type="text" readonly>
      </div>
      <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" onclick="calculateTotalPrice()">
              Confirm Reservation
          </button>
          <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
              Cancel
          </a>
      </div>
  </div>
</div>
@endforeach
<script>
  document.getElementById('checkin').addEventListener('change', calculateTotalPrice);
  document.getElementById('checkout').addEventListener('change', calculateTotalPrice);
  document.getElementById('apartment').addEventListener('change', calculateTotalPrice);
  document.getElementById('pricePerNight').addEventListener('input', calculateTotalPrice);

  function calculateTotalPrice() {
      // Calculate total price based on reservation details
      // For demonstration, let's assume a fixed price per night
      const apartmentType = document.getElementById('apartment').value;
      const checkinDate = new Date(document.getElementById('checkin').value);
      const checkoutDate = new Date(document.getElementById('checkout').value);
      const pricePerNight = parseFloat(document.getElementById('pricePerNight').value);

      // Ensure price per night is valid
      if (isNaN(pricePerNight) || pricePerNight <= 0) {
          alert("Please enter a valid price per night.");
          return;
      }

      // Ensure minimum reservation period of 1 month
      const minReservationPeriod = new Date(checkinDate);
      minReservationPeriod.setMonth(minReservationPeriod.getMonth() + 1);

      if (checkoutDate < minReservationPeriod) {
          alert("Minimum reservation period is 1 month.");
          return;
      }

      const numberOfNights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24)); // Calculate number of nights

      const totalPrice = pricePerNight * numberOfNights;

      // Display total price
      document.getElementById('totalPrice').value = '$' + totalPrice.toFixed(2);
  }
</script>