<?php
class AnimalClass {
    //put your code here
    const numLegs = 4;
    private $weight;
    private $species;
    private $colour;
    
    //cannot be instantiated/can not have a body
    //static function SomeMethod();
    
    function getWeight() {
        return $this->weight;
    }

    function getSpecies() {
        return $this->species;
    }

    function getColour() {
        return $this->colour;
    }

    function setWeight($weight) {
        $this->weight = $weight;
    }

    function setSpecies($species) {
        $this->species = $species;
    }

    function setColour($colour) {
        $this->colour = $colour;
    }

    function __construct($weight, $species, $colour) {
        $this->weight = $weight;
        $this->species = $species;
        $this->colour = $colour;
    }
    
    function __destruct() {
        //this is called when the object gets destroyed/removed from memory
        echo "<br>object destroyed<br>";
    }
    
    function __get($name) {
        return $this->$name;
    }
    function __set($name, $value) {
        $this->$name = $value;
    }
    static function MakeNoise(){
        echo "arp arp";
    }
} // End of animal class

$myAnimal = new AnimalClass(150, "Zebra", "Black, White");
echo $myAnimal->getColour() . "<br>";
$myAnimal->weight = 500;
echo $myAnimal->weight . "<br>";
$myAnimal->MakeNoise();
//call is staticly 
AnimalClass::MakeNoise();
PrintAnimal($myAnimal);

//type hinting
function PrintAnimal(AnimalClass $animal){
    echo "<br>" . $animal->getColour() . "<br>";
}