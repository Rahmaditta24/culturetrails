<?php
include "koneksi.php";

$id = $_GET['id_wisata'];  

$Q = mysqli_query($koneksi, "SELECT * FROM wisata WHERE id_wisata=" . $id) or die(mysqli_error($koneksi));
$nearby_locations = [];

if ($Q) {
    $posts = array();
    if (mysqli_num_rows($Q)) {
        while ($post = mysqli_fetch_assoc($Q)) {
            $posts[] = $post;

            // Mendapatkan lokasi terdekat dari field nearby_locations (asumsi berupa ID wisata terpisah dengan koma)
            if (!empty($post['nearby_locations'])) {
                $nearby_ids = explode(',', $post['nearby_locations']);
                if (!empty($nearby_ids)) {
                    $placeholders = implode(',', array_fill(0, count($nearby_ids), '?'));
                    $stmt = $koneksi->prepare("SELECT id_wisata, nama_wisata, alamat, latitude, longitude FROM wisata WHERE id_wisata IN ($placeholders)");
                    $stmt->bind_param(str_repeat('i', count($nearby_ids)), ...$nearby_ids);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $nearby_locations[] = $row;
                    }
                    $stmt->close();
                }
            }
        }
    }
    $data = json_encode(array('results' => $posts, 'nearby_locations' => $nearby_locations));
}
?>
