@section('title', 'Dashboard')

@section('content')
<x-app-layout>
  <div class="py-6">
    <div class="min-w-full mx-auto">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex flex-col">
          <div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
            <h1 class="text-2xl font-semibold text-black">Dashboard</h1>
          </div>

          <section class="text-gray-700 body-font mx-4">
            <div class="container px-4 py-4 mx-auto">
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4 text-center">
                @foreach([
                  ['route' => 'admin/users', 'icon' => 'user', 'count' => \App\Models\User::count(), 'label' => 'Users', 'color' => 'text-indigo-500'],
                  ['route' => 'admin/reports', 'icon' => 'report', 'count' => \App\Models\Report::count(), 'label' => 'Reports', 'color' => 'text-red-500'],
                  ['route' => 'admin/apartment', 'icon' => 'room', 'count' => \Illuminate\Support\Facades\DB::table('apartment')->whereNull('renter_id')->count(), 'label' => 'Vacant Room', 'color' => 'text-green-500'],
                  ['route' => 'admin/reservations', 'icon' => 'reservation', 'count' => \Illuminate\Support\Facades\DB::table('reservations')->whereNotNull('user_id')->whereDate('check_in', '>', \Carbon\Carbon::now())->count(), 'label' => 'Reservations', 'color' => 'text-indigo-500']
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
            <div class="bg-white p-4 rounded-lg shadow">
              <ul class="divide-y divide-gray-200">
                @forelse(\Spatie\Activitylog\Models\Activity::latest()->take(10)->get() as $activity)
                  @php
                    $properties = json_decode($activity->properties, true);
                    $activityData = [];
                    switch ($activity->log_name) {
                      case 'apartment':
                        $apartment = \App\Models\Appartment::find($activity->subject_id);
                        $buildingName = \App\Models\Building::find($properties['attributes']['building_id'] ?? $apartment->building_id)->name ?? 'N/A';
                        $apartmentType = \App\Models\Category::find($properties['attributes']['category_id'] ?? $apartment->category_id)->name ?? 'N/A';
                        $activityData = [
                          'Building Name' => ['value' => $buildingName, 'updated' => isset($properties['attributes']['building_id'])],
                          'Apartment type' => ['value' => $apartmentType, 'updated' => isset($properties['attributes']['category_id'])],
                          'Room Number' => ['value' => $properties['attributes']['room_number'] ?? $apartment->room_number, 'updated' => isset($properties['attributes']['room_number'])],
                          'Status' => ['value' => $properties['attributes']['status'] ?? $apartment->status, 'updated' => isset($properties['attributes']['status'])]
                        ];
                        break;
                      case 'building':
                        $building = \App\Models\Building::find($activity->subject_id);
                        $activityData = [
                          'Building Name' => ['value' => $properties['attributes']['name'] ?? $building->name, 'updated' => isset($properties['attributes']['name'])],
                          'Units' => ['value' => $properties['attributes']['units'] ?? $building->units, 'updated' => isset($properties['attributes']['units'])],
                          'Parking Space' => ['value' => isset($properties['attributes']['parking_space']) 
                            ? ($properties['attributes']['parking_space'] == 1 ? 'Yes' : 'No') 
                            : ($building->parking_space == 1 ? 'Yes' : 'No'),
                          'updated' => isset($properties['attributes']['parking_space'])]
                        ];
                        break;
                      case 'report':
                        $report = \App\Models\Report::find($activity->subject_id);
                        $user = \App\Models\User::find($properties['attributes']['user_id'] ?? $report->user_id)->name ?? 'N/A';
                        $activityData = [
                          'Category' => ['value' => $properties['attributes']['report_category'] ?? $report->report_category, 'updated' => isset($properties['attributes']['report_category'])],
                          'Description' => ['value' => $properties['attributes']['description'] ?? $report->description, 'updated' => isset($properties['attributes']['description'])],
                          'User' => ['value' => $user, 'updated' => isset($properties['attributes']['user_id'])]
                        ];
                        break;
                      case 'reservation':
                        $reservation = \App\Models\Reservation::find($activity->subject_id);
                        $user = \App\Models\User::find($properties['attributes']['user_id'] ?? $reservation->user_id)->name ?? 'N/A';
                        $activityData = [
                          'User' => ['value' => $user, 'updated' => isset($properties['attributes']['user_id'])],
                          'Check In Date' => ['value' => \Carbon\Carbon::parse($properties['attributes']['check_in'] ?? $reservation->check_in)->format('M d, Y'), 'updated' => isset($properties['attributes']['check_in'])],
                          'Reservation Price' => ['value' => '₱' . ($properties['attributes']['total_price'] ?? $reservation->total_price), 'updated' => isset($properties['attributes']['total_price'])]
                        ];
                        break;
                      case 'payment':
                        $payment = \App\Models\Payment::find($activity->subject_id);
                        $user = \App\Models\User::find($properties['attributes']['user_id'] ?? $payment->user_id)->name ?? 'N/A';
                        $activityData = [
                          'User' => ['value' => $user, 'updated' => isset($properties['attributes']['user_id'])],
                          'Category' => ['value' => $properties['attributes']['category'] ?? $payment->category, 'updated' => isset($properties['attributes']['category'])],
                          'Payment Method' => ['value' => $properties['attributes']['payment_method'] ?? $payment->payment_method, 'updated' => isset($properties['attributes']['payment_method'])],
                          'Amount' => ['value' => '₱' . ($properties['attributes']['amount'] ?? $payment->amount), 'updated' => isset($properties['attributes']['amount'])]
                        ];
                        break;
                      default:
                        $activityData = ['Unknown Activity Type' => ['value' => ucfirst($activity->log_name), 'updated' => false]];
                        break;
                    }
                  @endphp
                  <li class="py-2">
                    <strong>{{ ucfirst($activity->log_name) }}</strong>: {{ $activity->description }} 
                    <span class="text-sm text-gray-500">- {{ $activity->created_at->diffForHumans() }}</span>
                    <ul class="ml-4 text-sm text-gray-600">
                      @foreach($activityData as $key => $data)
                        <li class="{{ $data['updated']&& $activity->event === 'updated' ? 'bg-yellow-100' : '' }}">
                          <strong>{{ $key }}:</strong> {{ $data['value'] }}
                        </li>
                      @endforeach
                    </ul>
                  </li>
                @empty
                  <li class="py-2 text-gray-500">No activity logs found.</li>
                @endforelse
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  @stop

</x-app-layout>
