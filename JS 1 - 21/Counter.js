let a = 0;
UP.onclick = function () {
    a++;
    document.querySelector("h1").innerHTML = a;
};
DOWN.onclick = function () {
    if (a > 0) {
        a--
        document.querySelector("h1").innerHTML = a;
    }
};