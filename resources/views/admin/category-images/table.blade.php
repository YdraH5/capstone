<div class="flex items-center gap-4 mb-4 p-2 bg-gray-50 rounded-lg shadow-sm">
    <div class=" flex gap-2 text-gray-700">
      <h1 class="text-2xl font-semibold text-black">Apartment Images</h1>
    </div>
    <div class="relative w-1/2 ml-auto">
        
    </div>
    <button class="" x-data x-on:click="$dispatch('open-modal',{name:'add-image'})">
        @include('buttons.add')
    </button> 
  </div>
      <x-modal name="add-image" title="Add Image">
        <x-slot:body>
                <form class="space-y-4"action="{{url('/admin/categories/'.$category->id.'/upload')}}"method="post"enctype="multipart/form-data" class="hidden">
                    @csrf
                        <div>
                            <label  class="block font-medium opacity-70">Insert Images</label>
                            <input type="file" name="images[]" class="w-full rounded-lg " placeholder="Images"multiple>
                            <x-input-error :messages="$errors->get('images[]')" class="mt-2" />
                        </div>
                       
                          <div class="flex items-center justify-between py-8">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                            <button  x-on:click="$dispatch('close-modal',{name:'add-apartment'})" type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close
                            </button>
                        </div>
                </form>
        </x-slot:body>
      </x-modal>
<div class="overflow-x-auto bg-white shadow-lg">
    <table class="min-w-full mx-2 border-collapse">
        <thead>
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                <th class="py-3 px-4 text-center border-b border-indigo-600">
                    Image
                </th>
                <th class="py-3 px-4 text-center border-b border-indigo-600">
                    Action
                </th>
            </tr>
        </thead>
        @foreach ($categoryImages as $image)
        <tbody>
            <tr class="hover:bg-indigo-100">
                <td class="py-3 px-4 text-center border-b border-gray-300">
                    <img class="text-center block thumbnail" src="{{ asset($image->image) }}" style="width:320px;height:320px;" onclick="expandImage(this, 'overlay1', 'expandedImage1')">
                    <div class="overlay" id="overlay1" onclick="closeImage('overlay1', 'expandedImage1')"></div>
                    <div class="expanded-image" id="expandedImage1">
                        <!-- This will be populated dynamically by JavaScript -->
                    </div>
                </td>
                <td class="py-3 px-4 text-center border-b border-gray-300">>
                    <a href="{{ url('admin/category-image/'.$image->id.'/delete') }}" class="mt-auto">
                        @include('buttons.delete')
                    </a>
                </td>
            </tr>   
        @endforeach  
        </tbody>
    </table>
</div>