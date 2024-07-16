<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <style>
        #image-modal {
    display: none;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.75);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

#image-modal img {
    max-width: 90%;
    max-height: 90%;
}

#image-modal .close {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 40px;
    font-weight: bold;
    color: white;
    cursor: pointer;
}

    </style>
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased text-white min-h-screen">
    @include('layouts-visitor.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    @yield('visitor')
    @livewireScripts
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const seeMoreButtonOverview = document.getElementById('see-more-button');
        const seeLessButtonOverview = document.getElementById('see-less-button');
        const hiddenItemsOverview = document.querySelectorAll('#overview-section .hidden');

        seeMoreButtonOverview.addEventListener('click', () => {
            hiddenItemsOverview.forEach(item => {
                item.classList.remove('hidden');
            });
            seeMoreButtonOverview.classList.add('hidden');
            seeLessButtonOverview.classList.remove('hidden');
        });

        seeLessButtonOverview.addEventListener('click', () => {
            hiddenItemsOverview.forEach(item => {
                item.classList.add('hidden');
            });
            seeMoreButtonOverview.classList.remove('hidden');
            seeLessButtonOverview.classList.add('hidden');
        });

        const seeMoreButtonEstablishments = document.getElementById('see-more-button-establishments');
        const seeLessButtonEstablishments = document.getElementById('see-less-button-establishments');
        const hiddenItemsEstablishments = document.querySelectorAll('#near-establishments .hidden');

        seeMoreButtonEstablishments.addEventListener('click', () => {
            hiddenItemsEstablishments.forEach(item => {
                item.classList.remove('hidden');
            });
            seeMoreButtonEstablishments.classList.add('hidden');
            seeLessButtonEstablishments.classList.remove('hidden');
        });

        seeLessButtonEstablishments.addEventListener('click', () => {
            hiddenItemsEstablishments.forEach(item => {
                item.classList.add('hidden');
            });
            seeMoreButtonEstablishments.classList.remove('hidden');
            seeLessButtonEstablishments.classList.add('hidden');
        });
    });

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
</body>
</html>
