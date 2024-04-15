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
      <table class="w-full table-auto rounded-lg">
          
          <thead>
              <tr class="bg-neutral-400">
                  <th class="text-center border border-black-900">Report Ticket</th>
                  <th class="text-center border border-black-900">View</th>
              </tr>
          </thead>@foreach($reports as $report)
          <tbody>
              <tr>
                  <td class="text-center border border-black-900">{{$report->ticket}}</td>
                  <td class="border border-black-900 flex justify-center">
                    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'view-report'})">
                        @include('components.view-icon')
                    </button>
                    <x-modal name="view-report" title="Report Full Details">
                        <x-slot:body>
                            <div class="p-4">
                                <div class="mb-4">
                                    <span class="font-semibold">Report Category:</span> {{$report->report_category}}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Report Date:</span> {{$report->date}}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Report Status:</span> {{$report->status}}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Report Ticket:</span> {{$report->ticket}}
                                </div>
                                <div class="mb-4">
                                    <span class="font-semibold">Report Description:</span> {{$report->description}}
                                </div>
                                <button  x-on:click="$dispatch('close-modal',{name:'view-report'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                            </div>
                        </x-slot:body>
                    </x-modal>
                  </td>
              </tr>
          </tbody>
          @endforeach
          
      </table>
  </div>
 
  {{-- Solved report table --}}
  <div class="w-full sm:w-1/2 bg-gray-100 px-2 rounded-lg p-6 shadow-md">
      <h2 class="text-lg font-semibold mb-4 flex justify-center">Solved Reports</h2>
      <table class="w-full table-auto">
          <thead>
            <tr class="bg-neutral-400">
                <th class="text-center border border-black-900">Report Ticket</th>
                <th class="text-center border border-black-900">View</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <td class="text-center border border-black-900">{{$report->ticket}}</td>
                <td class="border border-black-900 flex justify-center">
                  <button class="" x-data x-on:click="$dispatch('open-modal',{name:'view-solve-report'})">
                      @include('components.view-icon')
                  </button>
                  <x-modal name="view-solve-report" title="Report Full Details">
                      <x-slot:body>
                          <div class="p-4">
                              <div class="mb-4">
                                  <span class="font-semibold">Report Category:</span> {{$report->report_category}}
                              </div>
                              <div class="mb-4">
                                  <span class="font-semibold">Report Date:</span> {{$report->date}}
                              </div>
                              <div class="mb-4">
                                <span class="font-semibold">Report Status:</span> {{$report->status}}
                            </div>
                              <div class="mb-4">
                                  <span class="font-semibold">Report Ticket:</span> {{$report->ticket}}
                              </div>
                              <div class="mb-4">
                                  <span class="font-semibold">Report Description:</span> {{$report->description}}
                              </div>
                              <button  x-on:click="$dispatch('close-modal',{name:'view-report'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
                          </div>
                      </x-slot:body>
                  </x-modal>
                </td>
              </tr>
              <!-- Add more rows as needed -->
          </tbody>
      </table>
  </div>
</div>
<script src="{{ asset('js/view.js') }}">
   
  </script>