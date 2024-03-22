<table class="table-auto w-full border-seperate border-2 ">
  <thead>
      <tr>
          <th class="text-center w-10 border border-black-900">#</th>
          <th class="text-center w-24 border border-black-900">Name</th>
          <th class="text-center w-20 border border-black-900">email</th>
          <th class="text-center w-10 border border-black-900">Actions</th>
      </tr>
  </thead>
  <tbody>
      @foreach($users as $user)
      <tr>
          <td class="text-center border border-black-900">{{$user->id}}</td>
          <td class="text-center border border-black-900">{{$user->name}}</td>
          
          <td class="text-center border border-black-900">{{$user->email}}</td>
          <td class="text-center border border-black-900">
                <div class="btn-group">
                  @include('buttons.edit')
                  @include('buttons.delete')
                 
      @endforeach    
                                     
    </div> 
          </td>
      </tr>
  </tbody>
</table>       
