//iniciariziraj mapo koordinte ljubljane
const map = L.map('map', { zoomControl: false} ).setView([46.056946, 14.505751], 13);
 
//copyright
const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


//skala
L.control.scale({ position: 'topright'}).addTo(map);

//zoom
L.control.zoom({ position: 'topright'}).addTo(map);
 
//search bar
var searchControl = new L.esri.Controls.Geosearch({ position : 'topright'}).addTo(map);
var results = new L.LayerGroup().addTo(map);
searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  }
);
var button = document.getElementById("menuBtn");
var sidebar = document.getElementById("sidebar");

var zogaIcon = L.icon({
  iconUrl: 'assets/ikone/žoga.png',
  iconSize:     [70, 70], // size of the icon
  iconAnchor:   [35, 70],
  popupAnchor:  [-3, -76] // point of the icon which will correspond to marker's location
});

var muzikaIcon = L.icon({
  iconUrl: 'assets/ikone/muzika.png',
  iconSize:     [70, 70], // size of the icon
  iconAnchor:   [35, 70],
  popupAnchor:  [-3, -76] // point of the icon which will correspond to marker's location
});

var kulturnaIcon = L.icon({
  iconUrl: 'assets/ikone/kulturni.png',
  iconSize:     [70, 70], // size of the icon
  iconAnchor:   [35, 70], 
  popupAnchor:  [-3, -76]// point of the icon which will correspond to marker's location
});

var dramaIcon = L.icon({
  iconUrl: 'assets/ikone/drama.png',
  iconSize:     [70, 70], // size of the icon
  iconAnchor:   [35, 70],
  popupAnchor:  [-3, -76]
});

L.marker([ 46.049767, 14.508955 ], {icon: zogaIcon}).addTo(map).bindPopup("INFO o EVENTU");
L.marker([ 46.054391, 14.498473 ], {icon: zogaIcon}).addTo(map).bindPopup("INFO o EVENTU");
L.marker([ 46.049670, 14.498998 ], {icon: dramaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.052205, 14.499940 ], {icon: dramaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.055585, 14.504166 ], {icon: muzikaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.053015, 14.503629 ], {icon: muzikaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.050424, 14.502642 ], {icon: muzikaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.061050, 14.508992 ], {icon: muzikaIcon}).addTo(map).bindPopup("INFO O EVENTU");
L.marker([ 46.049903, 14.502405 ], {icon: kulturnaIcon}).addTo(map).bindPopup("INFO O EVENTU");

/**
 var sidebar = L.control.sidebar({
  position: 'left',
  closeButton: true,
  container: 'sidebar'
}).addTo(map);

function openNav() {
  sidebar.style.width = "250px";
  button.style.width = "0";
};
 */
button.addEventListener("click", openNav);
function openNav() {
  sidebar.style.width = "250px";
  button.style.width = "0";
  sidebar.className = "leaflet-top leaflet-left"

};

/**
var panelGlasba = {
  id: 'glasba',                     // UID, used to access the panel
  tab: '<i class="fa fa-music"></i>',  // content can be passed as HTML string,
  title: 'Glasba',              // an optional pane header
};
sidebar.addPanel(panelGlasba);


var panelSport = {
  id: 'sport',                     // UID, used to access the panel
  tab: '<i class="fa fa-ball"></i>',  // content can be passed as HTML string,
  title: 'Šport',              // an optional pane header
};


//L.control.BootstrapDropdowns({position: "toplft", className: "menu"}).addTo(map);

L.control.BootstrapDropdowns({
  position: "topleft",
  className: "menu",
  menuItems: [
      {
          html: '<i class="fas fa-map-marked-alt"></i> Open Street Map',
          title: "Open Street Map",
          current: true,  // current page
      },
      {
          html: '<i class="fas fa-exclamation-triangle"></i> Open Alert',
          title: "Open Alert",
          afterClick: () => {  // callback
              alert("Open Alert!");
          },
      },
      {
          html: '<i class="fas fa-external-link-square-alt"></i> Leaflet.SimpleLocate',
          title: "leaflet-simple-locate",
          href: "https://github.com/mfhsieh/leaflet-simple-locate/",  // href with target
          target: "_blank",
      },
      {
          separator: true,  // separator
      },
      {
          html: '<i class="fab fa-github"></i> About',
          title: "About",
          href: "https://github.com/mfhsieh/leaflet-bootstrap-dropdowns",  // href without target
      }
  ],
}).addTo(map);
 */




