<div>
    <div class="flex justify-start mb-5 mt-2">
        <input wire:model.debounce.300ms.live="search" type="search" placeholder="Search...."
            class="w-1/2 h-10 px-4 py-2 text-gray-600 placeholder-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
    </div>
    <div class="overflow-x-auto ">
    <table class="table-auto w-full border-seperate">
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
            <tr class="bg-white hover:bg-gray-300 odd:bg-white even:bg-slate-50">
                <td class="text-center border border-black-900">{{$user->name}}</td>
                <td class="text-center border border-black-900">{{$user->email}}</td>
                <td class="text-center border border-black-900">{{$user->role}}</td>
                <td class="text-center border border-black-900">{{$user->date}}</td>
                </td>
            </tr>
            @endforeach   
        </tbody>
      </table>     
      {{ $users->links('components.pagination')}}  
    </div>
</div>
