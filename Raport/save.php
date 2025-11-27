<?php
session_start();
require 'conexiune.php';

if (!isset($_SESSION['user_id'])) {
    die("Trebuie să fii logat pentru a face o rezervare.");
}

$user_id = $_SESSION['user_id'];
$locatie_ridicare = $_POST['locatie_ridicare'] ?? '';
$locatie_predare = $_POST['locatie_predare'] ?? '';
$data_ridicare = $_POST['data_ridicare'] ?? '';
$data_predare = $_POST['data_predare'] ?? '';
$ora_ridicare = $_POST['ora_ridicare'] ?? '';
$masina_id = $_POST['masina_id'] ?? null;

if (!$locatie_ridicare || !$locatie_predare || !$data_ridicare || !$data_predare || !$ora_ridicare || !$masina_id) {
    die("Toate câmpurile sunt obligatorii.");
}

$sql_check = "SELECT masina_id FROM masini WHERE masina_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $masina_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    die("Mașina selectată nu există.");
}

$sql = "INSERT INTO rezervari (user_id, locatie_ridicare, locatie_predare, data_ridicare, data_predare, ora_ridicare, masina_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssi", $user_id, $locatie_ridicare, $locatie_predare, $data_ridicare, $data_predare, $ora_ridicare, $masina_id);

if ($stmt->execute()) {
    header("Location: rezervari.php");
    exit;
} else {
    echo "Eroare la salvarea rezervării: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
