// function to hide adding form for categories and show when click

function hideFunction() {
    var x = document.getElementById("hide-div");
    if (x.style.display == "none" || x.style.display == "") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

  window.openModal = function(modalId) {
    document.getElementById(modalId).style.display = 'block'
    document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
}

window.closeModal = function(modalId) {
    document.getElementById(modalId).style.display = 'none'
    document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
}

// Close all modals when press ESC
document.onkeydown = function(event) {
    event = event || window.event;
    if (event.keyCode === 27) {
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
        let modals = document.getElementsByClassName('modal');
        Array.prototype.slice.call(modals).forEach(i => {
            i.style.display = 'none'
        })
    }
};