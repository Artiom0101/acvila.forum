<?php
session_start();
require 'conexiune.php';

if (!isset($_SESSION['user_id'])) {
    die("Trebuie să fii logat pentru a vedea rezervările.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.*, m.denumire AS masina_denumire, m.poza 
        FROM rezervari r
        JOIN masini m ON r.masina_id = m.masina_id
        WHERE r.user_id = ?
        ORDER BY r.data_ridicare DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$masini_result = $conn->query("SELECT masina_id, denumire FROM masini");
$masini = [];
while ($row = $masini_result->fetch_assoc()) {
    $masini[] = $row;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Rezervările Mele</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f7f7f7;
      padding: 20px;
      margin: 0;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .card {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 20px;
      margin: 20px auto;
      max-width: 600px;
      position: relative;
    }

    .card img {
      width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .info p {
      margin: 6px 0;
      color: #444;
    }

    .buttons {
      margin-top: 10px;
      display: flex;
      justify-content: space-between;
    }

    .buttons form button,
    .buttons button {
      padding: 8px 16px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
    }

    .edit-form {
      margin-top: 15px;
      display: none;
      flex-direction: column;
      gap: 8px;
    }

    .edit-form input,
    .edit-form select {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .edit-form button {
      background-color: #28a745;
      color: white;
    }

    .buttons form.delete-form button {
      background-color: #dc3545;
      color: white;
    }

    .buttons .edit-toggle-btn {
      background-color: #007BFF;
      color: white;
    }

    @media (max-width: 640px) {
      .card {
        padding: 15px;
        margin: 10px;
      }
    }
  </style>
  <script>
    function toggleEditForm(id) {
      const form = document.getElementById('edit-form-' + id);
      form.style.display = form.style.display === 'none' ? 'flex' : 'none';
    }
  </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Car<span>Book</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.html" class="nav-link">Acasa</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">Despre Noi</a></li>
	          <li class="nav-item"><a href="services.html" class="nav-link">Servicii</a></li>
	          <li class="nav-item"><a href="rezervari.php" class="nav-link">Rezervarile Mele</a></li>
	          <li class="nav-item"><a href="car.html" class="nav-link">Masini</a></li>
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Contacte</a></li>
            <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
      <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Rezervarile Mele <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Rezervarile Mele</h1>
          </div>
        </div>
      </div>
    </section>

<?php if ($result->num_rows === 0): ?>
  <p style="text-align:center;">Nu ai nicio rezervare încă.</p>
<?php else: ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card">
      <img src="images/<?= htmlspecialchars($row['poza']) ?>" alt="Poză mașină">
      <h2><?= htmlspecialchars($row['masina_denumire']) ?></h2>
      <div class="info">
        <p><strong>Locație ridicare:</strong> <?= htmlspecialchars($row['locatie_ridicare']) ?></p>
        <p><strong>Locație predare:</strong> <?= htmlspecialchars($row['locatie_predare']) ?></p>
        <p><strong>Data ridicare:</strong> <?= htmlspecialchars($row['data_ridicare']) ?> la ora <?= htmlspecialchars($row['ora_ridicare']) ?></p>
        <p><strong>Data predare:</strong> <?= htmlspecialchars($row['data_predare']) ?></p>
      </div>

      <div class="buttons">
        <button class="edit-toggle-btn" onclick="toggleEditForm(<?= $row['id'] ?>)">Editează</button>
        <form action="delete.php" method="GET" class="delete-form" onsubmit="return confirm('Ești sigur că vrei să ștergi această rezervare?');">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button type="submit">Șterge</button>
        </form>
      </div>

      <form action="edit.php" method="POST" class="edit-form" id="edit-form-<?= $row['id'] ?>">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="locatie_ridicare" value="<?= htmlspecialchars($row['locatie_ridicare']) ?>" required>
        <input type="text" name="locatie_predare" value="<?= htmlspecialchars($row['locatie_predare']) ?>" required>
        <input type="date" name="data_ridicare" value="<?= $row['data_ridicare'] ?>" required>
        <input type="date" name="data_predare" value="<?= $row['data_predare'] ?>" required>
        <input type="time" name="ora_ridicare" value="<?= $row['ora_ridicare'] ?>" required>
        
        <select name="masina_id" required>
          <?php foreach ($masini as $masina): ?>
            <option value="<?= $masina['masina_id'] ?>" <?= $masina['masina_id'] == $row['masina_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($masina['denumire']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Salvează modificările</button>
      </form>
    </div>
  <?php endwhile; ?>
<?php endif; ?>
<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"><a href="#" class="logo">Car<span>book</span></a></h2>
              <p>Departe, departe, în spatele cuvântului munți, departe de țările Vokalia și Consonantia, trăiesc textele oarbe.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Informatii</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Despre noi</a></li>
                <li><a href="#" class="py-2 d-block">Servicii</a></li>
                <li><a href="#" class="py-2 d-block">Termeni si Conditii</a></li>
                <li><a href="#" class="py-2 d-block">Cel Mai Bun Pret Garantat</a></li>
                <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Suport Clienti</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">FAQ</a></li>
                <li><a href="#" class="py-2 d-block">Optiuni de Achiatare</a></li>
                <li><a href="#" class="py-2 d-block">Booking</a></li>
                <li><a href="#" class="py-2 d-block">Cum Functioneaza</a></li>
                <li><a href="#" class="py-2 d-block">Contacteazane</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Ai o intrebare?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Republica Moldova, Chisinau, Stefan Cel Mare 1</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+373 067 404 44</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">carbook@rental.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p>
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with by <a href="https://artclean.com" target="_blank">Buliga Artiom</a>
</p>
          </div>
        </div>
      </div>
    </footer>
    
<script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
