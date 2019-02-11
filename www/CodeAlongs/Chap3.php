<html>
    <body>
        <h1>HELLO WORLD</h1>
            
<?php
    //comments\
/*multiline comments
 * 
 */
    //declare some variables
    $name = "Jimmy";//string
    $value = 53;
    echo "value of name is " . $name . "  " . $value . "<BR>";
    //dynamic!!!
    echo "Hello $name<BR>";
    print "hello world<BR>"; //the same as echo
    
    $numCans = 6;
    $price = 15.99;
    //2 decimal places for currency
    printf("%d cans of beer cost $%.2f<BR>", $numCans, $price);
    $value1 = (int) false;
    echo $value1 . "<BR>";
    //scalar data types hold  a single value: int, double, bool, string
    $student[0] = "Sarah";
    $student[1] = "John";
    $student[2] = "Suzie";
    //part #2
    //type juggling
    $myVar = "5";
    $myVar2 = "20";
    $myVar += $myVar2;
    echo $myVar . "<BR>";
    echo gettype($myVar) . "<BR>";
    
    //& means "pointer to" kinda like byref in VB
    $myVar2 =& $myVar;
    $myVar = 99;
    
    echo "myvar2 is " . $myVar2 ."<BR>";
    //constants
    define("PI", 3.1415926);
    echo "value of PI is " . PI . "<BR>";
    echo "value of myvar is ". ++$myVar. "<BR>";
    echo "value of myvar is now " . $myVar . "<BR>";
    //if statements
    $var1 = 5;
    $var2 = "5";
    if ($var1 === $var2) {
        echo "EQUAL<BR>";
    }
    else {
        echo "NOT EQUAL<BR>";
    }
    //escape the "
    $myString = 'Nick\'s favourite color is red';
   
    $myString = "the shirt cost $19.99";
    echo $myString ."<BR>";
    //while loop
    $i = 0;
    while ($i < 10) {
        echo "value of i is " . $i++. "<BR>";
       
    }
    
    //do-while
    $i =100;
    do {
        echo "i is $i<BR>";
        $i--;
    } while ($i > 0);
    
    for ($i = 0; $i<10;$i++) {
        $j = 66;
        if ($i == 5) continue;
        echo "i is $i<BR>";
    }
    //foreach loops we'll do them later when we do arrays
    
?>
</body>
    </html>