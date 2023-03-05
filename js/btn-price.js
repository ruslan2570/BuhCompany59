price_btns = document.getElementsByClassName("btn-price");

for (let i = 0; i < price_btns.length; i++) {
    
    price_btns[i].onclick = function () { location.href='/prices.html' };
}
