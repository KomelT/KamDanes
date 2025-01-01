<!DOCTYPE html>
<html lang="si">

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
  <div id="map" style="height: 100%; width: 100%;"></div>
  <div class="leaflet-top leaflet-left">
    <button id="menu-button" class="menu-button">
      ≣ Menu
    </button>
    <div id="sidebar" class="sidebar">
      <div class="sidebar-header">
        <h1>Kam danes</h1>
        <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()">&times;</a>
      </div>
      <div class="sidebar-content">
        <h4>Filtri</h4>
        <input type="text" id="search" placeholder="Išči po imenu">

        <h5>Datum</h5>
        <div class="date-picker">
          <input type="date" id="date-from">
          <p> - </p>
          <input type="date" id="date-to">
        </div>

        <button id="filter-button" class="btn btn-primary mt-3" onclick="fetchEvents()">Filtriraj</button>
      </div>
    </div>
  </div>
</body>
<!-- Custom JS -->
<script src="<?php echo ASSETS_URL ?>index.js"></script>

</html>