<div>
    <div>
        <input wire:model.debounce.100ms.live="search" type="search"placeholder="Search...." class="mb-5 mt-2 text-black-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-1/3 h-8 flex items-center pl-3 text-sm border-black rounded border">
    </div>
    <table class="table-auto w-full border-seperate max-w-10xl">
        <thead>
            <tr class="bg-gray-300 rounded">
                <th class="text-center border border-black-900">NAME</th>
                <th class="text-center border border-black-900">EMAIL</th>
                <th class="text-center border border-black-900">ROLE</th>
                <th class="text-center border border-black-900">DATE CREATED</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="text-center border border-black-900">{{$user->name}}</td>
                <td class="text-center border border-black-900">{{$user->email}}</td>
                <td class="text-center border border-black-900">{{$user->role}}</td>
                <td class="text-center border border-black-900">{{$user->date}}</td>
                </td>
            </tr>
            @endforeach   
        </tbody>
      </table>       
 
</div>
