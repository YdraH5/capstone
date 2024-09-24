<div>
    <x-modal name="add-payment" title="Add Payment">
        <x-slot:body>
            <!-- Form -->
            <form  class="space-y-4" wire:submit.prevent="save">
                <div class="md:grid-cols-2 lg:grid lg:grid-cols-2 xl:grid-cols-2 gap-4 ">
                    <div class="lg:col-span-1 xl:col-span-1">

                        <label class="block font-medium opacity-70">Username</label>
                        <input type="text" wire:model="username" placeholder="Username" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border" wire:keyup="searchUser">
                        @if($users)
                        <ul class="bg-white border rounded mt-2 max-h-40 overflow-y-auto">
                            @foreach($users as $user)
                                <li wire:click="selectUser('{{ $user->id }}', '{{ $user->name }}')" class="p-2 cursor-pointer hover:bg-gray-200">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                        
                        @endif
                        @error('username') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <div class="lg:col-span-1 xl:col-span-1">
                        <label class="block font-medium opacity-70">Amount</label>
                        <input type="number" wire:model="amount" placeholder="Amount" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('amount') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Room Info</label>
                        <select wire:model="apartment_id" placeholder="Room Info" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>Select</option>
                            @foreach ($apartments as $room)
                                <option value="{{$room->id}}">{{$room->building}}-{{$room->room_number}}</option>
                            @endforeach
                        </select>
                        @error('room_id') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Payment Method</label>
                        <select wire:model="payment_method" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>Select</option>
                            <option value="Credit Card">Stripe</option>
                            <option value="Cash">Cash</option>
                        </select>
                        @error('payment_method') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Status</label>
                        <select wire:model="status" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>Select</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Paid</option>
                            <option value="Failed">With balance</option>
                        </select>
                        @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block font-medium opacity-70">Category</label>
                        <select wire:model="category" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                            <option value="" disabled selected hidden>select</option>
                            <option value="Lease">Lease</option>
                            <option value="Pay Balance">Pay balance</option>
                            <option value="Pay penalty">Pay penalty</option>
                        </select>
                        @error('category') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-between py-8">
                    <button x-on:click="$dispatch('close-modal',{name:'add-payment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
