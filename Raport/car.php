<?php
session_start();
require 'conexiune.php';

$locatie_ridicare = $_GET['locatie_ridicare'] ?? '';
$locatie_predare = $_GET['locatie_predare'] ?? '';
$data_ridicare = $_GET['data_ridicare'] ?? '';
$data_predare = $_GET['data_predare'] ?? '';
$ora_ridicare = $_GET['ora_ridicare'] ?? '';

if (
  !$locatie_ridicare || !$locatie_predare ||
  !$data_ridicare || !$data_predare || !$ora_ridicare
) {
    header("Location: index.php?eroare=formular_incomplet");
    exit;
}

$sql = "SELECT * FROM masini";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <title>Selectează mașina</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    .car-wrap {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      margin-bottom: 30px;
    }

    .car-wrap .img {
      height: 200px;
      background-size: cover;
      background-position: center;
    }

    .car-wrap .text {
      padding: 20px;
    }

    .btn {
      border-radius: 20px;
    }
  </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Car<span>Book</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
	          <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
	          <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
	          <li class="nav-item"><a href="pricing.html" class="nav-link">Pricing</a></li>
	          <li class="nav-item active"><a href="car.html" class="nav-link">Cars</a></li>
	          <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li>
	          <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
      <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Cars <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Choose Your Car</h1>
          </div>
        </div>
      </div>
    </section>
    
  <div class="container mt-5">
    <h2 class="text-center mb-5">Alege o mașină pentru rezervare</h2>
    <div class="row">

      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="car-wrap">
            <div class="img" style="background-image: url('images/<?= htmlspecialchars($row['poza']) ?>');"></div>
            <div class="text">
              <h2 class="mb-0"><?= htmlspecialchars($row['denumire']) ?></h2>
              <div class="d-flex mb-3">
                <span class="cat">Automobil</span>
                <p class="price ml-auto">€50 <span>/zi</span></p>
              </div>
              <form action="save.php" method="POST">
                <input type="hidden" name="locatie_ridicare" value="<?= htmlspecialchars($locatie_ridicare) ?>">
                <input type="hidden" name="locatie_predare" value="<?= htmlspecialchars($locatie_predare) ?>">
                <input type="hidden" name="data_ridicare" value="<?= htmlspecialchars($data_ridicare) ?>">
                <input type="hidden" name="data_predare" value="<?= htmlspecialchars($data_predare) ?>">
                <input type="hidden" name="ora_ridicare" value="<?= htmlspecialchars($ora_ridicare) ?>">
                <input type="hidden" name="masina_id" value="<?= $row['masina_id'] ?>">

                <div class="d-flex mb-0 d-block">
                  <button type="submit" class="btn btn-primary py-2 mr-1">Rezervă acum</button>
                  <a href="detalii_masina.php?id=<?= $row['masina_id'] ?>" class="btn btn-secondary py-2 ml-1">Detalii</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

    </div>
  </div>
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
