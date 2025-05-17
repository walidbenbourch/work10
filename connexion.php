<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gestion_stock";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
