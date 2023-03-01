var slideIndex = 1;
showCases(slideIndex);

function plusCases(n) {
  showCases(slideIndex += n);
}

function currentCase(n) {
  showCases(slideIndex = n);
}

function showCases(n) {
  var i;
  var slides = document.getElementsByClassName("case");
  var dots = document.getElementsByClassName("case-dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "flex";
  dots[slideIndex-1].className += " active";
} 