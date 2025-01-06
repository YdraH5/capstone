<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Latest Announcements</h1>

    @if($announcements->isEmpty())
        <p class="text-gray-500 text-center">No announcements available at the moment.</p>
    @else
        <div class="space-y-8">
            @foreach($announcements as $announcement)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 hover:text-blue-500 transition">
                        {{ $announcement->title }}
                    </h2>
                    <p class="text-gray-700 mt-4">
                        {{ Str::limit($announcement->content, 150, '...') }}
                    </p>
                    
                    <div class="mt-4 flex items-center">
                        @if($announcement->priority === 'High')
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Urgent</span>
                        @else
                            <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Normal</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
