<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "../koneksi.php";

$nama = $_POST['nama_wisata'];
$alamat = $_POST['alamat'];
// Gabungkan deskripsi dari lima paragraf menjadi satu string dengan menggunakan tag <br>
$deskripsi_p1 = $_POST['deskripsi_p1'];
$deskripsi_p2 = $_POST['deskripsi_p2'];
$deskripsi_p3 = $_POST['deskripsi_p3'];
$deskripsi_p4 = $_POST['deskripsi_p4'];
$deskripsi_p5 = $_POST['deskripsi_p5'];
$deskripsi = $deskripsi_p1 . "<br><br>" . $deskripsi_p2 . "<br><br>" . $deskripsi_p3 . "<br><br>" . $deskripsi_p4 . "<br><br>" . $deskripsi_p5;
$harga_tiket = $_POST['harga_tiket'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$nearby_locations = isset($_POST['nearby_locations']) ? implode(',', $_POST['nearby_locations']) : ''; // Convert array to comma-separated string

// Handle image upload
if ($_FILES['image']['name']) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    $image_url = $target_file;
} else {
    $image_url = "";
}

// Insert data into database
$query = "INSERT INTO wisata (nama_wisata, alamat, deskripsi_p1, deskripsi_p2, deskripsi_p3, deskripsi_p4, deskripsi_p5, harga_tiket, latitude, longitude, image_url, nearby_locations) 
          VALUES ('$nama', '$alamat', '$deskripsi_p1' , '$deskripsi_p2' , '$deskripsi_p3' , '$deskripsi_p4' , '$deskripsi_p5' , '$harga_tiket', '$latitude', '$longitude', '$image_url', '$nearby_locations')";
mysqli_query($koneksi, $query);

header("Location: tampil_data.php");
exit();
?>
