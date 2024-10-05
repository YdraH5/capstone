<div>
                             <!-- modal for adding an admin -->
                             <x-modal name="add-admin" title="Add Admin">
                                <x-slot name="body">
                                    <form wire:submit.prevent="saveAdmin" class="relative space-y-4 ">
                                        <!-- Email Input Field -->
                                        <div>
                                            <label class="block font-medium opacity-70">Email</label>
                                            @error('email') 
                                                <span class="error text-red-900">{{ $message }}</span> 
                                            @enderror
                                            <input type="text" 
                                                wire:model="email" 
                                                placeholder="Enter email" 
                                                class="mt-2 text-gray-600 focus:outline-none focus:border-indigo-700 font-normal w-full h-10 pl-3 border border-gray-300 rounded-md" 
                                                wire:keyup="searchUser">

                                            <!-- Search Results -->
                                            @if(!$selectedEmail)
                                                <ul class="absolute bg-white border rounded mt-1 w-full max-h-40 overflow-y-auto z-10">
                                                    @if($users && $users->isNotEmpty())
                                                        @foreach($users as $user)
                                                            @if($user->role === null)
                                                                <li wire:click="selectUser('{{ $user->id }}', '{{ $user->email }}')" 
                                                                    class="p-1 cursor-pointer hover:bg-gray-200">
                                                                    {{ $user->email }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <li class="p-2 text-gray-500">No emails found</li>
                                                    @endif
                                                </ul>
                                            @endif
                                            
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between py-4">
                                            <button type="submit" 
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                                                Submit
                                            </button>
                                            <button x-on:click="$dispatch('close-modal', {name: 'add-admin'})" 
                                                    type="button" 
                                                    class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                </x-slot>
                            </x-modal>
</div>
