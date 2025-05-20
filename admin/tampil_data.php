<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:../tampil_data.php?pesan=belum_login");
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Cagar Budaya Bogor</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Cagar Budaya</th>
                                            <th>Alamat</th>
                                            <th>Harga Tiket</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>Gambar</th>
                                            <th>Tempat Terdekat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $data = mysqli_query($koneksi, "SELECT * FROM wisata");
                                        while ($d = mysqli_fetch_array($data)) {
                                            $no++;

                                            // Fetch names of nearby locations
                                            $nearby_names = [];
                                            if (!empty($d['nearby_locations'])) {
                                                $nearby_ids = explode(',', $d['nearby_locations']);
                                                $nearby_query = mysqli_query($koneksi, "SELECT nama_wisata FROM wisata WHERE id_wisata IN (" . implode(',', $nearby_ids) . ")");
                                                while ($nearby = mysqli_fetch_assoc($nearby_query)) {
                                                    $nearby_names[] = $nearby['nama_wisata'];
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td><b><a href="detail_data.php?id_wisata=<?php echo $d['id_wisata']; ?>"><?php echo $d['nama_wisata']; ?></a></b></td>
                                                <td><?php echo $d['alamat']; ?></td>
                                                <td>Rp. <?php echo $d['harga_tiket']; ?></td>
                                                <td><?php echo $d['latitude']; ?></td>
                                                <td><?php echo $d['longitude']; ?></td>
                                                <td><img src="<?php echo $d['image_url']; ?>" width="160" height="90"></td>
                                                <td><?php echo implode(', ', $nearby_names); ?></td>
                                                <td>
                                                    <a href="edit_data.php?id_wisata=<?php echo $d['id_wisata']; ?>" class="btn-sm btn-primary"><span class="fas fa-edit"></span></a>
                                                    <br><br>
                                                    <a href="hapus_aksi.php?id_wisata=<?php echo $d['id_wisata']; ?>" class="btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><span class="fas fa-trash"></span></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <?php include "footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
