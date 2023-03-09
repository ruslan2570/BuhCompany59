
var modal = document.getElementsByClassName("modal-form")[0];

var btns = document.getElementsByClassName("btn-call");

var span = document.getElementsByClassName("modal-close");

for(let i = 0; i < btns.length; i++){
  btns[i].onclick = function() {
    modal.style.display = "block";
  }
}

for(let i = 0; i < span.length; i++){
  span[i].onclick = function() {
    modal.style.display = "none";
    modalVacancy.style.display = "none";
  }
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 


var modalVacancy = document.getElementsByClassName("modal-vacancy")[0];
if(modalVacancy != null){

  var vacancyBtns = document.getElementsByClassName("vacancy-btn");
  
  
  for(let i = 0; i < vacancyBtns.length; i++){
    vacancyBtns[i].onclick = function() {
      modalVacancy.style.display = "block";
    }
  }

  window.onclick = function(event) {
    if (event.target == modal || event.target == modalVacancy) {
      modal.style.display = "none";
      modalVacancy.style.display = "none";
    }
  } 

}
