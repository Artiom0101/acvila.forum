<?php
$nume = htmlspecialchars(trim($_POST['nume']));
$tel  = htmlspecialchars(trim($_POST['telefon']));
$data = $_POST['data'];
$ora  = $_POST['ora'] . ":00";

$ocupat = false;
if (file_exists('rezervari.txt')) {
    $lines = file('rezervari.txt');
    foreach ($lines as $l) {
        $p = explode('|', $l);
        if (trim($p[0]) === $data && trim($p[1]) === $ora) {
            $ocupat = true; break;
        }
    }
}

if ($ocupat) {
    echo "<h2 style='color:red;text-align:center;margin-top:50px;'>Ora $ora din $data este deja rezervată!</h2>";
    echo "<p style='text-align:center;'><a href='index.php'>← Înapoi</a></p>";
} else {
    $linie = "$data|$ora|$nume|$tel\n";
    file_put_contents('rezervari.txt', $linie, FILE_APPEND | LOCK_EX);
    echo "<h2 style='color:green;text-align:center;margin-top:50px;'>Rezervare confirmată!</h2>";
    echo "<p style='text-align:center;font-size:18px;'>$nume, terenul e al tău pe <strong>$data la $ora</strong></p>";
    echo "<p style='text-align:center;'><a href='index.php'>← Înapoi la rezervări</a></p>";
}
?>
