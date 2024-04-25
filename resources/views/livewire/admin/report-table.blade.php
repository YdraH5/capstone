<div>
    <div>
        <input wire:model.debounce.100ms.live="search" type="search" class="mb-5 mt-2 text-black-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-1/4 h-8 flex items-center pl-3 text-sm border-black rounded border" name="" id="">
    </div>
    <div class="overflow-x-auto">
        <table class="table-auto h-full w-full border-seperate">
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
                    <td class="text-center border border-black-900 border-2">{{$report->status}}</td>
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
                            class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        >Take Action
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
