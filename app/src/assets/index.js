// Init map with Ljubljana coordinates
const map = L.map("map", { zoomControl: false }).setView(
  [46.056946, 14.505751],
  13
);

// Add OSM tiles
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// Add scale
L.control.scale({ position: "bottomright" }).addTo(map);

// Add zoom
L.control.zoom({ position: "topright" }).addTo(map);

// Add geosearch
const searchControl = new L.esri.Controls.Geosearch({
  position: "topright",
}).addTo(map);

const results = new L.LayerGroup().addTo(map);
searchControl.on("results", (data) => {
  results.clearLayers();
  for (let i = data.results.length - 1; i >= 0; i--) {
    results.addLayer(L.marker(data.results[i].latlng));
  }
});

const sportPin = L.icon({
  iconUrl: "assets/ikone/sport-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const kulturaPin = L.icon({
  iconUrl: "assets/ikone/kultura-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const zabavaPin = L.icon({
  iconUrl: "assets/ikone/zabava-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const izobrazevanjePin = L.icon({
  iconUrl: "assets/ikone/izobrazevanje-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const dobrodelnostPin = L.icon({
  iconUrl: "assets/ikone/dobrodelnost-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const ulPin = L.icon({
  iconUrl: "assets/ikone/ul-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const ostaloPin = L.icon({
  iconUrl: "assets/ikone/ostalo-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});
const onlinePin = L.icon({
  iconUrl: "assets/ikone/online-pin.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

// add sidebar
const menuButton = document.getElementById("menu-button");
//const sidebar = document.getElementById("sidebar");

/*menuButton.addEventListener("click", () => {
  toggleSidebar();
});*/

const searchFilter = document.getElementById("search")

// set default data
const filterDateFrom = document.getElementById("date-from");
const filterDateTo = document.getElementById("date-to");

const from = new Date().toISOString().split("T")[0];
filterDateFrom.value = from;

const to = new Date(new Date().setDate(new Date().getDate() + 7)).toISOString().split("T")[0];
filterDateTo.value = to;


/*function toggleSidebar() {
  console.log(sidebar.style.display);
  if (sidebar.style.display === "block") {
    sidebar.style.transform = "translateX(-100%)";
    menuButton.style.display = "block";
    setTimeout(() => {
      sidebar.style.display = "none";
    }, 300);
  } else {
    sidebar.style.display = "block";
    sidebar.style.transform = "translateX(0)";
    menuButton.style.display = "none";
  }
}*/

function getSelectedEventType() {
  const selectedTypes = [];
  const checkboxes = document.querySelectorAll(".type-picker input[type=checkbox]:checked");
  for (const checkbox of checkboxes) {
    selectedTypes.push(checkbox.value);
  }

  return selectedTypes.join(",");
}

function fetchEvents() {
  fetch(`/API/events?q=${encodeURIComponent(searchFilter.value)}&df=${encodeURIComponent(filterDateFrom.value)}&dt=${encodeURIComponent(filterDateTo.value)}&type=${encodeURIComponent(getSelectedEventType())}`).then((res) => {
    if (!res.ok) {
      throw new Error("Failed to fetch events");
    }

    res.json().then((events) => {

      map.eachLayer((layer) => {
        if (layer instanceof L.Marker) {
          map.removeLayer(layer);
        }
      });

      for (const event of events) {
        if (event.loc_x == null || event.loc_y == null) {
          let random_offset_y = Math.random() / 90; // 100 random števil
          let random_offset_x = Math.random() / 90; // 100 random števil
          let random_operator = Math.random() < 0.5 ? 0 : 1;
          event.loc_y = (random_operator) && 46.056946 + random_offset_y || 46.056946 - random_offset_y;
          event.loc_x = (random_operator) && 14.505751 + random_offset_x || 14.505751 - random_offset_x;
          /*event.loc_y = 46.056946 + random_offset_y;
          event.loc_x = 14.505751 + random_offset_x;*/
          console.log(event.loc_y, event.loc_x);
          event.type = 6;
        }

        let iconMarker = null;

        switch (event.type) {
          case 0:
            iconMarker = ulPin;
            break;
          case 1:
            iconMarker = kulturaPin;
            break;
          case 2:
            iconMarker = zabavaPin;
            break;
          case 3:
            iconMarker = izobrazevanjePin;
            break;
          case 4:
            iconMarker = dobrodelnostPin;
            break;
          case 5:
            iconMarker = sportPin;
            break;
          case 6:
            iconMarker = onlinePin;
            break;
          default:
            iconMarker = ostaloPin;
            break;
        }

        const marker = L.marker([event.loc_y, event.loc_x], {
          icon: iconMarker,
        }).addTo(map);
        if(event.description == null) {
          event.description = "Ni opisa";
        }

        let popupHtml = '<div class="event-map-popup">';
        if (event.name)
          popupHtml += `<a style="font-size: 1rem;" href="${event.link}" target="_blank"><b>${event.name}</b></a>`;
        if (event.date_from)
          popupHtml += `<br><p>${new Date(event.date_from).toDateString()}${
            event.date_to ? ` - ${event.date_to}` : ""
          }</p>`;
        if (event.time_from)
          popupHtml += `<p>${event.time_from}${
            event.time_to && event.time_to !== event.time_from
              ? ` - ${event.time_to}`
              : ""
          }</p>`;
        if (event.description) popupHtml += `<br><p">${event.description}</p>`

        marker.bindPopup(popupHtml);
      }
    });
  });
}
function refreshMap(){
  fetchEvents();
}

function fetchEventsAPI(url) {
  fetch(url).then((res) => {
    if (!res.ok) {
      throw new Error("Failed to fetch events");
    }

    res.json().then((events) => {

      map.eachLayer((layer) => {
        if (layer instanceof L.Marker) {
          map.removeLayer(layer);
        }
      });

      for (const event of events) {
        if (event.loc_x == null || event.loc_y == null) {
          let random_offset_y = Math.random() / 90; // 100 random števil
          let random_offset_x = Math.random() / 90; // 100 random števil
          let random_operator = Math.random() < 0.5 ? 0 : 1;
          event.loc_y = (random_operator) && 46.056946 + random_offset_y || 46.056946 - random_offset_y;
          event.loc_x = (random_operator) && 14.505751 + random_offset_x || 14.505751 - random_offset_x;
          /*event.loc_y = 46.056946 + random_offset_y;
          event.loc_x = 14.505751 + random_offset_x;*/
          console.log(event.loc_y, event.loc_x);
          event.type = 6;
        }

        let iconMarker = null;

        switch (event.type) {
          case 0:
            iconMarker = ulPin;
            break;
          case 1:
            iconMarker = kulturaPin;
            break;
          case 2:
            iconMarker = zabavaPin;
            break;
          case 3:
            iconMarker = izobrazevanjePin;
            break;
          case 4:
            iconMarker = dobrodelnostPin;
            break;
          case 5:
            iconMarker = sportPin;
            break;
          case 6:
            iconMarker = onlinePin;
            break;  
          default:
            iconMarker = ostaloPin;
            break;
        }

        const marker = L.marker([event.loc_y, event.loc_x], {
          icon: iconMarker,
        }).addTo(map);
        if(event.description == null) {
          event.description = "Ni opisa";
        }

        let popupHtml = '<div class="event-map-popup">';
        if (event.name)
          popupHtml += `<a style="font-size: 1rem;" href="${event.link}" target="_blank"><b>${event.name}</b></a>`;
        if (event.date_from)
          popupHtml += `<br><p>${new Date(event.date_from).toDateString()}${
            event.date_to ? ` - ${event.date_to}` : ""
          }</p>`;
        if (event.time_from)
          popupHtml += `<p>${event.time_from}${
            event.time_to && event.time_to !== event.time_from
              ? ` - ${event.time_to}`
              : ""
          }</p>`;
        if (event.description) popupHtml += `<br><p">${event.description}</p>`

        marker.bindPopup(popupHtml);
      }
    });
  });
}


fetchEvents();
