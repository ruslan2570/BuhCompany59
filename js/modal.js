
var modal = document.getElementsByClassName("modal-form")[0];

var btns = document.getElementsByClassName("btn-call");

var span = document.getElementsByClassName("modal-close")[0];

for(let i = 0; i < btns.length; i++){
  btns[i].onclick = function() {
    modal.style.display = "block";
  }
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 