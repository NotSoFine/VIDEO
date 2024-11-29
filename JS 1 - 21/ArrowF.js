let func = function(who){
    console.log("hi im function," + who);
}
func("squewe");

let ex = (who)=>{
    console.log("you are.." + who);
}
ex("sqwueweeee");

let add = function(a,b){
    return a + b;
}
console.log(add(2,3));

let plus =(a,b) => a + b;
console.log(plus(2,3));

let result =  a => a * 2;
console.log(result(4));

let replay = ()=>console.log("hi again");
replay()

let triple =()=>{
    console.log("ahoy");
    console.log("there");
    console.log("my man");
    console.log(",next...")
}
triple()

let value = 8;
let proceed = (value < 7) ? ()=>verdict="no entry!":()=>verdict=("accepted.");
console.log(proceed());