@section('title', 'Full Details')

@include('layouts-visitor.app')

@foreach ($apartment as $detail)
<div class="flex flex-col lg:flex-row items-center justify-center bg-yellow-100  shadow-lg rounded-lg min-h-screen ">
    <div class="w-full lg:w-1/2 h-screen p-4  bg-orange-200">
        <div class="h-screen overflow-y-auto">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-y-52 ">
                @if (isset($images[$detail->id]) && $images[$detail->id]->isNotEmpty())
                    @foreach ($images[$detail->id] as $image)
                        <div class="relative group">
                            <img src="{{ asset($image->image) }}" class="block absolute px-1 w-full h-48 clickable-image rounded-lg" alt="">
                            <div class="mx-2 absolute bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center rounded-lg">
                                <span class="text-white text-sm">{{ $image->description ?? 'No Description Available' }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 text-center lg:text-left p-8 flex flex-col justify-center">
        <h1 class="text-3xl font-bold text-gray-800">{{ $detail->categ_name }}</h1>
        <p class="mt-4 text-gray-600">{{ $detail->description }}</p>
        <p class="mt-4 text-gray-600 font-semibold">Monthly Rent: ₱{{ $detail->price }}.00</p>
        <p class="mt-4 text-gray-600 font-semibold">Available Rooms: {{ $available }}</p>
        <div class="mt-6">
            @if ($available > 0)
                <a href="{{ route('reserve.index', ['apartment' => $detail->id]) }}">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Reserve
                    </button>
                </a>
            @else
                <button class="bg-gray-300 text-gray-600 px-6 py-3 rounded-full cursor-not-allowed opacity-50" disabled>
                    No Rooms Available
                </button>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        x-data x-on:click="$dispatch('open-modal', { name: 'notify-me' })">
                    Notify Me
                </button>
                <x-modal name="notify-me" title="Notify Me!">
                    <x-slot name="body">
                        <div class="p-4">
                            <p class="text-lg text-gray-600 font-semibold mb-4">
                                By opting in for notifications, you agree to receive emails regarding the availability of rooms in this apartment. We respect your privacy and will not share your email address with third parties.
                            </p>
                            <p class="text-gray-600 mb-8">
                                You can unsubscribe from these notifications at any time by following the link provided in the email. For more details on how we handle your personal information, please refer to our privacy policy.
                            </p>
                            <div class="flex justify-end">
                                <button type="button" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-4" x-on:click="$dispatch('close-modal', { name: 'notify-me' })">Cancel</button>
                                <a href="{{ route('emails.notify') }}" class="bg-blue-500 hover:bg-blue-600 text-white ml-4 px-6 py-3 rounded-full transition duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                    Accept
                                </a>
                            </div>
                        </div>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </div>
</div>
@endforeach

<!-- Full-screen Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <img id="modal-image" class="max-w-full max-h-full">
    <span id="close-modal" class="absolute top-2 right-4 text-white text-2xl cursor-pointer">&times;</span>
</div>
<script>
      document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("image-modal");
        const modalImg = document.getElementById("modal-image");
        const closeModal = document.getElementById("close-modal");

        document.querySelectorAll(".clickable-image").forEach(img => {
            img.addEventListener("click", function () {
                modal.style.display = "flex";
                modalImg.src = this.src;
            });
        });

        closeModal.addEventListener("click", function () {
            modal.style.display = "none";
        });

        modal.addEventListener("click", function (event) {
            if (event.target !== modalImg) {
                modal.style.display = "none";
            }
        });
    });
</script>
<script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
