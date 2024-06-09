<div>
    <div class="flex justify-start mx-2 mb-5 mt-2">
        <input wire:model.debounce.300ms.live="search" type="search" placeholder="Search...."
            class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
    </div>
    <div class="overflow-x-auto">
        <table class="table-auto h-full w-full mx-2  border-seperate">
            <thead> 
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
                <tr class="bg-gray-300 rounded">
                    <th class="text-center border border-black-900 border-2">Reporters</th>
                    <th class="text-center border border-black-900 border-2">Room Info</th>
                    <th class="text-center border border-black-900 border-2">Report Category</th>
                    <th class="text-center border border-black-900 border-2">Description</th>
                    <th class="text-center border border-black-900 border-2">Ticket</th>
                    <th class="text-center border border-black-900 border-2">Status</th>
                    <th class="text-center border border-black-900 border-2">Date</th>
                    <th class="text-center border border-black-900 border-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr class="bg-white hover:bg-gray-300 odd:bg-white even:bg-slate-50">
                    <td class="text-center border border-black-900 border-2">{{$report->name}}</td>
                    <td class="text-center border border-black-900 border-2">{{$report->building}}-{{$report->room_number}}</td>
                    <td class="text-center border border-black-900 border-2">{{$report->report_category}}</td>
                    <td class="text-center border border-black-900 border-2">{{$report->description}}</td>
                    <td class="text-center border border-black-900 border-2">{{$report->ticket}}</td>
                    @if($report->status === 'Solved')
                    <td class="text-center border bg-green-100 border-black-900 border-2">{{$report->status}}</td>
                        @else
                    <td class="text-center border bg-yellow-100 border-black-900 border-2">{{$report->status}}</td>
                        @endif
                    <td class="text-center border border-black-900 border-2">{{ \Carbon\Carbon::parse($report->date)->diffForHumans() }}</td>
                    <td class=" border border-black-900 border-2">
                        <x-modal name="solve-report" title="Solve Report">
                            <x-slot:body>
                                <form id="modalForm" class="space-y-4 "wire:submit.prevent="action">
                                    <div>
                                        <input type="hidden"wire:model="id">
                                        <label class="block font-medium opacity-70">Status</label>
                                        <input type="text" wire:model="status" placeholder="Status" class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                        @error('status') <span class="error text-red-900">{{ $message }}</span> @enderror 
                                    </div>
                                    <div class="flex items-center justify-between py-8">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                                    </div>
                                </form>
                            </x-slot:body>
                        </x-modal>
                        <div class="btn-group flex justify-center">
                            <button
                            x-data="{ id: {{$report->id}} }"
                            x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'solve-report' })"
                            wire:click="edit(id)"
                            type="button"
                            class="px-5 py-2.5 text-center me-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="blue" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                          </svg>
                          
                            </button>
                            
                        </div>
                    </td>           
                </tr>
                @endforeach   
        </tbody>
        </table>
        {{ $reports->links('components.pagination')}}

    </div>

</div>
