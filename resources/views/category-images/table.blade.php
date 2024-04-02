
<table class="container mx-auto mt-2">
    <thead>
        <tr>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                Image
            </th>
            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                Action
            </th>
        </tr>
    </thead>
    @foreach ($categoryImages as $image)
    <tbody>
        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
            <td class="w-full lg:w-auto p-3 text-gray-800 border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Image</span>
                <img class="text-center block thumbnail" src="{{ asset($image->image) }}" style="width:320px;height:320px;" onclick="expandImage(this, 'overlay1', 'expandedImage1')">
                <div class="overlay" id="overlay1" onclick="closeImage('overlay1', 'expandedImage1')"></div>
                <div class="expanded-image" id="expandedImage1">
                    <!-- This will be populated dynamically by JavaScript -->
                </div>
            </td>
            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                <a href="{{ url('category-image/'.$image->id.'/delete') }}" class="mt-auto">@include('buttons.delete')</a>
            </td>
        </tr>
        
        
        
      @endforeach  
    </tbody>
</table>

