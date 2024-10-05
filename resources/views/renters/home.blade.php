@section('title', 'Home')
@section('renters')
<x-renter-layout>
<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
                {{ __('Renter Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @foreach($reservations as $reservation)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Lease Summary -->
            <div class="bg-white rounded-lg shadow-lg mb-6 p-6">
                <div class="flex justify-between items-start">
                    <h3 class="text-3xl font-bold text-blue-600 flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12.62a9 9 0 11-1.13-4.55M22 12a10 10 0 11-2-5.92M12 2v10h10"/>
                        </svg>
                        Your Lease Details
                    </h3>

                    <!-- Resend Contract Button -->
                    <div id="contractContainer" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; justify-content: center; align-items: center; z-index: 50;">
                        <div id="contractModal" style=" border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <iframe id="contractFrame" src="{{ route('renters.downloadContract', ['user_id' => Auth::user()->id, 'apartment_id' => $reservation->apartment_id, 'reservation_id' => $reservation->reservation_id]) }}" 
                                    width="800px" height="600px" frameborder="0">
                            </iframe>
                            <!-- Close Button -->
                            <button id="closeContractBtn" style="position: absolute; top: 10px; right: 10px; background: none; border: none; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- View Contract Button -->
                    <button id="viewContractBtn" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg mt-4">
                        View Contract
                    </button>
                </div>
                
                @if (session('success'))
                <div class="alert alert-success bg-green-100 text-green-700 border border-green-300 rounded-lg p-4 mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Lease Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">
                        <p class="text-lg font-semibold"><strong>Lease Start Date:</strong></p>
                        <p class="text-gray-700">{{ date('F jS Y', strtotime($reservation->check_in)) }}</p>
                    </div>
                    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">
                        <p class="text-lg font-semibold"><strong>Lease End Date:</strong></p>
                        <p class="text-gray-700">{{ date('F jS Y', strtotime($reservation->end_date)) }}</p>
                    </div>
                    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">
                        <p class="text-lg font-semibold"><strong>Rent Amount:</strong></p>
                        <p class="text-gray-700">₱{{ number_format($reservation->price, 2) }}/month</p>
                    </div>
                    <div class="border p-4 rounded-lg shadow-sm bg-gray-50">
                        @if(Auth::user()->role === 'renter')
                        <p class="text-lg font-semibold"><strong>Status:</strong></p>
                        <p class="text-green-500 font-semibold">Active</p>
                        @endif
                    </div>
                </div>

                <!-- Conditional Button for Extending Contract -->
                @if($reservation->is_next_month)
                <p class="mt-4 text-red-500 font-semibold">Your rental period in our contract is about to end. Click the button below to extend our contract.</p>
                <button 
                    x-data="{ id: {{$reservation->reservation_id}} }" 
                    x-on:click="$dispatch('open-modal', { name: 'extend' })"
                    type="button" 
                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mt-4 transition duration-200 ease-in-out">
                    Extend Contract
                </button>
                <div>
                    <x-modal name="extend" title="Extend Contract">
                        <x-slot:body>
                            <form action="{{ route('renters.extend') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="apartment_id" value="{{ $reservation->apartment_id }}">
                                <input type="hidden" name="reservation_id" value="{{ $reservation->reservation_id }}">
                                
                                <label class="block font-medium text-gray-700 mt-4">Number of Months</label>
                                <input type="number" min="1" name="extend" placeholder="Number of months" class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">

                                <div class="flex justify-end space-x-4 mt-8">
                                    <button x-on:click="$dispatch('close-modal', {name:'extend'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                        Close
                                    </button>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </x-slot:body>
                    </x-modal>
                </div>
                @endif
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-lg mb-6 p-6">
                <h3 class="text-2xl font-bold mb-4">Payment Information</h3>
                @foreach($due_dates as $index => $due)
                    @if($due->status !== 'Paid')
                    <div class="mb-4 border p-4 rounded-lg bg-gray-50">
                        <p><strong class="font-semibold">Next Payment Due:</strong> {{ date('F jS Y', strtotime($due->payment_due_date)) }}</p>
                        <p><strong class="font-semibold">Amount Due:</strong> ₱{{ number_format($due->amount_due, 2) }}</p>
                        <p><strong class="font-semibold">Status:</strong> {{ strtoupper($due->status) }}</p>
                        <button 
                            class="mt-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
                            x-data 
                            x-on:click="$dispatch('open-modal', {name:'pay-bill-{{$index}}'})">
                            Pay
                        </button>

                        <x-modal name="pay-bill-{{$index}}" title="Pay Rent">
                            <x-slot:body>
                                <form action="{{ route('renters.pay') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="due_id" value="{{ $due->id }}">
                                    <input type="hidden" name="apartment_id" value="{{ $reservation->apartment_id }}">
                                    
                                    <label class="block font-medium text-gray-700">Amount:</label>
                                    <input type="number" readonly min="1" name="amount_due" value="{{ $due->amount_due }}" placeholder="Amount"
                                        class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">

                                    <label class="block text-gray-700 text-sm font-bold mb-2 mt-4" for="paymentMethod-{{$index}}">Payment Method</label>
                                    <div class="relative">
                                        <select class="shadow appearance-none border rounded w-full py-2 pr-10 pl-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="paymentMethod-{{$index}}" name="payment_method" onchange="toggleImageUpload('{{ $index }}')">
                                            <option value="" disabled selected hidden>Select Payment Method</option>
                                            <option value="gcash">Gcash</option>
                                            <option value="stripe">Stripe</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9 9 9-9" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div id="imageUpload-{{$index}}" style="display:none;">
                                        <label class="block mt-4 text-gray-700">Upload Proof of Payment</label>
                                        <input type="file" name="receipt" class="mt-1">
                                        <div class="mb-4" id="gcashDetails" >
                                            <p class="text-gray-700 text-sm font-bold mb-2">Scan the QR code below or note down the Gcash number foebr payment:</p>
                                            <img src="{{ asset('images/GCASH.jpg') }}" alt="GCash QR Code" class="mb-2">
                                            <p class="text-gray-700 font-semibold">GCash Number: 09123456789</p>
                                        </div>
                                    </div>

                                    <div class="flex justify-end space-x-4 mt-8">
                                        <button x-on:click="$dispatch('close-modal', {name:'pay-bill-{{$index}}'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                            Close
                                        </button>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                            Pay
                                        </button>
                                    </div>
                                </form>
                            </x-slot:body>
                        </x-modal>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <script>
    function toggleImageUpload(index) {
        const selectElement = document.getElementById(`paymentMethod-${index}`);
        const imageUploadDiv = document.getElementById(`imageUpload-${index}`);
        if (selectElement.value === 'gcash') {
            imageUploadDiv.style.display = 'block';
        } else {
            imageUploadDiv.style.display = 'none';
        }
    }
    // Function to show the contract modal
function showContract() {
    const contractContainer = document.getElementById('contractContainer');
    contractContainer.style.display = 'flex'; // Use flex to center the modal
}

// Function to hide the contract modal
function hideContract() {
    const contractContainer = document.getElementById('contractContainer');
    contractContainer.style.display = 'none'; // Hide the modal
}

// Set up event listeners after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('viewContractBtn').addEventListener('click', showContract);
    document.getElementById('closeContractBtn').addEventListener('click', hideContract);

    // Hide contract modal when clicking outside of it
    document.getElementById('contractContainer').addEventListener('click', function(event) {
        if (event.target === this) {
            hideContract();
        }
    });

    // Hide contract modal when pressing the Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hideContract();
        }
    });
});
</script>
    @endforeach
    @stop
</x-renter-layout>


