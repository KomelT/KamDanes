<!DOCTYPE html>
<html lang="en">

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
          <?php
            if(isset($_SESSION['username'])) {
               echo '<li class="nav-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          Dodaj dogodek
                        </button>                  
                      </li>';
                echo '<li class="nav-item">
                <a class="nav-link" href="logout">Odjava</a>
              </li>';
            }else{
                echo '<li class="nav-item">
                <a class="nav-link" href="login">Prijava</a>
              </li>';
                echo '<li class="nav-item">
                <a class="nav-link" href="register">Registracija</a>
              </li>';
            } 
            if(isset($_SESSION['role'])) {
              echo '<li class="nav-item">
                <a class="nav-link" href="admin">Admin panel</a>
              </li>';
            }
          ?>
          <li class="nav-item">
            <a class="nav-link " href="#" tabindex="-1" onclick="toggleSidebar()">Filtri</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Add event modal shit idk Tit je gej. -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Dodaj dogodek</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="addEventForm" id="addEventForm" method="post">
            <label for="name">Ime dogodka</label><br>
            <input class="form-control form-control-sm" type="text" name="name" id="name" required><br>

            <label for="organisation">Organizacija</label> <br>
            <input class="form-control form-control-sm" type="text" name="organisation" id="organisation"><br>

            <label for="artist_name">Ime umetnika</label> <br>
            <input class="form-control form-control-sm" type="text" name="artist_name" id="artist_name"><br>
            
            <label for="date_from">Datum od</label> <br>
            <input class="form-control form-control-sm" type="date" name="date_from" id="date_from" required><br>

            <label for="date_to">Datum do</label> <br>
            <input class="form-control form-control-sm" type="date" name="date_to" id="date_to" required><br>

            <input class="form-check-input" type="checkbox" name="online" id="online-input">
            <label class="form-check-label" for="online">Online dogodek</label> <br><br>

            <label for="address">Ulica</label> <br>
            <input class="form-control form-control-sm" type="text" name="street" id="street-input" required><br>

            <label for="city">Mesto</label> <br>
            <input class="form-control form-control-sm" type="text" name="city" id="city-input" required><br>

            <label for="zip">Poštna številka</label> <br>
            <input class="form-control form-control-sm" type="text" name="zip" id="zip-input" required><br>

            <label for="time_from">Ura začetka</label><br>
            <input class="form-control form-control-sm" type="time" name="time_from" id="time_from"><br>

            <label for="time_to">Ura konca</label><br>
            <input class="form-control form-control-sm" type="time" name="time_to" id="time_to"><br>

            <input class="form-check-input" type="checkbox" name="age_lim_bool" id="age_lim_bool-input">
            <label class="form-check-label" for="age_lim_bool">Starostna omejitev</label> <br><br>

            <label for="age_lim">Minimalna starost v letih</label><br>
            <input class="form-control form-control-sm" type="number" name="age_lim" id="age_lim" disabled><br>

            <label for="description">Opis</label><br>
            <textarea class="form-control" name="description" id=""description></textarea><br>

            <input class="form-check-input" type="checkbox" name="cena_bool" id="cena_bool-input" checked>
            <label class="form-check-label" for="cena_bool">Brezplačen dogodek</label> <br><br>

            <label for="price">Cena</label><br>
            <input class="form-control form-control-sm" type="number" name="price" id="price" disabled><br>

            <label for="type">Tip dogodka</label><br>
            <select class="form-select" name="type" id="type">
              <option value="0">UL Dogodek</option>
              <option value="1">Kulturni dogodek</option>
              <option value="2">Zabava</option>
              <option value="3">Izobraževanje</option>
              <option value="4">Dobrodelnost</option>
              <option value="5">Šport</option>
              <option value="6" selected>Ostalo</option>
            </select><br>
            
            <label for="link">Link do dogodka</label><br>
            <input class="form-control form-control-sm" type="text" name="link" id="link" required><br>

            <div class="modal-footer">
              <input type="submit" value="Dodaj dogodek" class="btn btn-primary">
              <button type="button" class="btn btn-secondary" id="clearButton" >Počisti</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

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
    <div id="map" class="w-66" style="width: 100%; height: auto;"></div>
  </div>

