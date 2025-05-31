<?php
session_start();
include 'koneksi.php';

// Cek apakah form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Tidak perlu escape karena tidak digunakan dalam query

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Bandingkan password biasa (karena belum pakai hash)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: index.html");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login - ANÉLEA’S</title>
  <style>
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
    .register-link {
      text-align: center;
      margin-top: 15px;
    }
    .register-link a {
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
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label>Username</label>
      <input type="text" name="username" required />
      <label>Password</label>
      <input type="password" name="password" required />
      <button type="submit">Login</button>
    </form>

    <div class="register-link">
      Belum punya akun? <a href="register.php">Daftar di sini</a>
    </div>
  </div>
</body>
</html>
