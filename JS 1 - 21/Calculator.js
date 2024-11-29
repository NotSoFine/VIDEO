let btn = document.querySelectorAll(".num-btn > button");
let show = document.querySelector("#show");
let math = document.querySelectorAll(".btn-math > button");
let selection = null;
let x;
let y;

// console.log(math);
// show.value = btn[0].innerHTML;
// console.log(btn[6].innerHTML);
for (let index = 0; index < btn.length; index++) {
    btn[index].onclick = function () {
        // console.log(btn[index].innerHTML);
        if (show.value == 0) {
            show.value = btn[index].innerHTML;
        }
        else{
            show.value += btn[index].innerHTML; 
        }
    };
    
}

math[0].onclick = function () {
    show.value = "0";
    selection = null;
};

math[1].onclick = function () {
    selection = "add";
    x = show.value;
    show.value = "0";
};

math[2].onclick = function () {
    selection = "subtract";
    x = show.value;
    show.value = "0";

};

math[3].onclick = function () {
    selection = "multiply";
    x = show.value;
    show.value = "0";
};

math[4].onclick = function () {
    selection = "divide";
    x = show.value;
    show.value = "0";
};

math[5].onclick = function () {
    selection = "equals";
    y = show.value = "0";
    show.value = calculate(selection);
};

function calculate(selection) {
    if (calculate != null) {
        switch (selection) {
            case "add":
            result = parseFloat(x) + parseFloat(y);   
                break;
            case "substract":
            result = parseFloat(x) - parseFloat(y);                   
                break;
            case "mutiply":
            result = parseFloat(x) * parseFloat(y);   
                break;
            case "divide":
            result = parseFloat(x) / parseFloat(y);   
                break;
        }

        return result;
    }
}