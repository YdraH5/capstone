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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <h3 class="text-3xl font-bold mb-6 text-blue-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12.62a9 9 0 11-1.13-4.55M22 12a10 10 0 11-2-5.92M12 2v10h10"/>
                            </svg>
                            Your Lease Details
                        </h3>

                        <!-- Resend Contract Button -->
                        <a href="{{ route('renters.resend', ['id' => Auth::user()->id, 'apartment' => $reservation->apartment_id, 'reservation' => $reservation->reservation_id]) }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-2 rounded-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a8 8 0 10-16 0 8 8 0 0016 0zm-6 4v1m0-8v1m-4 4h4" />
                                </svg>
                                Resend Contract (.pdf)
                            </button>
                        </a>
                    </div>
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <!-- Lease Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        <div>
                            <p class="text-lg"><strong>Lease Start Date:</strong></p>
                            <p class="text-gray-700">{{ date(' F jS Y', strtotime($reservation->check_in)) }}</p>
                        </div>
                        <div>
                            <p class="text-lg"><strong>Lease End Date:</strong></p>
                            <p class="text-gray-700">{{ date(' F jS Y', strtotime($reservation->end_date)) }}</p>
                        </div>
                        <div>
                            <p class="text-lg"><strong>Rent Amount:</strong></p>
                            <p class="text-gray-700">₱{{ number_format($reservation->price, 2) }}/month</p>
                        </div>
                        <div>
                            @if(Auth::user()->role === 'renter')
                            <p class="text-lg"><strong>Status:</strong></p>
                            <p class="text-green-500 font-semibold">Active</p>
                            @endif
                        </div>
                    </div>

                    <!-- Conditional Button for Extending Contract -->
                    @if($reservation->is_next_month)
                    <p class="mt-4 text-red-500">Your rental period in our contract is about to end. Click the button below to extend our contract</p>
                    <button 
                        x-data="{ id: {{$reservation->reservation_id}} }" 
                        x-on:click=" $dispatch('open-modal', { name: 'extend' })"
                        type="button" 
                        class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mt-4">
                        Extend Contract
                    </button>
                    <div>
                    <x-modal name="extend" title="Extend Contract">
                    <x-slot:body>
                        <!-- Form -->
                        <form action="{{ route('renters.extend') }}" method="post">
                            @csrf
                            <div class="grid grid-cols-1 ">
                                <div class="col-span-1">
                                    <input type="number" value="{{Auth::user()->id}}"name="user_id"hidden>
                                    <input type="number" value="{{$reservation->apartment_id}}"name="apartment_id"hidden>
                                    <input type="number" value="{{$reservation->reservation_id}}"name="reservation_id" hidden>
                                    <label class="block font-medium text-gray-700">Number of Months</label>
                                    <input type="number" min="1" name="extend" placeholder="Number of months" class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 mt-8">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                                    Submit
                                </button>
                                <button x-on:click="$dispatch('close-modal', {name:'extend'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg">
                                    Close
                                </button>
                            </div>
                        </form>
                    </x-slot:body>
                </x-modal>
                    @endif

                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-4">Payment Information</h3>
                    <p><strong>Next Payment Due:</strong> Oct 1, 2024</p>
                    <p><strong>Amount Due:</strong> $1,500</p>
                    <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">Make a Payment</button>
                </div>
            </div>

            <!-- Maintenance Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-4">Maintenance Requests</h3>
                    <p><strong>Current Request:</strong> Leaky faucet in kitchen - Status: In Progress</p>
                    <p><strong>Submitted On:</strong> Sept 10, 2024</p>
                    <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">Submit New Request</button>
                </div>
            </div>

            <!-- Announcements -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-4">Announcements</h3>
                    <ul>
                        <li><strong>Sept 12, 2024:</strong> Maintenance will be conducted in the common areas from 10 AM - 2 PM.</li>
                        <li><strong>Sept 5, 2024:</strong> Fire alarm testing is scheduled for Sept 20, 2024. Please be prepared for brief interruptions.</li>
                        <li><strong>Aug 28, 2024:</strong> New recycling policies have been implemented. Please check your email for details.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    @endforeach
@stop
</x-renter-layout>
