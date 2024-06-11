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
            .carousel-slide {
                position: absolute;
                inset: 0;
                background-size: cover;
                background-position: center;
                transition: opacity 1s ease-in-out;
            }
            .carousel-slide.hidden {
                opacity: 0;
            }
            .carousel-slide.active {
                opacity: 1;
            }
        </style>
        </style>
        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white min-h-screen">
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
                    const slides = document.querySelectorAll('#hero-carousel .carousel-slide');
                    const prevButton = document.getElementById('prev-slide');
                    const nextButton = document.getElementById('next-slide');
                    let currentSlide = 0;
            
                    const showSlide = (index) => {
                        slides.forEach((slide, i) => {
                            slide.classList.toggle('hidden', i !== index);
                            slide.classList.toggle('active', i === index);
                        });
                    };
            
                    const nextSlide = () => {
                        currentSlide = (currentSlide + 1) % slides.length;
                        showSlide(currentSlide);
                    };
            
                    const prevSlide = () => {
                        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                        showSlide(currentSlide);
                    };
            
                    nextButton.addEventListener('click', nextSlide);
                    prevButton.addEventListener('click', prevSlide);
            
                    // Optionally, you can add auto-slide functionality
                    setInterval(nextSlide, 10000); // Auto-slide every 5 seconds
                });
            </script>
            
        <script src="https://unpkg.com/flowbite@1.4.0/dist/flowbite.js"></script>
    </body>
</html>