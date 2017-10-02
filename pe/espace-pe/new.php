<?php

/**
 *
 *
 * @package WordPress
 * @subpackage particulieremploi
 * @since ParticulierEmploi 1.0
 */
session_start();
echo "page statique hors wordpress";

echo "<p> test PDO </p>";
$conn = new PDO('mysql:host=localhost;', 'root', 'admMSKIWI');
var_dump($conn);

if($conn) {
	echo "<br>YEAHHHHHHHHH";
} 
else {
	echo "<br>BAAAAAAADDDDD";
}

//$_SESSION["favcolor"] = "green";
?>
<a href="/index.php"> lien vers hp </a>