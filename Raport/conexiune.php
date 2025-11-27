<?php
$conn = new mysqli("localhost", "root", "", "carbook");
if ($conn->connect_error) {
    die("Eroare conexiune: " . $conn->connect_error);
}
?>
