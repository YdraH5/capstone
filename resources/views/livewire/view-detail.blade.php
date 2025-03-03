<div>
    <form wire:submit.prevent="submitReservation"> <!-- Wrap content in a form -->
        <!-- Check-in Date and Rental Period -->
        <div class="grid grid-cols-2 gap-2 mt-4 mb-4">
            <!-- Check-in Date (now modifiable) -->
            <div class="border border-gray-300 p-2 rounded-lg text-center">
                <label class="block text-xs text-gray-500">CHECK-IN</label>
                <input id="checkin" type="date" class="w-full text-gray-700 text-center" wire:model="checkin">
                @error('checkin') <span class="error text-red-900 text-xs">{{ $message }}</span> @enderror 
            </div>

            <!-- Rental Period (in months) -->
            <div class="border border-gray-300 p-2 rounded-lg text-center">
                <label class="block text-xs text-gray-500">RENTAL PERIOD</label>
                <input type="number" class="w-full text-gray-700 text-center" wire:model="rentalPeriod" min="1" placeholder="Months">
                @error('rentalPeriod') <span class="error text-red-900 text-xs">{{ $message }}</span> @enderror 
            </div>
        </div>

        <!-- Floor Number and Rooms Selection -->
        <div class="grid grid-cols-2 gap-2 mt-4 mb-4">
            <!-- Floor Number -->
            <div class="border border-gray-300 p-2 rounded-lg text-center">
                <label class="block text-xs text-gray-500">FLOOR NUMBER</label>
                <select class="w-full text-gray-700 text-center" wire:model.live="floorNumber">
                    <option value="" disabled selected>Select Floor</option>
                    <option value="any">Any</option>
                    <option value="1">First floor</option>
                    <option value="2">Second floor</option>
                    <option value="3">Third floor</option>
                </select>
                @error('floorNumber') <span class="error text-red-900 text-xs">{{ $message }}</span> @enderror 
            </div>

            <!-- Number of Rooms -->
            <div class="border border-gray-300 p-2 rounded-lg text-center">
                <label class="block text-xs text-gray-500">ROOM NUMBER</label>
                <select class="w-full text-gray-700 text-center" wire:model="roomNumber">
                    <option value="" disabled {{ count($rooms) > 1 ? 'selected' : '' }}>Select Room</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                    @endforeach
                </select>
                @error('roomNumber') <span class="error text-red-900 text-xs">{{ $message }}</span> @enderror 
                
                @if (count($rooms) === 1)
                    <div class="text-green-500 text-xs mt-1 hidden">{{ $rooms[0]->room_number }}</div>
                @endif
            </div>

        </div>
        
        <!-- No Rooms Available Message -->
        @if ($noRoomsMessage)
            <div class="text-red-500 text-center mt-2">
                {{ $noRoomsMessage }}
            </div>
        @endif

        <!-- Guests Dropdown Button -->
        <div class="relative">
            <button type="button" wire:click="$toggle('showDropdown')" class="border border-gray-300 rounded-lg w-full p-2 mt-1 flex justify-between items-center text-black">
                <span>{{ $adults + $children }} tenant{{ ($adults + $children) > 1 ? 's' : '' }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Guests Dropdown Content (shown when the dropdown is active) -->
            @if($showDropdown)
                <div class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg p-4 " style="max-height: 200px; overflow-y: auto;">
                    <!-- Adults -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-gray-500">Adults (Age 13+)</span>
                        <div class="flex items-center">
                            <button type="button" wire:click="decreaseAdults" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">-</button>
                            <span class="mx-2 text-gray-700">{{ $adults }}</span>
                            <button type="button" wire:click="increaseAdults" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- Children -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-gray-500">Children (Ages 2-12)</span>
                        <div class="flex items-center">
                            <button type="button" wire:click="decreaseChildren" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">-</button>
                            <span class="mx-2 text-gray-700">{{ $children }}</span>
                            <button type="button" wire:click="increaseChildren" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- Infants -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-gray-500">Infants (Under 2)</span>
                        <div class="flex items-center">
                            <button type="button" wire:click="decreaseInfants" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">-</button>
                            <span class="mx-2 text-gray-700">{{ $infants }}</span>
                            <button type="button" wire:click="increaseInfants" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">+</button>
                        </div>
                    </div>

                    <!-- Pets -->
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs text-gray-500">Pets</span>
                        <div class="flex items-center">
                            <button type="button" wire:click="decreasePets" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">-</button>
                            <span class="mx-2 text-gray-700">{{ $pets }}</span>
                            <button type="button" wire:click="increasePets" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-lg">+</button>
                        </div>
                    </div>

                    <button type="button" wire:click="$set('showDropdown', false)" class="text-xs text-gray-700 underline">Close</button>
                </div>
            @endif

        </div>

        @if ($available > 0)
            <!-- Reserve Button -->
            <button type="submit" class="bg-blue-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg w-full mt-4">
                Reserve
            </button>
        @else
            <button class="bg-gray-300 text-gray-600 px-6 py-3 rounded-full cursor-not-allowed opacity-50" disabled>
                No Rooms Available
            </button>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    x-data x-on:click="$dispatch('open-modal', { name: 'notify-me' })">
                Notify Me
            </button>
            <x-modal name="notify-me" title="Notify Me!">
                <x-slot name="body">
                    <div class="p-4">
                        <p class="text-lg text-gray-600 font-semibold mb-4">
                        By opting in for notifications, you agree to receive emails regarding the availability of rooms in this apartment. We respect your privacy and will not share your email address with third parties.
                        </p>
                        <p class="text-gray-600 mb-8">
                        You can unsubscribe from these notifications at any time by following the link provided in the email. For more details on how we handle your personal information, please refer to our privacy policy.
                        </p>
                        <div class="flex justify-end">
                            <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal', { name: 'notify-me' })">Cancel
                            </button>
                        <a href="{{ route('emails.notify') }}" class="bg-blue-500 hover:bg-blue-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            Accept
                        </a>
                        </div>
                    </div>
                </x-slot>
            </x-modal>
        @endif

        <div class="text-xs text-center text-gray-500 mt-2">You won't be charged yet</div>

        <!-- Pricing Breakdown -->
        <div class="mt-4 text-gray-700">
            <!-- Pricing details can be added here if needed -->
        </div>
    </form> <!-- Close form tag -->
</div>
<script>
    function setMinCheckInDate() {
        var today = new Date();
        var oneWeekFromNow = new Date();
        var thirtyDaysFromNow = new Date();

        // Add 7 days to the current date for the minimum allowed date
        oneWeekFromNow.setDate(today.getDate() + 7);

        // Add 30 days to the current date for the maximum allowed date
        thirtyDaysFromNow.setDate(today.getDate() + 35);

        // Format the dates as yyyy-mm-dd
        var minAllowedDate = oneWeekFromNow.toISOString().split('T')[0];
        var maxAllowedDate = thirtyDaysFromNow.toISOString().split('T')[0];

        // Set the min attribute to one week from now
        document.getElementById('checkin').setAttribute('min', minAllowedDate);
        // Set the max attribute to thirty days from now
        document.getElementById('checkin').setAttribute('max', maxAllowedDate);
    }

    // Call the function on page load
    window.onload = setMinCheckInDate;

    // Listen for the event dispatched from Livewire
    window.addEventListener('set-min-checkin-date', setMinCheckInDate);
</script>

