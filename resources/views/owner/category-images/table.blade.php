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
                <form class="space-y-4"action="{{url('/owner/categories/'.$category->id.'/upload')}}"method="post"enctype="multipart/form-data" class="hidden">
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
<!-- Image Table -->
<div class="overflow-x-auto bg-white shadow-lg">
                @if (session('success'))
                    <div class="text-green-400">
                      {{session('success')}}
                    </div>
                @else
                @endif
    <table class="min-w-full mx-2 border-collapse">
        <thead>
            <tr class="bg-indigo-500 text-white uppercase text-sm">
                <th class="py-3 px-4 text-center border-b border-indigo-600 w-1/6">
                    Image
                </th>
                <th class="py-3 px-4 text-center border-b border-indigo-600 w-4/6">
                    Description
                </th>
                <th class="py-3 px-4 text-center border-b border-indigo-600 w-1/6">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($categoryImages as $image)
            <tr class="hover:bg-indigo-100">
                <td class="py-3 px-4 text-center border-b border-gray-300">
                    <!-- Thumbnail image -->
                    <img class="text-center block thumbnail cursor-pointer" 
                         src="{{ asset($image->image) }}" 
                         style="width:100px;height:100px;" 
                         onclick="openModal('{{ asset($image->image) }}')"> <!-- Set up image click event -->
                </td>
                <td class="py-3 px-4 text-left text-xl border-b border-gray-300">
                    
                        <form action="{{url('/owner/categories/'.$image->id.'/description')}}"method="post">
                            @csrf
                            <div class="flex">
                                <input name="description"type="text"placeholder="Image Description" value="{{$image->description}}"class="text-xl text-gray-600 focus:outline-none focus:border focus:border-indigo-700 focus:ring-2 focus:ring-indigo-500 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border">
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                @if(!$image->description)
                                <button class="" x-data >
                                        @include('buttons.add')
                                </button> 
                                @else
                                <button>
                                    @include('buttons.edit')
                                </button>
                                @endif
                            </div>
                        </form>
                </td>
                <td class="py-3 px-4 text-center border-b border-gray-300">
                    <a href="{{ url('owner/category-image/'.$image->id.'/delete') }}" class="mt-auto">
                        @include('buttons.delete')
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for full-size image -->
<div id="imageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-75">
    <span class="absolute top-0 right-0 m-4 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
    <img id="fullImage" class="max-w-full max-h-full">
</div>

<script>
    // Function to open the modal and display the full-size image
    function openModal(imageSrc) {
        document.getElementById('fullImage').src = imageSrc; // Set image source
        document.getElementById('imageModal').style.display = 'flex'; // Show modal
        document.addEventListener('keydown', handleEscKey); // Add ESC key listener
        document.addEventListener('click', handleOutsideClick); // Add outside click listener
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('imageModal').style.display = 'none'; // Hide modal
        document.removeEventListener('keydown', handleEscKey); // Remove ESC key listener when modal is closed
        document.removeEventListener('click', handleOutsideClick); // Remove outside click listener
    }

    // Function to handle the ESC key press
    function handleEscKey(event) {
        if (event.key === 'Escape') {
            closeModal(); // Close the modal if the ESC key is pressed
        }
    }

    // Function to handle outside click (clicks outside the image)
    function handleOutsideClick(event) {
        const modal = document.getElementById('imageModal');
        const fullImage = document.getElementById('fullImage');
        // If the click is outside the image but inside the modal, close the modal
        if (!fullImage.contains(event.target) && modal.contains(event.target)) {
            closeModal();
        }
    }
</script>

<style>
    /* Styling for the modal */
    #imageModal {
        display: none; /* Hidden by default */
    }
    #imageModal img {
        max-width: 90%; /* Full-size image shouldn't exceed 90% of the screen */
        max-height: 90%;
    }
</style>
