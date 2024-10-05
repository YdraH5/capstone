<div>
    <x-modal name="add-payment" title="Add Payment">
        <x-slot:body>
            <!-- Form -->
            <form class="space-y-4" wire:submit.prevent="save">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="col-span-1">
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

                    <div class="col-span-1">
                        <label class="block font-medium opacity-70">Amount</label>
                        <input type="number" wire:model="amount" placeholder="Amount" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('amount') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1">
                        <label class="block font-medium opacity-70">Room Info</label>
                        <input type="text" wire:model="category" placeholder="Apartment type" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                        @error('category') <span class="error text-red-900">{{ $message }}</span> @enderror
                    </div>

                    @if($selectedUserId)
                    @if($dueDates && $dueDates->count())
                        <div class="col-span-1">
                            <label class="block font-medium opacity-70">Due Dates</label>
                            <select wire:model="duedate_id" class="mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                <option value="" selected >Select</option> <!-- Placeholder -->
                                @foreach($dueDates as $dueDate)
                                    <option value="{{ $dueDate->id }}">{{ \Carbon\Carbon::parse($dueDate->payment_due_date)->format('F j, Y') }}</option>
                                @endforeach
                            </select>

                            @error('duedate_id') <span class="error text-red-900">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div class="col-span-1">
                            <p class="mt-2 text-green-600 font-semibold">Payments are up to date</p>
                        </div>
                    @endif
                @endif



                </div>

                <div class="flex items-center justify-between py-8">
                    <button x-on:click="$dispatch('close-modal',{name:'add-payment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </form>
        </x-slot:body>
    </x-modal>
</div>
