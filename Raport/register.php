<?php
require 'conexiune.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = trim($_POST['nume'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $parola = $_POST['parola'] ?? '';
    $parola_confirmare = $_POST['parola_confirmare'] ?? '';
    $term_acceptat = isset($_POST['termCon']) ? true : false;

    if (!$term_acceptat) {
        $error = "Trebuie să accepți termenii și condițiile.";
    } elseif (empty($nume) || empty($email) || empty($parola) || empty($parola_confirmare)) {
        $error = "Te rog completează toate câmpurile.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresa de email nu este validă.";
    } elseif ($parola !== $parola_confirmare) {
        $error = "Parolele nu coincid.";
    } else {
        $sql_check = "SELECT id FROM utilizatori WHERE email = ?";
        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $error = "Acest email este deja înregistrat.";
            } else {
                $parola_hash = password_hash($parola, PASSWORD_DEFAULT);

                $sql = "INSERT INTO utilizatori (username, email, parola) VALUES (?, ?, ?)";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sss", $nume, $email, $parola_hash);
                    if ($stmt->execute()) {
                        $success = "Înregistrare reușită! Poți face login acum.";
                        $nume = $email = '';
                    } else {
                        $error = "Eroare la înregistrare: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Eroare la pregătirea interogării: " . $conn->error;
                }
            }
            $stmt_check->close();
        } else {
            $error = "Eroare la pregătirea interogării: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>Register - Carbook</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>
<body>
  <div class="container">
    <div class="forms">
      <div class="form signup">
        <span class="title">Registration</span>

        <?php if ($error): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
          <p style="color:green;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
          <div class="input-field">
            <input type="text" name="nume" placeholder="Enter your name" value="<?= htmlspecialchars($nume ?? '') ?>" required />
            <i class="uil uil-user"></i>
          </div>

          <div class="input-field">
            <input type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($email ?? '') ?>" required />
            <i class="uil uil-envelope icon"></i>
          </div>

          <div class="input-field">
            <input type="password" name="parola" class="password" placeholder="Create a password" required />
            <i class="uil uil-lock icon"></i>
          </div>

          <div class="input-field">
            <input type="password" name="parola_confirmare" class="password" placeholder="Confirm a password" required />
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
          </div>

          <div class="checkbox-text">
            <div class="checkbox-content">
              <input type="checkbox" id="termCon" name="termCon" <?= (isset($_POST['termCon']) ? 'checked' : '') ?> required />
              <label for="termCon" class="text">I accepted all terms and conditions</label>
            </div>
          </div>

          <div class="input-field button">
            <input type="submit" value="Signup" />
          </div>
        </form>

        <div class="login-signup">
          <span class="text">
            Already a member?
            <a href="login.php" class="text login-link">Login Now</a>
          </span>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
