<?php include "header.php"; ?>

<!-- start banner Area -->
<section class="banner-area relative">
  <div class="overlay overlay-bg"></div>
  <div class="container">
    <div class="row fullscreen align-items-center justify-content-between">
      <div class="col-lg-6 col-md-6 banner-left">
        <h6 class="text-white">CULTURETRAILS: SISTEM INFORMASI GEOGRAFIS CAGAR BUDAYA</h6>
        <h1 class="text-white">KOTA BOGOR</h1>
        <p class="text-white">
          CultureTrails merupakan aplikasi pemetaan geografis tempat wisata cagar budaya di Bogor. Aplikasi ini memuat informasi dan lokasi dari tempat wisata cagar budaya di Bogor.
        </p>
        <a href="#image-gallery-area" class="primary-btn ">Lihat Detail</a>
      </div>

    </div>
  </div>
  </div>
</section>
<!-- End banner Area -->

<main id="main">

<!-- Start image-gallery Area -->
<section class="image-gallery-area section-gap" id="image-gallery-area">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="menu-content pb-70 col-lg-8">
        <div class="title text-center">
          <h1 class="mb-10">Beberapa situs budaya di Bogor</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=2" class="img-gal">
          <img class="img-fluid" src="admin/uploads/museum-peta-profile1639203628.jpeg" alt=""> <br>
          <div class="gallery-description">
            <h4>Monumen dan Museum PETA</h4>
            <p>Bangunan museum ini bergaya kolonial Belanda, dengan arsitektur yang megah dan elegan.</p>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=62" class="img-gal">
          <img class="img-fluid" src="admin/uploads/museum-perjuangan-di-jalan-merdeka-kecamatan-bogor-tengah-kota-bogor.jpg" alt=""> <br>
          <div class="gallery-description">
            <h4>Museum Perjuangan</h4>
            <p>Gedung ini awalnya didirikan oleh Willem Gustav Winner pada tahun 1879.</p>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=63" class="img-gal">
          <img class="img-fluid" src="admin/uploads/istana-bogor place indonesia.jpg" alt=""> <br>
          <div class="gallery-description">
            <h4>Istana Bogor</h4>
            <p>Dikenal sebagai Buitenzorg atau San Souci dengan keindahan arsitektur kolonial Belandanya.</p>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=64" class="img-gal">
          <img class="img-fluid" src="admin/uploads/kebun raya bogor.jpg" alt="">  <br>
          <div class="gallery-description">
            <h4>Kebun Raya Bogor</h4>
            <p>Tidak jauh dari keindahan Istana Bogor, ada keajaiban alam yang memukau: Kebun Raya Bogor. </p>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=66" class="img-gal">
          <img class="img-fluid" src="admin/uploads/Museum Zoologi.jpg" alt=""> <br>
          <div class="gallery-description">
            <h4>Museum Zoologi</h4>
            <p>Museum ini bukan sekadar bangunan bersejarah, ia adalah jendela ke keterkaitan antara manusia dan satwa liar.</p>
          </div>
        </a>
      </div>
      <div class="col-md-6 col-lg-4 single-gallery">
        <a href="detail.php?id_wisata=67" class="img-gal">
          <img class="img-fluid" src="admin/uploads/vihara-dhanagun-hok-tek-bio.jpg" alt=""> <br>
          <div class="gallery-description">
            <h4>Vihara Dhanagun</h4>
            <p>Vihara ini telah menjadi tempat ibadah di Bogor, menjadi pusat kegiatan keagamaan dan kebudayaan yang kaya akan sejarah dan makna.</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
<!-- End image-gallery Area -->
  <!-- Start about-info Area -->
  <section class="price-area section-gap">
    <section id="peta_wisata" class="about-info-area section-gap">
      <div class="container">
        <div class="title text-center">
          <h1 class="mb-10">Peta Lokasi Wisata</h1>
          <br>
        </div>
        <div class="row align-items-center">

          <div id="map" style="width:100%;height:480px;"></div>
          <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap "></script>
          <script type="text/javascript">
            functQ-----==
            --
            -
            --.ion initialize() {

              var mapOptions = {
                zoom: 13,
                center: new google.maps.LatLng(-6.5963, 106.7972),
                disableDefaultUI: false
              };

              var mapElement = document.getElementById('map');

              var map = new google.maps.Map(mapElement, mapOptions);

              setMarkers(map, officeLocations);

            }

            var officeLocations = [
              <?php
              $data = file_get_contents('http://localhost:8080/SIG-WISATA/ambildata.php');
              $no = 1;
              if (json_decode($data, true)) {
                $obj = json_decode($data);
                foreach ($obj->results as $item) {
              ?>[<?php echo $item->id_wisata ?>, '<?php echo $item->nama_wisata ?>', '<?php echo $item->alamat ?>', <?php echo $item->longitude ?>, <?php echo $item->latitude ?>],
              <?php
                }
              }
              ?>
            ];

            function setMarkers(map, locations) {
              var globalPin = 'img/marker.png';

              for (var i = 0; i < locations.length; i++) {

                var office = locations[i];
                var myLatLng = new google.maps.LatLng(office[4], office[3]);
                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                var contentString =
                  '<div id="content">' +
                  '<div id="siteNotice">' +
                  '</div>' +
                  '<h5 id="firstHeading" class="firstHeading">' + office[1] + '</h5>' +
                  '<div id="bodyContent">' +
                  '<a href=detail.php?id_wisata=' + office[0] + '>Info Detail</a>' +
                  '</div>' +
                  '</div>';

                var marker = new google.maps.Marker({
                  position: myLatLng,
                  map: map,
                  title: office[1],
                  icon: 'img/markermap.png'
                });

                google.maps.event.addListener(marker, 'click', getInfoCallback(map, contentString));
              }
            }

            function getInfoCallback(map, content) {
              var infowindow = new google.maps.InfoWindow({
                content: content
              });
              return function() {
                infowindow.setContent(content);
                infowindow.open(map, this);
              };
            }

            initialize();
          </script>

        </div>


      </div>
    </section>
    <!-- End about-info Area -->
    <!-- Start price Area -->
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-70 col-lg-8">
          <div class="title text-center">
            <h1 class="mb-10">Jangkauan Peta</h1>
            <p>Aplikasi pemetaan geografis Cagar Budaya di Bogor ini memuat informasi dan lokasi dari wisata cagar budaya yang ada di Bogor. Pemetaan diambil dari data lokasi Google Maps.
            </p>
          </div>
        </div>
      </div>

      <!-- End other-issue Area -->

    </div>
    </div> <!-- ======= Counts Section ======= -->
    <section id="counts">
      <div class="container">
        <div class="title text-center">
          <h1 class="mb-10">Jumlah Tempat Wisata</h1>
          <br>
        </div>
        <div class="row d-flex justify-content-center">


          <?php
          include_once "countsma.php";
          $obj = json_decode($data);
          $sman = "";
          foreach ($obj->results as $item) {
            $sman .= $item->sma;
          }
          ?>

          <div class="text-center">
            <h1><span data-toggle="counter-up"><?php echo $sman; ?></span></h1>
            <br>
          </div>
          <?php
          include_once "countsmk.php";
          $obj2 = json_decode($data);
          $smkn = "";
          foreach ($obj2->results as $item2) {
            $smkn .= $item2->smk;
          }
          ?>


        </div>

      </div>
    </section><!-- End Counts Section -->
    </div>
  </section>
  <!-- End testimonial Area -->


  <?php include "footer.php"; ?>