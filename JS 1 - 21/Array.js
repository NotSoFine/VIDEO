let func = function () {
    return "function test";
}

let who = ['me','him','her',10,func(),
    test = ()=>"arrow func here",
    function name() {
        return "to the dirt";
    }
];
console.log(who);
console.log(who[0])

for (let i in who) {
    console.log(who[i]);
    
}
console.log(who[5]());
console.log(who[6]());
