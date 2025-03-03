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
        /* Fade-In Animation */
.fade-in {
    opacity: 0;
    transition: opacity 1s ease-out;
}

.fade-in-visible {
    opacity: 1;
}

/* Slide-In Animation */
.slide-in {
    transform: translateX(100%);
    opacity: 0;
    transition: transform 1s ease-out, opacity 1s ease-out;
}

.slide-in-visible {
    transform: translateX(0);
    opacity: 1;
}

    /* For Chrome, Edge, and Safari */
::-webkit-scrollbar {
    width: 4px; /* Width of the scrollbar */
}

/* Track (background of the scrollbar) */
::-webkit-scrollbar-track {
    background: #1a73e8; /* Light gray background */
    border-radius: 5px;
}

/* Handle (scrollbar itself) */
::-webkit-scrollbar-thumb {
    background-color: #1a73e8; /* Green handle */
    border-radius: 10px; /* Rounded scrollbar */
    border: 1px solid #e0e0e0; /* Padding to create space between handle and track */
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background-color: #1a73e8; /* Darker green on hover */
}

/* For Firefox */
* {
    scrollbar-width: thin; /* Make scrollbar thin */
    scrollbar-color: gray #e0e0e0; /* Green handle with light gray background */
}

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
#carousel {
    position: relative;
}

#carousel-image {
    width: 100%;
    height: 100vh;
    object-fit: cover;
}

#prev-button, #next-button {
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 1rem;
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    transition: background-color 0.3s ease;
}

#prev-button:hover, #next-button:hover {
    background-color: rgba(0, 0, 0, 0.8);
}
#carousel-image {
    transition: opacity 0.3s ease-in-out;
    opacity: 1;
}

.fade-out {
    opacity: 0;
}

.fade-in {
    opacity: 1;
}
 /* Example styles for active link */
 .nav-link.active h6 {
        color: black; /* Active link color */
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
   document.addEventListener('DOMContentLoaded', function () {
    const seeMoreButton = document.getElementById('see-more-button-establishments');
    const seeLessButton = document.getElementById('see-less-button-establishments');
    const hiddenEstablishments = document.querySelectorAll('.hidden-establishments');

    seeMoreButton.addEventListener('click', function () {
        hiddenEstablishments.forEach(function (establishment) {
            establishment.classList.remove('hidden');
        });
        seeMoreButton.classList.add('hidden');
        seeLessButton.classList.remove('hidden');
    });

    seeLessButton.addEventListener('click', function () {
        hiddenEstablishments.forEach(function (establishment) {
            establishment.classList.add('hidden');
        });
        seeMoreButton.classList.remove('hidden');
        seeLessButton.classList.add('hidden');
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
   // Target all elements with the class 'animate-on-scroll'
const elements = document.querySelectorAll('.animate-on-scroll');

// Create an intersection observer
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Add visible class when the element is in view
            entry.target.classList.add('fade-in-visible'); // or 'slide-in-visible'
            observer.unobserve(entry.target); // Stop observing after the element is in view
        }
    });
}, {
    threshold: 0.1, // Trigger when 10% of the element is in view
});

// Observe all elements with the 'animate-on-scroll' class
elements.forEach(element => {
    observer.observe(element);
});



    </script>
    <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
</body>
</html>
