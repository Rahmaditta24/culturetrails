<?php
session_start();
if (empty($_SESSION['username'])) {
    header('location:../index.php');
    exit();
}
include "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "menu_sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "menu_topbar.php"; ?>

                <?php
                $id = $_GET['id_wisata'];
                $query = mysqli_query($koneksi, "SELECT * FROM wisata WHERE id_wisata='$id'");
                $data = mysqli_fetch_array($query);

                // Fetch nearby locations
                $nearby_locations = [];
                if (!empty($data['nearby_locations'])) {
                    $nearby_ids = explode(',', $data['nearby_locations']);
                    $placeholders = implode(',', array_fill(0, count($nearby_ids), '?'));
                    $stmt = $koneksi->prepare("SELECT nama_wisata FROM wisata WHERE id_wisata IN ($placeholders)");
                    $stmt->bind_param(str_repeat('i', count($nearby_ids)), ...$nearby_ids);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        $nearby_locations[] = $row['nama_wisata'];
                    }
                    $stmt->close();
                }

                // Check if data is found
                if ($data) {
                ?>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Detail Wisata <?php echo htmlspecialchars($data['nama_wisata']); ?></h1>
                        </div>
                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Detail Wisata</h6>
                            </div>
                            <div class="card-body">
                                <div class="panel-body">
                                    <table id="example" class="table table-hover table-bordered">
                                        <tr>
                                            <td width="250">Nama Wisata</td>
                                            <td width="550"><?php echo htmlspecialchars($data['nama_wisata']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Deskripsi</td>
                                            <td><?php echo htmlspecialchars($data['deskripsi_p1'] . "<br><br>" . $data['deskripsi_p2'] . "<br><br>" . $data['deskripsi_p3'] . "<br><br>" . $data['deskripsi_p4'] . "<br><br>" . $data['deskripsi_p5']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Harga Tiket</td>
                                            <td>Rp. <?php echo htmlspecialchars($data['harga_tiket']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Latitude</td>
                                            <td><?php echo htmlspecialchars($data['latitude']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Longitude</td>
                                            <td><?php echo htmlspecialchars($data['longitude']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Gambar</td>
                                            <td><img src="<?php echo htmlspecialchars($data['image_url']); ?>" alt="Gambar Wisata" width="160" height="90"></td>
                                        </tr>
                                        <tr>
                                            <td>Tempat Terdekat</td>
                                            <td>
                                                <?php
                                                if (!empty($nearby_locations)) {
                                                    echo htmlspecialchars(implode(', ', $nearby_locations));
                                                } else {
                                                    echo 'Tidak ada tempat terdekat yang ditambahkan';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                <?php
                } else {
                    echo "<div class='container-fluid'><div class='alert alert-danger'>Data tidak ditemukan.</div></div>";
                }
                ?>
            </div>
            <!-- End of Main Content -->
            <?php include "footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
