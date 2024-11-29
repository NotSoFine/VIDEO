function test() {
    let test = "var in function";
    console.log(test);
    console.log("print inside function")
}

function square(width,length) {
    big = width * length;
    console.log(big);
}

function out() {
    return console.log("output function");
}
function circle(r){
    big = 3.14 * r * r;
    return big;
}

const height = 5;
let cylinder = circle(10) * height;

function skip(a) {
    return a;
}
// console.log(cylinder);
console.log(skip(6));