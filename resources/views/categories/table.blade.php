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
          <th class="text-center border border-black-900 border-2">Description</th>
          <th class="text-center border border-black-900 border-2">Actions</th>
      </tr>
  </thead>
  <tbody>
      @foreach($categories as $category)
      <tr>
          <td class="text-center border border-black-900 border-2">{{$category->name}}</td>
          <td class="text-center border border-black-900 border-2">{{$category->description}}</td>
          <td class="text-center border border-black-900 border-2">
              <div class="btn-group flex">
                  <a href="{{route('categories.edit',['categories'=>$category])}}">
                    @include('buttons.edit')
                  </a>
              <form action="{{route('categories.delete',['categories'=>$category])}}"method="post">
                  @csrf 
                  @method('delete')
                  @include('buttons.delete')
              </form>
      @endforeach          
          </td>           
      </tr>
  </tbody>
</div>
</table>