<div>
  <div class="overflow-x-auto ">
  <table class="table-auto w-full border-seperate">
    <thead> 
      @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>    
      @endif
        <tr>
            <th class="text-center border border-black-900 border-2">Reporters</th>
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
        <tr>
            <td class="text-center border border-black-900 border-2">{{$report->name}}</td>
            <td class="text-center border border-black-900 border-2">{{$report->report_category}}</td>
            <td class="text-center border border-black-900 border-2">{{$report->description}}</td>
            <td class="text-center border border-black-900 border-2">{{$report->ticket}}</td>
            <td class="text-center border border-black-900 border-2">{{$report->status}}</td>
            <td class="text-center border border-black-900 border-2">{{$report->date}}</td>
            <td class="text-center border border-black-900 border-2">
                <div class="btn-group flex content-center">
                 <input type="button" value="Take Action"class="cursor-pointer">
        @endforeach          
            </td>           
        </tr>
    </tbody>
  </div>
  </table>