<?php
include('sampleClass.php');

$sample = new Woah("Vonn Christian", "Mesina");
//$sample->firstName = "Vonn Christian";
//$sample->lastName = "Mesina";

echo $sample->firstName + " " + $sample->lastName;
?>
