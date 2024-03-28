<table class="table-auto w-full border-seperate border-2 ">
  <thead>
      <tr>
          <th class="text-center w-24 border border-black-900">Name</th>
          <th class="text-center w-20 border border-black-900">email</th>
          <th class="text-center w-20 border border-black-900">Roles</th>
      </tr>
  </thead>
  <tbody>
      @foreach($users as $user)
      <tr>
          <td class="text-center border border-black-900">{{$user->name}}</td>
          <td class="text-center border border-black-900">{{$user->email}}</td>
          <td class="text-center border border-black-900">{{$user->role}}</td>
      @endforeach    

          </td>
      </tr>
  </tbody>
</table>       
