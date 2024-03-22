<div class="overflow-x-auto">
<table class="table-auto w-full border-seperate border-2 ">
  <thead>
      <tr>
          <th class="text-center w-15 border border-black-900">Category Name</th>
          <th class="text-center w-55 border border-black-900">Description</th>
          <th class="text-center w-20 border border-black-900">Actions</th>
      </tr>
  </thead>
  <tbody>
      @foreach($categories as $category)
      <tr>
          <td class="text-center border border-black-900">{{$category->name}}</td>
          <td class="text-center border border-black-900">{{$category->description}}</td>
          <td class="text-center border border-black-900">
              <div class="btn-group">
                  <a href="{{route('categories.edit',['categories'=>$category])}}">
                    @include('buttons.edit')
                  </a>
              <form action="{{route('categories.delete',['categories'=>$category])}}"method="post">
                  @csrf 
                  @method('delete')
                  
                  @include('buttons.delete')
              </td>
              </form>
      @endforeach    
                                     
              </div>
          
      </tr>
  </tbody>
</table>