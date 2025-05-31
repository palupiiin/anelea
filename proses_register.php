<?php
include 'anel\koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Enkripsi aman

// Cek apakah username sudah ada
$cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Username sudah terdaftar!'); window.location='register.php';</script>";
    exit;
}

// Simpan ke database
$query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
} else {
    echo "Gagal registrasi: " . mysqli_error($conn);
}
?>
