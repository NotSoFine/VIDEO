let object = {
    who: "himshon",
    num: 38747832,
    tbl: ['row1','row2','row3'],
    try:function () {
        return "object functions";
    },
    bool:true,
    "string here":12345678,
}
console.log(object.who);
console.log(object.num);
console.log(object.bool);
console.log(object.try())
console.log(object.tbl[0]);
console.log(object["string here"]);