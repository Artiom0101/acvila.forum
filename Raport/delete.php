<?php
require 'conexiune.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM rezervari WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: rezervari.php");
        exit;
    } else {
        echo "Eroare la ștergere: " . $stmt->error;
    }
} else {
    echo "ID lipsă.";
}
?>
