<?php
// Generează index.html din index.php cu rezervări actuale
$indexContent = file_get_contents('index.php');

// Extrage partea dinamică pentru rezervări
$azi = date('Y-m-d');
$rezervariHtml = '';
if (file_exists('rezervari.txt')) {
    $lines = file('rezervari.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) >= 4 && $parts[0] === $azi) {
            $rezervariHtml .= "<p><strong>" . substr($parts[1], 0, 5) . "</strong> → " . htmlspecialchars($parts[2]) . " (" . htmlspecialchars($parts[3]) . ")</p>";
        }
    }
}
if (empty($rezervariHtml)) $rezervariHtml = "<p>Nu sunt rezervări azi.</p>";

// Înlocuiește placeholder-ul în index.php
$finalContent = str_replace('<!-- REZERVARI_AICI -->', $rezervariHtml, $indexContent);

// Salvează ca index.html
file_put_contents('index.html', $finalContent);

echo "Generat index.html cu rezervări actuale!";
?>
