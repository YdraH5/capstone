
// Get modal element
const modal = document.getElementById('modal');
// Get open modal button
const openModalButton = document.getElementById('openModalButton');
// Get close modal button
const closeModalButton = document.getElementById('closeModalButton');
// Get modal form
const modalForm = document.getElementById('modalForm');

// Function to open modal
function openModal() {
  modal.classList.remove('hidden');
}

// Function to close modal
function closeModal() {
  modal.classList.add('hidden');
}

    document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.getElementById('default-carousel');
    const carouselItems = carousel.querySelectorAll('[data-carousel-item]');
    let currentIndex = 0;

    function showSlide(index) {
        carouselItems.forEach(function(item, i) {
            item.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % carouselItems.length;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
        showSlide(currentIndex);
    }

    // Attach event listeners to next and previous buttons
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');

    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);

    // Show the initial slide
    showSlide(currentIndex);
});
