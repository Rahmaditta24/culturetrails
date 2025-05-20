<?php include "header.php"; ?>
<?php
$id = $_GET['id_wisata'];
include_once "ambildata_id.php";
$obj = json_decode($data);

$id_wisata = "";
$nama_wisata = "";
$alamat = "";
$deskripsi = "";
$harga_tiket = "";
$lat = "";
$long = "";
$image_url = "";
$nearby_locations = [];

// Jika $obj->results memiliki data, tetapkan nilai ke variabel yang sesuai
if (isset($obj->results) && is_array($obj->results)) {
    foreach ($obj->results as $item) {
        $id_wisata = $item->id_wisata;
        $nama_wisata = $item->nama_wisata;
        $alamat = $item->alamat;
        // Gabungkan deskripsi menjadi satu string
        $deskripsi = $item->deskripsi_p1 . "<br><br>" . $item->deskripsi_p2 . "<br><br>" . $item->deskripsi_p3 . "<br><br>" . $item->deskripsi_p4 . "<br><br>" . $item->deskripsi_p5;
        $harga_tiket = $item->harga_tiket;
        $lat = $item->latitude;
        $long = $item->longitude;
        $image_url = $item->image_url;
    }
}

// Jika $obj->nearby_locations memiliki data, tetapkan nilai ke $nearby_locations
if (isset($obj->nearby_locations) && is_array($obj->nearby_locations)) {
    $nearby_locations = $obj->nearby_locations;
}

$title = "Detail dan Lokasi : " . $nama_wisata;

// Ensure the image URL is an absolute URL
$image_url = "http://localhost:8080/SIG-WISATA/admin/uploads/" . basename($image_url);
?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  .card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 30%;
    margin: 15px;
    float: left;
    text-align: center;
  }

  .card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .container {
    padding: 2px 16px;
  }

  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  }

  .card-title {
    font-size: 1.5em;
    margin: 15px 0;
  }

  .map-panel-container {
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
  }

  .map-panel {
    width: 50%;
  }

  .panel-body h5 {
    font-weight: normal;
  }

  .location-title {
    padding-left: 15px;
  }

  /* Tambahkan kelas CSS untuk menyelaraskan peta di kiri */
  .map-container {
    display: flex;
    justify-content: flex-start;
  }

  #map-canvas {
    width: 100%;
    height: 380px;
  }
</style>

<script>
  function initialize() {
    var myLatlng = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
    var mapOptions = {
      zoom: 15,
      center: myLatlng
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var contentString = '<div id="content">' +
      '<div id="siteNotice">' +
      '</div>' +
      '<h1 id="firstHeading" class="firstHeading"><?php echo $nama_wisata ?></h1>' +
      '<div id="bodyContent">' +
      '<p><?php echo $alamat ?></p>' +
      '</div>' +
      '</div>';

    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });

    var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Maps Info',
      icon: 'img/markermap.png'
    });

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
    });

    // Adding nearby locations markers
    var nearbyLocations = <?php echo json_encode($nearby_locations); ?>;
    nearbyLocations.forEach(function(location) {
      var nearbyLatlng = new google.maps.LatLng(location.latitude, location.longitude);
      var nearbyMarker = new google.maps.Marker({
        position: nearbyLatlng,
        map: map,
        title: location.nama_wisata,
        icon: 'img/nearby_marker.png'
      });

      var nearbyInfowindow = new google.maps.InfoWindow({
        content: '<div><strong>' + location.nama_wisata + '</strong><br>' + location.alamat + '</div>'
      });

      google.maps.event.addListener(nearbyMarker, 'click', function() {
        nearbyInfowindow.open(map, nearbyMarker);
      });
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);
</script>

<section class="about-info-area section-gap">
  <div class="container" style="padding-top: 20px;">
    <div class="row">
      <div class="col-md-12" data-aos="fade-up" data-aos-delay="200">
        <div class="panel panel-info panel-dashboard">
          <div class="panel-heading centered">
            <h1 class="panel-title"><strong><?php echo $nama_wisata ?></strong></h1>
          </div>
          <div class="panel-body">
            <img src="<?php echo $image_url ?>" alt="<?php echo $nama_wisata ?>" style="max-width: 50%; height: auto; padding-top: 10px;">
            <hr style="padding-top: 10px;">
            <table>
              <tr>
                  <td style="padding-right: 28px;">
                      <i class="fas fa-map-marker-alt" style="vertical-align: middle;"></i>
                  </td>
                  <td>
                      <h5><?php echo $alamat ?></h5>
                  </td>
              </tr></table>
            <table style="margin-top: 20px;"><tr>
                  <td style="padding-right: 20px;">
                      <i class="fas fa-money-bill-wave" style="vertical-align: middle;"></i>
                  </td>
                  <td>
                      <h5 style="margin-bottom: 0;">Rp. <?php echo $harga_tiket ?></h5>
                  </td>
            </tr></table>
            <p>
              <h5><?php echo $deskripsi ?></h5>
            </p>
            <!-- Map Panel -->
            <h4 class="panel-title" style="padding-bottom: 20px;"><strong>Lokasi</strong></h4>
            <div class="map-container">
              <div class="panel panel-info panel-dashboard map-panel">
                <div class="panel-body">
                  <div id="map-canvas"></div>
                </div>
              </div>
            </div>
          <!-- Display nearby locations -->
          <h4 style="padding-top: 20px;"><strong>Tempat Terdekat</strong></h4>
            <div class="panel-body location-title">
              <ul>
                <?php foreach ($nearby_locations as $nearby) {
                  // Tautan ke halaman detail dengan id_wisata sebagai parameter
                  $detail_link = "detail.php?id_wisata=" . $nearby->id_wisata;
                ?>
                <!-- Tampilkan Kartu (Card) untuk setiap tempat terdekat tanpa gambar -->
                <a href="<?php echo $detail_link; ?>">
                  <div class="card">
                      <div class="container">
                          <h4 class="card-title"><b><?php echo htmlspecialchars($nearby->nama_wisata); ?></b></h4>
                          <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($nearby->alamat); ?></p>
                      </div>
                  </div>
                </a>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>
