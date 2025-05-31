<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query = "SELECT * FROM orderss ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard Admin ANÉLEA’S</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 30px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #c0566d;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #f2a1b8;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .logout {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #dc3545;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .logout:hover {
      background-color: #c82333;
    }
    .center {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Dashboard Admin ANÉLEA’S</h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Nama Pembeli</th>
        <th>Kontak</th>
        <th>Alamat</th>
        <th>Produk</th>
        <th>Harga</th>
        <th>Tanggal</th>
      </tr>

      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['buyer_name']) ?></td>
            <td><?= htmlspecialchars($row['buyer_contact']) ?></td>
            <td><?= htmlspecialchars($row['buyer_address']) ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= number_format($row['price'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['order_date']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="center">Data order kosong</td>
        </tr>
      <?php endif; ?>
    </table>

    <a href="logout.php" class="logout">Logout</a>
  </div>
</body>
</html>
