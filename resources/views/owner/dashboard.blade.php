@section('title', 'Dashboard')

@section('content')
<x-owner-layout>
  <div class="py-6">
    <div class="min-w-full mx-auto">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col">
          <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <h1 class="text-2xl font-semibold text-black">Admin Dashboard</h1>
          </div>

          <section class="text-gray-700 body-font mx-4">
            <div class="container px-4 py-4 mx-auto">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4 text-center">
                @foreach([
                  ['route' => '/owner/users', 'icon' => 'user', 'count' => \App\Models\User::count(), 'label' => 'Users', 'color' => 'text-indigo-500'],
                  ['route' => '/owner/reports', 'icon' => 'report', 'count' => \App\Models\Report::count(), 'label' => 'Reports', 'color' => 'text-red-500'],
                  ['route' => '/owner/apartment', 'icon' => 'room', 'count' => \Illuminate\Support\Facades\DB::table('apartment')->whereNull('renter_id')->count(), 'label' => 'Vacant Room', 'color' => 'text-green-500'],
                  ['route' => '/owner/reservations', 'icon' => 'reservation', 'count' => \Illuminate\Support\Facades\DB::table('reservations')->whereNotNull('user_id')->whereDate('check_in', '>', \Carbon\Carbon::now())->count(), 'label' => 'Reservations', 'color' => 'text-indigo-500']
                ] as $item)
                  <div class="p-4">
                    <a href="{{ $item['route'] }}">
                      <div class="border-2 border-gray-600 px-4 py-6 rounded-lg transform transition duration-500 hover:scale-105">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="{{ $item['color'] }} w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                          @switch($item['icon'])
                            @case('user')
                              <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                              <circle cx="9" cy="7" r="4"></circle>
                              <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                              @break
                            @case('report')
                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                              @break
                            @case('room')
                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                              @break
                            @case('reservation')
                              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                              @break
                            @case('payment')
                              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                              @break
                          @endswitch
                        </svg>
                        <h2 class="title-font font-medium text-3xl text-gray-900">{{ $item['count'] }}</h2>
                        <p class="leading-relaxed">{{ $item['label'] }}</p>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </section>
          <section class="text-gray-700 body-font mx-4 mt-6">
    <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>

    <div class="bg-white p-4 rounded-lg shadow-lg">
        {{-- Grid layout with two columns on large screens (lg: grid-cols-2) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($recentActivities as $activity)
                @php
                    // Decode the properties from the activity log
                    $properties = json_decode($activity->properties, true);
                    $activityData = [];

                    // Switch case for different activity log types
                    switch ($activity->log_name) {
                        case 'apartment':
                            $apartment = \App\Models\Appartment::withTrashed()->find($activity->subject_id);
                            $user = \App\Models\User::find($activity->subject_id);
                            if ($apartment) {
                                $buildingName = \App\Models\Building::find($apartment->building_id)->name ?? 'N/A';
                                $activityData = [
                                    'Building Name' => $buildingName,
                                    'Room Number' => $apartment->room_number,
                                    'Renter' => $user->name ?? 'N/A',
                                    'Status' => $apartment->status,
                                ];
                            }
                            break;
                        case 'reservation':
                            $reservation = \App\Models\Reservation::withTrashed()->find($activity->subject_id);
                            $user = \App\Models\User::find($activity->subject_id);
                            if ($reservation) {
                                $customer = \App\Models\User::find($reservation->user_id)->name ?? 'N/A';
                                $activityData = [
                                    'Customer' => $customer,
                                    'Check in Date' => Carbon\Carbon::parse($reservation->check_in)->format('F j, Y'),
                                    'Rental Period' => $reservation->rental_period,
                                ];
                            }
                            break;
                        case 'building':
                            $building = \App\Models\Building::withTrashed()->find($activity->subject_id);
                            if ($building) {
                                $activityData = [
                                    'Building Name' => $building->name,
                                    'Units' => $building->units,
                                    'Parking Space' => $building->parking_space ? 'Yes' : 'No',
                                ];
                            }
                            break;
                        case 'payment':
                            $payment = \App\Models\Payment::withTrashed()->find($activity->subject_id);
                            if ($payment) {
                                $user = \App\Models\User::find($payment->user_id)->name ?? 'N/A';
                                $activityData = [
                                    'User' => $user,
                                    'Amount' => '₱' . $payment->amount,
                                    'Payment Method' => $payment->payment_method,
                                    'Payment Category' => $payment->category,
                                ];
                            }
                            break;
                        case 'report':
                            $report = \App\Models\Report::withTrashed()->find($activity->subject_id);
                            if ($report) {
                                $user = \App\Models\User::find($report->user_id)->name ?? 'N/A';
                                $activityData = [
                                    'Category' => $report->report_category,
                                    'Description' => $report->description,
                                    'User' => $user,
                                ];
                            }
                            break;
                    }
                @endphp

                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                @switch($activity->log_name)
                                    @case('apartment')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        @break
                                    @case('reservation')
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        @break
                                    @case('building')
                                        <path d="M5 21v-8h14v8m0 0v2H5v-2m6-10h2M8 5h8m-4 0v6"></path>
                                        @break
                                    @case('payment')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    @break
                                    @case('report')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                    @break
                                @endswitch
                            </svg>
                            <div class="text-lg font-semibold text-gray-900">{{ ucfirst($activity->log_name) }}</div>
                        </div>
                        <div class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>

                    <div class="mb-4">
                        @if($activity->event === 'deleted')
                            <span class="text-red-500">Deleted</span>
                        @elseif($activity->event === 'updated')
                            <span class="text-yellow-500">Updated</span> 
                        @elseif($activity->event === 'created')
                            <span class="text-green-500">Created</span> 
                        @else
                            {{ $activity->description }}
                        @endif
                    </div>
                    
                    {{-- Activity details --}}
                    <div class="space-y-2 text-sm text-gray-700">
                        @foreach($activityData as $key => $value)
                            <div class="flex justify-between">
                                <span class="font-medium">{{ $key }}:</span>
                                <span>{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-gray-500">No activity logs found.</div>
            @endforelse
        </div>
    </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  @stop

</x-owner-layout>
