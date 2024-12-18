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

// Add sidebar
const button = document.getElementById("menuBtn");
const sidebar = document.getElementById("sidebar");

const zogaIcon = L.icon({
  iconUrl: "assets/ikone/žoga.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const muzikaIcon = L.icon({
  iconUrl: "assets/ikone/muzika.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const kulturnaIcon = L.icon({
  iconUrl: "assets/ikone/kulturni.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

const dramaIcon = L.icon({
  iconUrl: "assets/ikone/drama.png",
  iconSize: [70, 70],
  iconAnchor: [35, 70],
  popupAnchor: [-3, -76],
});

button.addEventListener("click", openNav);
function openNav() {
  sidebar.style.width = "250px";
  button.style.width = "0";
  sidebar.className = "leaflet-top leaflet-left";
}

fetch("/API/events").then((res) => {
  if (!res.ok) {
    throw new Error("Failed to fetch events");
  }

  res.json().then((events) => {
    for (const event of events) {
      const marker = L.marker([event.loc_x, event.loc_y], {
        icon:
          event.category === "Šport"
            ? zogaIcon
            : event.category === "Kultura"
            ? kulturnaIcon
            : event.category === "Glasba"
            ? muzikaIcon
            : dramaIcon,
      }).addTo(map);

      marker.bindPopup(
        `<b>${event.title}</b><br>${event.description}<br>${event.date}`
      );
    }
  });
});