</body>
<!-- Custom JS -->
<script src="<?php echo ASSETS_URL ?>index.js"></script>
<script>
  function alertError(msg) {
    alert(`Napaka: ${msg}`);
  }

  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("show");
  }

  toggleSidebar();
  
  <?php
  if(isset($error)){
    echo "alertError('$error');";
  }
  ?>

  document.getElementById("online-input").addEventListener("change", function() {
    if (this.checked) {
      document.getElementById("street-input").value = "";
      document.getElementById("city-input").value = "";
      document.getElementById("zip-input").value = "";
      document.getElementById("street-input").disabled = true;
      document.getElementById("city-input").disabled = true;
      document.getElementById("zip-input").disabled = true;
    } else {
      document.getElementById("street-input").disabled = false;
      document.getElementById("city-input").disabled = false;
      document.getElementById("zip-input").disabled = false;
    }
  });

  document.getElementById("age_lim_bool-input").addEventListener("change", function() {
    if (this.checked) {
      document.getElementById("age_lim").disabled = false;
    } else {
      document.getElementById("age_lim").disabled = true;
    }
  });

  document.getElementById("cena_bool-input").addEventListener("change", function() {
    if (this.checked) {
      document.getElementById("price").disabled = true;
    } else {
      document.getElementById("price").disabled = false;
    }
  });

  document.getElementById("clearButton").addEventListener("click", function(){
    document.getElementById("addEventForm").reset()
    document.getElementById("street-input").disabled = false;
    document.getElementById("city-input").disabled = false;
    document.getElementById("zip-input").disabled = false;
    document.getElementById("age_lim").disabled = true;
    document.getElementById("price").disabled = true;
  })
  
  // function getData(){
  //   const coordinates = getCoordinates();
  //   return {
      // id_user: <?php echo $_SESSION['id'] ?>,
  //     name: document.getElementById("name").value,
  //     organisation: document.getElementById("organisation").value,
  //     artist_name: document.getElementById("artist_name").value,
  //     date_from: document.getElementById("date_from").value,
  //     date_to: document.getElementById("date_to").value,
  //     loc_x: coordinates["lat"] ? coordinates["lat"] : null,
  //     loc_y: coordinates["lng"] ? coordinates["lng"] : null,
  //     time_from: document.getElementById("time_from").value,
  //     time_to: document.getElementById("time_to").value,
  //     age_lim: document.getElementById("age_lim").value,
  //     description: document.getElementById("description").value,
  //     price: document.getElementById("price").value,
  //     type: document.getElementById("type").value,
  //     link: document.getElementById("link").value,
  //     online: document.getElementById("online-input").value
  //   }
  // }

  // async function getCoordinates(){
  //   let street = document.getElementById("street-input").value;
  //   let city = document.getElementById("city-input").value;
  //   let zip = document.getElementById("zip-input").value;
  //   let address = `${street}, ${city}, ${zip}`;
  //   try {
  //     let coordinates = await Geocoder.getCoordinates(address);
  //     return coordinates;
  //   } catch (error) {
  //     console.error("Error fetching coordinates:", error);
  //     alert("Unable to fetch coordinates. Please try again.");
  //   }
  // }

  // function sendDataToAPI(){
  //   const data = getData();
  //   fetch('API/pushEvent', {
  //     method: 'POST',
  //     headers: {
  //       'Content-Type': 'application/json',
  //     },
  //     body: JSON.stringify(data),
  //   })
  //   .then(response => response.json())
  //   .then(data => {
  //     console.log('Success:', data);
  //   })
  //   .catch((error) => {
  //     console.error('Error:', error);
  //   });
  // }

  // document.getElementById("addEventForm").addEventListener("submit", function(event) {
  //   event.preventDefault();
  //   sendDataToAPI();
  // });
</script>

</html>