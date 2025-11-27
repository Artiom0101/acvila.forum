<?php session_start();
if ($_POST['pass'] === 'acvila2025') $_SESSION['ok'] = true;
if (!isset($_SESSION['ok'])) {
    echo '<form method="post" style="text-align:center;margin-top:100px;"><input type="password" name="pass" placeholder="Parola admin" required><button type="submit">Intră</button></form>';
    exit;
}
if (isset($_GET['logout'])) { session_destroy(); header('Location: admin.php'); }
if (isset($_GET['sterge'])) { unlink('rezervari.txt'); echo "<p style='color:red;'>Toate rezervările au fost șterse!</p>"; }
?>
<center>
<a href="admin.php?logout=1">Ieșire</a> | 
<a href="admin.php?sterge=1" onclick="return confirm('Sigur ștergi TOATE rezervările?')">Șterge toate rezervările</a>
<hr>
<pre><?php echo file_exists('rezervari.txt') ? htmlspecialchars(file_get_contents('rezervari.txt')) : 'Nicio rezervare'; ?></pre>
</center>
