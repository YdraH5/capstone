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
        <div class="min-w-full mx-auto sm:px-6 lg:px-8">

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

            <!-- Payment Information Table -->
            <div class="bg-white rounded-lg shadow-lg mb-6 p-6 min-w-full">
                <h3 class="text-2xl font-bold mb-4">Payment Information</h3>
                @if($due_dates->isEmpty())
                    <p class="text-gray-700">No payment dues at the moment.</p>
                @else
                <div class="overflow-x-auto min-w-full">
                <table class="min-w-full bg-white shadow-lg rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Next Payment Due</th>
                                <th class="px-4 py-2 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Amount</th>
                                <th class="px-4 py-2 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider lg:table-cell sm:hidden">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($due_dates as $index => $due)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-3 border-b border-gray-300">
                                        {{ date('F jS Y', strtotime($due->payment_due_date)) }}
                                    </td>
                                    <td class="px-4 py-3 border-b border-gray-300">
                                        ₱{{ number_format($due->amount_due, 2) }}
                                    </td>
                                    <td class="px-4 py-3 border-b border-gray-300 lg:table-cell sm:hidden">
                                        @php
                                            $previousDue = $due_dates->slice(0, $index)->last();
                                            $canPay = !$previousDue || $previousDue->status === 'paid';
                                            $isPaid = $due->status === 'paid';
                                            $isPending = $due->status === 'pending';
                                        @endphp

                                        <div x-data="{ showWarning: false }" class="relative flex flex-col items-start">
                                            @if($isPaid)
                                                <span class="bg-green-500 text-white py-2 px-3 rounded-lg text-sm">Paid</span>
                                            @elseif($isPending)
                                                <span class="bg-yellow-300 text-white py-2 px-3 rounded-lg text-sm">Pending</span>
                                            @elseif($canPay)
                                                <button 
                                                    class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm" 
                                                    x-on:click="$dispatch('open-modal', {name:'pay-bill-{{$index}}'})">
                                                    Pay
                                                </button>
                                            @else
                                                <button class="bg-gray-300 text-gray-600 py-2 px-3 rounded-lg cursor-not-allowed text-sm flex items-center">
                                                    Pay
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 ml-2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                </button>
                                            @endif

                                            <x-modal name="pay-bill-{{$index}}" title="Pay Rent">
                                                <x-slot:body>
                                                    <form action="{{ route('renters.pay') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                        <input type="hidden" name="due_id" value="{{ $due->id }}">
                                                        <input type="hidden" name="apartment_id" value="{{ $reservation->apartment_id }}">

                                                        <label class="block font-medium text-gray-700">Amount:</label>
                                                        <input type="number" readonly min="1" name="amount_due" value="{{ $due->amount_due }}" class="mt-1 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 pl-3 text-sm border-gray-300 rounded">

                                                        <label class="block text-gray-700 text-sm font-bold mt-4">Payment Method</label>
                                                        <div class="relative">
                                                            <select class="shadow appearance-none border rounded w-full py-2 pr-10 pl-3 text-gray-700 leading-tight focus:outline-none" name="payment_method" onchange="toggleImageUpload('{{ $index }}')">
                                                                <option value="" disabled selected hidden>Select Payment Method</option>
                                                                <option value="gcash">Gcash</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="stripe">Visa/Master Card</option>
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
                                                            <div class="mb-4">
                                                                <p class="text-gray-700 text-sm font-bold mb-2">Scan the QR code or note the Gcash number for payment:</p>
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

                                            @if (!$canPay)
                                                <div x-show="showWarning" x-transition class="absolute top-full left-0 text-red-500 mt-2">
                                                    You need to pay the closer due months first.
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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


