let modal = document.getElementsByClassName("modal-form")[0];

let btns = document.getElementsByClassName("btn-call");

let span = document.getElementsByClassName("modal-close");

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

  var vacancyBtn = document.getElementsByClassName("vacancy-btn")[0];
  var btnsVacancy = document.getElementsByClassName("btn-vacancy");
  
  if(vacancyBtn != null){
    vacancyBtn.onclick = function() {
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
