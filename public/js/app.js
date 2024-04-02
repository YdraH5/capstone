// function to hide adding form for categories and show when click

function hideFunction() {
    var x = document.getElementById("hide-div");
    if (x.style.display == "none" || x.style.display == "") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  function hideTable() {
    var y = document.getElementById("hide-table");
    if (y.style.display == "none" || y.style.display == "") {
      y.style.display = "block";
    } else {
      y.style.display = "none";
    }
  }
      const sidebar = document.querySelector("aside");
      const maxSidebar = document.querySelector(".max")
      const miniSidebar = document.querySelector(".mini")
      const roundout = document.querySelector(".roundout")
      const maxToolbar = document.querySelector(".max-toolbar")
      const logo = document.querySelector('.logo')
      const content = document.querySelector('.content')
      const moon = document.querySelector(".moon")
      const sun = document.querySelector(".sun")

      function setDark(val){
          if(val === "dark"){
              document.documentElement.classList.add('dark')
              moon.classList.add("hidden")
              sun.classList.remove("hidden")
          }else{
              document.documentElement.classList.remove('dark')
              sun.classList.add("hidden")
              moon.classList.remove("hidden")
          }
      }

      function openNav() {
          if(sidebar.classList.contains('-translate-x-48')){
              // max sidebar 
              sidebar.classList.remove("-translate-x-48")
              sidebar.classList.add("translate-x-none")
              maxSidebar.classList.remove("hidden")
              maxSidebar.classList.add("flex")
              miniSidebar.classList.remove("flex")
              miniSidebar.classList.add("hidden")
              maxToolbar.classList.add("translate-x-0")
              maxToolbar.classList.remove("translate-x-24","scale-x-0")
              logo.classList.remove("ml-12")
              content.classList.remove("ml-12")
              content.classList.add("ml-12","md:ml-60")
          }else{
              // mini sidebar
              sidebar.classList.add("-translate-x-48")
              sidebar.classList.remove("translate-x-none")
              maxSidebar.classList.add("hidden")
              maxSidebar.classList.remove("flex")
              miniSidebar.classList.add("flex")
              miniSidebar.classList.remove("hidden")
              maxToolbar.classList.add("translate-x-24","scale-x-0")
              maxToolbar.classList.remove("translate-x-0")
              logo.classList.add('ml-12')
              content.classList.remove("ml-12","md:ml-60")
              content.classList.add("ml-12")

          }

      }
      document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('crud-modal');
        const modalToggle = document.querySelector('[data-modal-toggle="crud-modal"]');
        const closeModalButtons = modal.querySelectorAll('[data-modal-toggle="crud-modal"]');

        modalToggle.addEventListener('click', function() {
            modal.classList.toggle('hidden');
        });

        closeModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('crud-modal-apartment');
        const modalToggle = document.querySelector('[data-modal-toggle="crud-modal-apartment"]');
        const closeModalButtons = modal.querySelectorAll('[data-modal-toggle="crud-modal-apartment"]');

        modalToggle.addEventListener('click', function() {
            modal.classList.toggle('hidden');
        });

        closeModalButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
      const modalToggleButtons = document.querySelectorAll('[data-modal-toggle]');

      modalToggleButtons.forEach(function(button) {
          button.addEventListener('click', function() {
              const targetModalId = this.getAttribute('data-modal-target');
              const targetModal = document.getElementById(targetModalId);
              targetModal.classList.toggle('hidden');
          });
      });
  });
  document.getElementById('showFormButton').addEventListener('click', function() {
      document.getElementById('uploadForm').classList.toggle('hidden');
    });
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    });
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

// function expandImage(img, overlayId, expandedImageId) {
//   var overlay = document.getElementById(overlayId);
//   var expandedImgContainer = document.getElementById(expandedImageId);
//   var fullImg = img.cloneNode(true);
//   expandedImgContainer.innerHTML = ''; // Clear any previous content
//   expandedImgContainer.appendChild(fullImg);
//   overlay.style.display = "block";
//   expandedImgContainer.style.display = "block";
// }

// function closeImage(overlayId, expandedImageId) {
//   var overlay = document.getElementById(overlayId);
//   var expandedImgContainer = document.getElementById(expandedImageId);
//   overlay.style.display = "none";
//   expandedImgContainer.style.display = "none";
// }
