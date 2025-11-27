<?php
session_start();
require 'conexiune.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Te rog completează toate câmpurile.";
    } else {
        $sql = "SELECT id, parola FROM utilizatori WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['parola'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.html");
                exit;
            } else {
                $error = "Parolă incorectă.";
            }
        } else {
            $error = "Utilizator inexistent.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>Login - Carbook</title>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="css/style1.css" />
</head>
<body>
  <div class="container">
    <div class="forms">
      <div class="form login">
        <span class="title">Login</span>

        <?php if ($error): ?>
          <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
          <div class="input-field">
            <input type="text" name="username" placeholder="Enter your username or email" required />
            <i class="uil uil-user icon"></i>
          </div>

          <div class="input-field">
            <input type="password" name="password" class="password" placeholder="Enter your password" required />
            <i class="uil uil-lock icon"></i>
            <i class="uil uil-eye-slash showHidePw"></i>
          </div>

          <div class="checkbox-text">
            <div class="checkbox-content">
              <input type="checkbox" id="logCheck" name="remember" />
              <label for="logCheck" class="text">Remember me</label>
            </div>
            <a href="#" class="text">Forgot password?</a>
          </div>

          <div class="input-field button">
            <input type="submit" value="Login" href="index.html"/>
          </div>
        </form>

        <div class="login-signup">
          <span class="text">
            Not a member?
            <a href="register.php" class="text signup-link">Signup Now</a>
          </span>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
