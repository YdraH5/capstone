@section('title', 'Apartment Images')

<x-owner-layout>

@section('content')
  <div class="py-4 px-8">
    <div class="min-w-full mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="flex flex-col">

              @include('owner.category-images.table')

            </div>
          </div>
      </div>
  </div>
  @endsection
</x-owner-layout>