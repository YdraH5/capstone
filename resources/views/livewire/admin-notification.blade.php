    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20">
        @foreach($categories as $category)
        <a href="/admin/users?search=Alucard" class="block px-4 py-2 text-gray-800 border-b hover:bg-gray-200">{{$category->id}}</a>
       @endforeach
    </div>
