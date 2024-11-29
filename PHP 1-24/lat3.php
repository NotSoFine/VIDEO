<?php
    function test(){
        echo 'test';
    }

    function math($one = 1,$two = 2,$three = 3){
        $op = $one * $two + $three;

        echo $op;
    }
    
    function mathhere($one=1,$two=2){
        $op = $one * $two;
        return $op;
    }
    echo mathhere(100,3)*5;

    function output(){
        return 'HEYOOOOO';
    }
    echo '<h1>' .output(). '</h1>';

    
?>