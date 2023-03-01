window.onscroll = function() {myFunction()};

var header = document.getElementsByClassName("header")[0];

var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky + 100) {
    header.classList.add("sticky");
  } else {
    if(window.pageYOffset < sticky + 1)
    header.classList.remove("sticky");
  }
} 