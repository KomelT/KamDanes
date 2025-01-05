<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KamDanes</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- Geocoder JS -->
  <script src="<?php echo ASSETS_URL ?>Geocoder.js"></script>
  <!-- Geocoder CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.1.1/dist/Control.Geocoder.css" />

  <!-- Geocoder JS -->
  <script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
  <script
    src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
  <!-- Geocoder CSS -->
  <link rel="stylesheet" type="text/css"
    href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">

  <!--sidebar CSS-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-sidebar-v2@0.2.0/dist/leaflet-sidebar.css" />
  <!--sidebar JS-->
  <script src=https://unpkg.com/leaflet-sidebar-v2@3.0.0/js/leaflet-sidebar.min.js></script>

  <!-- Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <!-- Bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL ?>index.css">
</head>
<style>


</style>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">KamDanes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="login">Prijava</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register">Registracija</a>
          </li>
          <?php
            if(isset($_SESSION['username'])) {
               echo '<li class="nav-item">
            <a class="nav-link disabled" href="samcejeprijavljen" tabindex="-1" aria-disabled="true">Dodaj dogodek</a>
          </li>';} ?>
          
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" onclick="toggleSidebar()">Filtri</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  <div class="d-flex h-100">
    <div id="sidebar" class="bg-light p-3 h-100">
      <div class="sidebar-content">
        <h4>Filtri:</h4>
        <input type="text" id="search" class="form-control mb-2" placeholder="Išči po imenu">
        <h5>Datum:</h5>
        <div class="date-picker d-flex mb-2">
          <input type="date" id="date-from" class="form-control me-2">
          <p class="m-0"> - </p>
          <input type="date" id="date-to" class="form-control ms-2">
        </div>

        <h5>Vrsta:</h5>
        <div class="type-picker mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-sport" name="sport" value="5" checked>
            <label class="form-check-label" for="checkbox-type-sport">Šport</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-kultura" name="kultura" value="1" checked>
            <label class="form-check-label" for="checkbox-type-kultura">Kultura</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-zabava" name="zabava" value="2" checked>
            <label class="form-check-label" for="checkbox-type-zabava">Zabava</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-izobrazevanje" name="izobrazevanje"
              value="3" checked>
            <label class="form-check-label" for="checkbox-type-izobrazevanje">Izobraževanje</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-dobrodelnost" name="dobrodelnost"
              value="4" checked>
            <label class="form-check-label" for="checkbox-type-dobrodelnost">Dobrodelnost</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-ul" name="ul" value="0" checked>
            <label class="form-check-label" for="checkbox-type-ul">UL</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox-type-ostalo" name="ostalo" value="6" checked>
            <label class="form-check-label" for="checkbox-type-ostalo">Ostalo</label>
          </div>
        </div>

        <button id="filter-button" class="btn btn-primary mt-3" onclick="fetchEvents()">Filtriraj</button>
        <button id="all-events-button" class="btn btn-secondary mt-3" onclick="fetchEventsAPI('API/events/all')">Vsi dogodki</button>
        <button id="all-events-button" class="btn btn-secondary mt-3" onclick="fetchEventsAPI('API/events/online')">Online dogodki</button>
      </div>
    </div>
    <div id="map" class="w-66" style="width: 100%; height: auto%;"></div>
  </div>

</body>
<!-- Custom JS -->
<script src="<?php echo ASSETS_URL ?>index.js"></script>
<script>
  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("show");
  }
  toggleSidebar();
</script>

</html>
