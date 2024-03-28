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