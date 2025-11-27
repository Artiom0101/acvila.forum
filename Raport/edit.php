<?php
require 'conexiune.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $locatie_ridicare = $_POST['locatie_ridicare'];
    $locatie_predare = $_POST['locatie_predare'];
    $data_ridicare = $_POST['data_ridicare'];
    $data_predare = $_POST['data_predare'];
    $ora_ridicare = $_POST['ora_ridicare'];
    $masina_id = $_POST['masina_id'];

    $stmt = $conn->prepare("UPDATE rezervari SET locatie_ridicare=?, locatie_predare=?, data_ridicare=?, data_predare=?, ora_ridicare=?, masina_id=? WHERE id=?");
    $stmt->bind_param("ssssssi", $locatie_ridicare, $locatie_predare, $data_ridicare, $data_predare, $ora_ridicare, $masina_id, $id);

    if ($stmt->execute()) {
        header("Location: rezervari.php");
        exit;
    } else {
        echo "Eroare la actualizare: " . $stmt->error;
    }
}
?>
    