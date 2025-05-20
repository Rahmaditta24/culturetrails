<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include "../koneksi.php";

// Fetch existing locations
$result = mysqli_query($koneksi, "SELECT id_wisata, nama_wisata FROM wisata");
?>

<!DOCTYPE html>
<html lang="en">
<?php include "header.php"; ?>

<body id="page-top">
    <div id="wrapper">
        <?php include "menu_sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "menu_topbar.php"; ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Data Tempat Wisata</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" action="tambah_aksi.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nama Wisata</label>
                                    <input name="nama_wisata" type="text" class="form-control" placeholder="Nama Wisata" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input name="alamat" class="form-control" type="text" placeholder="Alamat" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Paragraf 1</label>
                                    <textarea name="deskripsi_p1" class="form-control" placeholder="Deskripsi Paragraf 1" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Paragraf 2</label>
                                    <textarea name="deskripsi_p2" class="form-control" placeholder="Deskripsi Paragraf 2"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Paragraf 3</label>
                                    <textarea name="deskripsi_p3" class="form-control" placeholder="Deskripsi Paragraf 3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Paragraf 4</label>
                                    <textarea name="deskripsi_p4" class="form-control" placeholder="Deskripsi Paragraf 4"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Paragraf 5</label>
                                    <textarea name="deskripsi_p5" class="form-control" placeholder="Deskripsi Paragraf 5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Harga Tiket</label>
                                    <input name="harga_tiket" class="form-control" type="text" placeholder="Harga Tiket" required>
                                </div>
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input name="latitude" class="form-control" type="text" placeholder="-7.3811577" required>
                                </div>
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input name="longitude" class="form-control" type="text" placeholder="109.2550945" required>
                                </div>
                                <div class="form-group">
                                    <label>Upload Gambar</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Tempat Terdekat</label>
                                    <select name="nearby_locations[]" class="form-control" multiple required>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <option value="<?php echo $row['id_wisata']; ?>"><?php echo $row['nama_wisata']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Simpan" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "footer.php"; ?>
        </div>
    </div>
</body>
</html>
