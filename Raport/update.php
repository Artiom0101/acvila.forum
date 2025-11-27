<?php
require 'conexiune.php';

$id = $_POST['id'];
$locatie_ridicare = $_POST['locatie_ridicare'];
$locatie_predare = $_POST['locatie_predare'];
$data_ridicare = $_POST['data_ridicare'];
$data_predare = $_POST['data_predare'];
$ora_ridicare = $_POST['ora_ridicare'];
$masina_id = $_POST['masina_id'];

$sql = "UPDATE rezervari SET locatie_ridicare=?, locatie_predare=?, data_ridicare=?, data_predare=?, ora_ridicare=?, masina_id=? WHERE rezervare_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $locatie_ridicare, $locatie_predare, $data_ridicare, $data_predare, $ora_ridicare, $masina_id, $id);
$stmt->execute();

header("Location: rezervari.php");
exit;
