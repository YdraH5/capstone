<!-- Wrap both tables in a flex container -->
<!-- view -->
<div class="flex flex-col sm:flex-row">
  <div class="w-full sm:w-1/2 bg-gray-100 px-2 rounded-lg p-6 shadow-md mb-4 sm:mb-0">
    @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>    
          @endif
          @if (session('failed'))
          <div class="text-red-900">
              {{ session('failed') }}
          </div>    
          @endif
      <h2 class="text-lg font-semibold mb-4 flex justify-center">Pending Report</h2>
      <table class="w-full table-auto rounded-lg">
          
          <thead>
              <tr class="bg-neutral-400">
                  <th class="text-center border border-black-900">Report Category</th>
                  <th class="text-center border border-black-900">View</th>
              </tr>
          </thead>@foreach($reports as $report)
          <tbody>
              <tr>
                  <td class="text-center border border-black-900">{{$report->report_category}}</td>
                  <td class="text-center border border-black-900 flex justify-center">
                      <button class="view-report" data-report-id="{{$report->id}}">
                          @include('components.view-icon')
                      </button>
                      <div id="reportview{{$report->id}}" class="hidden fixed z-10 inset-0 overflow-y-auto">
                          <div class="flex items-center justify-center min-h-screen">
                              <div class="relative bg-white w-1/2 sm:w-1/3 mx-auto rounded-lg shadow-lg">
                                  <!-- view content -->
                                  <div class="p-6">
                                      <h2 class="text-lg font-bold mb-4 flex justify-center">Report Details</h2>
                                      <h6 class="text-sm font-semibold">
                                          Report Category: {{$report->report_category}}
                                          <br>Report Date: {{$report->date}}
                                          <br>Report Ticket: {{$report->ticket}}
                                          <br>Report Description: {{$report->description}}
                                      </h6>
                                      <button data-report-id="{{$report->id}}" class="closeview mt-4 py-2 px-4 bg-gray-200 text-gray-700 rounded-lg focus:outline-none">Close</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </td>
              </tr>
          </tbody>
          @endforeach
          
      </table>
  </div>
  
  <div class="w-full sm:w-1/2 bg-gray-100 px-2 rounded-lg p-6 shadow-md">
      <h2 class="text-lg font-semibold mb-4 flex justify-center">Solved Reports</h2>
      <table class="w-full table-auto">
          <thead>
              <tr class="bg-neutral-400">
                  <th class="text-center border border-black-900">Date</th>
                  <th class="text-center border border-black-900">Description</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td class="border px-4 py-2">April 1, 2024</td>
                  <td class="border px-4 py-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
              </tr>
              <!-- Add more rows as needed -->
          </tbody>
      </table>
  </div>
</div>
<script src="{{ asset('js/view.js') }}">
   
  </script>