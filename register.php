<?php
include 'koneksi.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Cek username sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password_hash', 'user')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Registrasi - ANÉLEA’S</title>
  <style>
    /* sama styling seperti login */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f3f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 350px;
    }
    h2 {
      text-align: center;
      color: #c0566d;
      margin-bottom: 20px;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #c0566d;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #a8475b;
    }
    .login-link {
      text-align: center;
      margin-top: 15px;
    }
    .login-link a {
      color: #c0566d;
      text-decoration: none;
    }
    .error {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Registrasi</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label>Username</label>
      <input type="text" name="username" required />
      <label>Password</label>
      <input type="password" name="password" required />
      <button type="submit">Daftar</button>
    </form>

    <div class="login-link">
      Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
  </div>
</body>
</html>
