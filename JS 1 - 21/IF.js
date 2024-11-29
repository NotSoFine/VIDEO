//true-false
if (true) {
    console.log("will only appear when true");
}
else{
    console.log("hey its false")
}
//num check with logic OP
let grade = 60;
let minimum = 60;
let pass = "YOU PASSED!"
let fail = "GO BACK TO SLEEP"
let highmax = 100;
let lowmax = 0;
let lb = "hey man what is this limit break";

if (grade <= highmax && grade >= lowmax) {
    if (grade >= minimum) {
        console.log(pass);
    }
    else{
        console.log(fail);
    }
}
else{
    console.log(lb);
}