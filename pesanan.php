<?php
session_start();
include 'koneksi.php';

// Ambil data dari form
$nama = $_POST['nama'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$cart_data = json_decode($_POST['cart_data'], true);

// Simpan setiap produk dalam pesanan ke database
foreach ($cart_data as $item) {
    $produk = $item['name'];
    $harga = $item['price'];
    $tanggal = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO orderss (buyer_name, buyer_contact, buyer_address, product_name, price, order_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $nama, $no_hp, $alamat, $produk, $harga, $tanggal);
    $stmt->execute();
}

echo "<script>alert('Pesanan berhasil disimpan!'); window.location.href='index.html';</script>";