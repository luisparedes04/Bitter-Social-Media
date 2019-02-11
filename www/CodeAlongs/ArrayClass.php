<?php
        $colours[] = "Red";
        $colours[] = "Blue";
        $colours[] = "Yellow";

        echo $colours[1]."<br>";
      
        // Quicker way
$colours = array(0 => "Red", 1=>"Blue",2=>"Yellow");
$colours = array("Red","Blue","Yellow");

// Associative array

$colours = array("R"=>"Red", "B"=>"Blue","Y"=>"Yellow");

// 2-dimensional arrays
$grades = array("Jimmy"=>array("Math"=>90,"French"=>58),
    "Johnny" => array("Math" => 88, "French" => 60),
    "Suzie" => array("Math" => 75, "French" => 90));

echo $grades["Jimmy"]["French"]."<br>";

// Open the file in read mode
$studentFile = fopen("students.txt", "r");

while($line = fgets($studentFile)){
    list($name, $hometown, $GPA) = explode("|", $line);
    echo $name." ".$hometown." ".$GPA."<br>";
}

// Don't forget to close the file
fclose($studentFile);

// populate with a range of data
$grades = range("A","F");

echo is_array($grades)."<br>";

foreach($grades as $grade){
    echo $grade."<br>";
}
// Print array for testing purposes also prints 2D arrays
print_r($grades);
echo "<br>";

// Adds an element to the beggining of the array

array_unshift($colours,"purple");

// Adds an element to the end of array

array_push($colours, "pink");

//remove the first element
//array_shift($colours);

//  Remove the last element
//array_pop($colours);

print_r($colours);
echo "<br>";
if(in_array("Red",$colours)){
    echo "Found<br>";
}else{
    echo "Not Found<br>";
}

echo sizeof($colours)." elements in my array<br>";
echo count($colours)."count of elements<br>";

sort($colours, SORT_STRING);
natcasesort($colours);
print_r($colours);
echo "<br>";

$colours2 = array(0=>"white", 1=>"black");

$newArray = array_merge($colours,$colours2);

print_r($newArray);
echo "<br>";

print_r(array_reverse($newArray));
echo"<br>";
print_r(array_flip($newArray));
?>

