<div>
  <div class="overflow-x-auto ">
  <table class="table-auto w-full border-seperate content-center">
    <thead> 
      @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>    
      @endif
        <tr>
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
                {{-- <div class="btn-group flex">
                    <a href="{{route('categories.edit',['categories'=>$apartments])}}">
                      @include('buttons.edit')
                    </a>
                <form action="{{route('categories.delete',['categories'=>$apartments])}}"method="post">
                    @csrf 
                    @method('delete')
                    @include('buttons.delete')
                </form> --}}
        @endforeach  
        
            </td>           
        </tr>
    </tbody>
  </div>
  </table>