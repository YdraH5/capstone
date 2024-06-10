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
            /* Add your styles here */
            .carousel {
                position: relative;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            .carousel-slide {
                display: none;
                background-size: cover; /* Added */
                background-position: center;
                width: 100%;
                height: 500px;
                position: relative;
            }
            .carousel-slide.active {
                display: block;
            }
            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
            }
            .content {
                position: absolute;
                bottom: 50px;
                left: 50px;
                color: white;
            }
            .prev, .next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
            }
            .prev {
                left: 10px;
            }
            .next {
                right: 10px;
            }
            .carousel-slide {
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat
}
        </style>
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
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
                let currentSlide = 0;
        
                function showSlide(index) {
                    const slides = document.querySelectorAll('.carousel-slide');
                    if (index >= slides.length) {
                        currentSlide = 0;
                    } else if (index < 0) {
                        currentSlide = slides.length - 1;
                    } else {
                        currentSlide = index;
                    }
        
                    slides.forEach((slide, i) => {
                        slide.classList.toggle('active', i === currentSlide);
                    });
                }
        
                function changeSlide(direction) {
                    showSlide(currentSlide + direction);
                }
        
                // Optional: Automatically change slide every 5 seconds
                // setInterval(() => changeSlide(1), 5000);
            </script>
        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    </body>
</html>