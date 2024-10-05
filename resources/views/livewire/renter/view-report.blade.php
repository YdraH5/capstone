<div>
    <!-- Flex container for the entire content -->
    <div class="w-full bg-gray-100 px-2 rounded-lg p-6 shadow-md">
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

        {{-- Combined report table --}}
        <h2 class="text-lg font-semibold mb-4 flex justify-center">All Reports</h2>
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-indigo-500 text-white uppercase text-sm">
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Report ID</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Category</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Date Submitted</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Description</th>
                    <th class="py-3 px-4 text-center border-b border-indigo-600">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr class="hover:bg-indigo-100">
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->id}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->report_category}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->description}}</td>
                    <td class="py-3 px-4 text-center border-b border-gray-300">{{$report->status}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
