<?php
function PrintMessage(){
    echo "Hello World"."<BR>";
}
function PrintMessage2($msg){
    echo $msg."<BR>";
}
/*function Calc($price, $tax = 0.15){ // tax is defaulted to 0.15
    return $price* (1+$tax);
}*/
function Calc(&$price, $tax = 0.15){ // tax is defaulted to 0.15 || & means by ref or pointer to
    return $price = $price*(1+$tax);
}
// Type hinting
function DoStuff(Vehicle $myCar){
    //logic inside
}
function Factorial($n){
    if($n==1){
        return 1;
    }
    return $n*Factorial($n-1);    
}
$mynum= rand(1,6);
echo $mynum."<BR>";
echo getrandmax()."<BR>";

// Just Call It
PrintMessage();
PrintMessage2("Hello Luis");

//echo Calc(19.99,0.13)."<BR>";
//echo Calc(29.99);

$price = 29.99;
Calc($price);
echo $price."<br>";

echo Factorial(10)."<BR>"; 
?>

