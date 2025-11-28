<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Tenis Acvila - Rezervări Teren</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f9f4;color:#333;padding:20px;}
        .container{max-width:500px;margin:0 auto;background:white;padding:30px;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.1);text-align:center;}
        h1{color:#006400;margin-bottom:10px;}
        input,select,button{width:100%;padding:12px;margin:8px 0;border:1px solid #ccc;border-radius:8px;font-size:16px;}
        button{background:#006400;color:white;border:none;cursor:pointer;transition:0.3s;}
        button:hover{background:#005000;}
        .rezervari{margin-top:30px;background:#e8f5e8;padding:15px;border-radius:10px;}
        .rezervari p{background:white;padding:10px;margin:8px 0;border-left:5px solid #006400;border-radius:5px;}
        a{color:#006400;font-weight:bold;}
        form{display:none;} /* Ascunde formularul în versiunea statică */
    </style>
</head>
<body>
<div class="container">
    <h1>Club Tenis Acvila</h1>
    <p>Rezervă terenul online • Chișinău</p>

    <!-- Formular dinamic doar pe local/XAMPP -->
    <form action="rezervare.php" method="post">
        <input type="text" name="nume" placeholder="Nume și prenume" required>
        <input type="text" name="telefon" placeholder="Telefon (ex: 079123456)" required>
        <input type="date" name="data" min="<?php echo date('Y-m-d'); ?>" required>
        <select name="ora" required>
            <option value="">Alege ora</option>
            <?php for($i=8;$i<=22;$i++): ?>
                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo $i; ?>:00</option>
            <?php endfor; ?>
        </select>
        <button type="submit">Rezervă acum</button>
    </form>

    <div class="rezervari">
        <h3>Rezervări de azi (<?php echo date('d.m.Y'); ?>)</h3>
        <!-- REZERVARI_AICI -->
    </div>

    <p><small><a href="admin.html">Admin</a></small></p> <!-- Link static -->
</div>
</body>
</html>
