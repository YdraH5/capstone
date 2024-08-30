<div>
    <!-- Wrap both tables in a flex container -->
<!-- view -->
<div class="flex flex-col sm:flex-row">
    <div class="w-full sm:w-1/2 bg-gray-100 px-2 rounded-lg p-6 shadow-md mb-4 sm:mb-0">
      @if (session('success'))
            <div class="text-green-800">
                {{ session('success') }}
            </div>    
            @endif
            @if (session('failed'))
            <div class="text-red-900">
                {{ session('failed') }}
            </div>    
            @endif
  
            {{-- pending report table --}}
        <h2 class="text-lg font-semibold mb-4 flex justify-center">Pending Report</h2>
        <table class="min-w-full border-collapse ">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Report ID</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    @if($report->status !== 'Fixed')
                    <tr class="hover:bg-indigo-100 ">
                        <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->id}}</td>
                        <td class="py-3 px-4 text-center border-b border-gray-300">
                                <button
                                    x-data="{ id: {{$report->id}} }"
                                    x-on:click="$wire.set('id', id); $dispatch('open-modal', { name: 'view-report-{{$report->id}}' })"
                                    wire:click="view(id)"
                                    type="button">
                                    @include('components.view-icon')
                                </button>
                                <x-modal :name="'view-report-'.$report->id" title="Report Full Details">
                                    <x-slot name="body">
                                        <div class="p-4">
                                            <div class="mb-4">
                                                <p class="font-semibold">Report Category:</p> {{$report->report_category}}
                                            </div>
                                            <div class="mb-4">
                                                <p class="font-semibold">Report Date:</p> {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}
                                            </div>
                                            <div class="mb-4">
                                                <p class="font-semibold">Report Status:</p> {{$report->status}}
                                            </div>
                                            <div class="mb-4">
                                                <p class="font-semibold">Report ID:</p> {{$report->id}}
                                            </div>
                                            <div class="mb-4">
                                                <p class="font-semibold">Report Description:</p> {{$report->description}}
                                            </div>
                                            <button  x-on:click="$dispatch('close-modal',{name:'view-report'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                                            </button>
                                        </div>
                                    </x-slot>
                                </x-modal>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
    </div>
   
    {{-- Fixed report table --}}
    <div class="w-full sm:w-1/2 bg-gray-100 px-2 rounded-lg p-6 shadow-md">
        <h2 class="text-lg font-semibold mb-4 flex justify-center">Fixed Reports</h2>
        <table class="min-w-full border-collapse ">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Report ID</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">View</th>
                </tr>
            </thead>
            @foreach($reports as $report)
            @if($report->status === 'Fixed')
            <tbody>
                <tr class="hover:bg-indigo-100 ">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->id}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">
                    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'view-solve-report'})">
                        @include('components.view-icon')
                    </button>
                    <x-modal name="view-solve-report" title="Report Full Details">
                        <x-slot:body>
                            <div class="p-4">
                                <div class="mb-4">
                                    <p class="font-semibold">Report Category:</p> {{$report->report_category}}
                                </div>
                                <div class="mb-4">
                                    <p class="font-semibold">Report Date:</p> {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}
                                </div>
                                <div class="mb-4">
                                  <p class="font-semibold">Report Status:</p> {{$report->status}}
                              </div>
                                <div class="mb-4">
                                    <p class="font-semibold">Report ID:</p> {{$report->id}}
                                </div>
                                <div class="mb-4">
                                    <p class="font-semibold">Report Description:</p> {{$report->description}}
                                </div>
                                <button  x-on:click="$dispatch('close-modal',{name:'view-solve-report'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                            </div>
                        </x-slot:body>
                    </x-modal>
                  </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
