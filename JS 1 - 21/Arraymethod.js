// array -> string,numeral,object,function,mixed
let value = [
    {who:"jhen",IPA:90,lang:70,Math:70},
    {who:"john",IPA:80,lang:80,Math:60},
    {who:"gorg",IPA:75,lang:70,Math:90},
    {who:"greg",IPA:90,lang:80,Math:90},
]
let who = ["jhen","john","gorg","greg"]
// who.push("huny","joe")
// console.log(who.shift());
// who.unshift("zou","kune")
// console.log(who.slice(0,3))
let daily = ["meth","lang","math"];
// console.log(who.concat(daily));
// console.log(who.concat(["jonkler","wss","nero"]));
// console.log(who.splice(5,2));
// console.log(who.pop());
// console.log(value[0].name);
// console.log(who);
// for (let index = 0; index < who.length; index++) {
//     console.log(who[index])
// }
// who.forEach(function (a) {
//     console.log(a);
// });
// who.forEach(a => console.log(a));

// value.filter(function (a) {
//     if (a.IPA > 80) {
//         console.log(a.who);
//     }
// })

// console.log(value);

// value.filter(a => a.IPA > 80 && a.Math > 80 ? console.log(a.who):null);
// let student = value.map(function (a) {
//     return a.who;
// })

// let student = value.map(a => [a.who,a.IPA,a.lang]);
// console.log(student);

// daily.sort();
// console.log(daily);

// let result = value.reduce(function (a, b) {
//     return (a = a + b.IPA);
// }, 0);
let result = value.reduce((a,b) => (a+=b.lang),0)
console.log(result);