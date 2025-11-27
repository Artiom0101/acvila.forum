<?php
session_start();
require_once '../conn.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Completează ambele câmpuri!";
    } else {
        // AICI E SECRETUL: facem MD5 pe parolă ÎNAINTE de căutare (exact ca în codul vechi)
        $password_md5 = md5($password);

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = ? LIMIT 1");
        $stmt->bind_param("ss", $email, $password_md5);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            session_regenerate_id(true);
            $_SESSION['admin']     = $user['id'];
            $_SESSION['category']  = 'super';
            $_SESSION['name']      = 'Admin';

            echo '<script>alert("Bine ai venit!"); window.location="admin.php";</script>';
            exit();
        } else {
            $error_message = "Email sau parolă incorecte!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Acvila</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { padding: 0; margin: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }
        body { display: flex; justify-content: center; align-items: center; background: #23242a; height: 100vh; overflow: hidden; }
        .box { position: relative; width: 380px; height: 480px; background: #1c1c1c; border-radius: 50px 5px; overflow: hidden; box-shadow: 0 0 40px rgba(0,0,0,0.8); }
        .box::before, .box::after { content: ""; position: absolute; top: -50%; left: -50%; width: 380px; height: 480px; background: linear-gradient(60deg, transparent, #45f3ff, #45f3ff); transform-origin: bottom right; animation: animate 6s linear infinite; }
        .box::after { background: linear-gradient(60deg, transparent, #c5b100, #7ad800); animation-delay: -3s; }
        @keyframes animate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        form { position: absolute; inset: 4px; background: #28292d; border-radius: 50px 5px; z-index: 10; padding: 40px 35px; display: flex; flex-direction: column; }
        .title h1 { color: #a7ff21; font-size: 2.2rem; font-weight: 700; text-align: center; margin-bottom: 30px; text-shadow: 0 0 10px rgba(167,255,33,0.5); }
        .input-box { margin: 22px 0; }
        .input-box label { color: #9eb3b5; font-size: 0.95rem; display: block; margin-bottom: 8px; }
        .input-box input { width: 100%; padding: 14px 18px; background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.1); outline: none; border-radius: 15px; color: white; font-size: 1rem; transition: 0.3s; }
        .input-box input:focus { border-color: #45f3ff; box-shadow: 0 0 15px rgba(69,243,255,0.4); }
        input[type="submit"] { background: linear-gradient(135deg, #45f3ff, #00f2c3); color: #000; font-weight: 600; font-size: 1.1rem; cursor: pointer; margin-top: 15px; padding: 15px; border: none; border-radius: 15px; transition: 0.4s; box-shadow: 0 8px 20px rgba(69,243,255,0.4); }
        input[type="submit"]:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(69,243,255,0.6); }
        .error { color: #ff6b6b; background: rgba(255,107,107,0.15); padding: 12px; border-radius: 10px; text-align: center; margin: 15px 0; font-size: 0.95rem; }
        .footer-text { text-align: center; margin-top: 25px; color: #66757f; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="box">
        <form method="POST" action="">
            <div class="title">
                <h1>Login Acvila</h1>
            </div>

            <?php if (!empty($error_message)): ?>
                <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <div class="input-box">
                <label>Email</label>
                <input type="text" name="email" placeholder="Introdu email-ul" required autofocus>
            </div>

            <div class="input-box">
                <label>Parolă</label>
                <input type="password" name="password" placeholder="Introdu parola" required>
            </div>

            <input type="submit" value="Autentificare">

            <div class="footer-text">
                Panou Admin &copy; <?php echo date('Y'); ?> Acvila Trans
            </div>
        </form>
    </div>

</body>
</html>