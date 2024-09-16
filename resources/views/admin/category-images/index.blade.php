@section('title', 'Apartment Images')

<x-app-layout>

@section('content')
  <div class="py-4 px-8">
    <div class="min-w-full mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="flex flex-col">

              @include('admin.category-images.table')

            </div>
          </div>
      </div>
  </div>
  @endsection
</x-app-layout>