<div>
  <div>
    <input wire:model.live="search" type="search" class="mb-5 mt-2 text-black-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-1/4 h-8 flex items-center pl-3 text-sm border-black rounded border" name="" id="">
  </div>
  <div class="overflow-x-auto">
    <table class="table-auto h-full w-full border-separate">
      <thead> 
        @if (session('success'))
        <div class="alert alert-success text-green-700">
            {{ session('success') }}
        </div>    
        @endif
          <tr class="bg-gray-300 rounded">
              <th class="text-center border border-black-900 border-2">Category Name</th>
              <th class="text-center border border-black-900 border-2">Renter</th>
              <th class="text-center border border-black-900 border-2">Room Number</th>
              <th class="text-center border border-black-900 border-2">Price</th>
              <th class="text-center border border-black-900 border-2">Status</th>
              <th class="text-center border border-black-900 border-2">Actions</th>
          </tr>
      </thead>
      <tbody>
          @foreach($apartment as $apartments)
          <tr>
              <td class="text-center border border-black-900 border-2">{{$apartments->categ_name}}</td>
                  @if($apartments->renters_name == NULL)
                  <td class="text-center border border-black-900 border-2 text-red-500">
                      Vacant
                  </td>
                  @else
                  <td class="text-center border border-black-900 border-2">
                      {{$apartments->renters_name}}
                  </td>
                  @endif
              <td class="text-center border border-black-900 border-2">{{$apartments->room_number}}</td>
              <td class="text-center border border-black-900 border-2">{{$apartments->price}}/month</td>
              <td class="text-center border border-black-900 border-2">{{$apartments->status}}</td>
              <td class="text-center border border-black-900 border-2">
                  <div class="flex justify-center items-center">
                      <button id="openModalEdit"onclick="modalHandler(true)">
                        <input type="hidden"wire:model="id"value="{{$apartments->id}}">
                          @include('buttons.edit')
                       </button>
                      <form action="{{route('appartment.delete',['apartment'=>$apartments->id])}}" method="post">
                          @csrf 
                          @method('delete')
                              @include('buttons.delete')
                      </form>
                  </div>
              </td>
          </tr>
          @endforeach  
      </tbody>                       @livewire('apartment-edit')

    </table>
  </div>
</div>
