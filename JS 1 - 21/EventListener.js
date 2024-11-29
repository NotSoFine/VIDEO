//1st way
function t() {
    a = document.querySelector(".isi");
    a.innerHTML = "i snuck in..";
    console.log("heard");
}
// title.addEventListener("click",t);
// title.onmouseover = t;
//2nd way
title.onmouseover = function(){
    console.log("titlefunc");
}