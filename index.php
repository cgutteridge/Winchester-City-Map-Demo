<?php


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Winchester Map</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
  integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
  crossorigin=""></script>
<script src="leaflet.ajax.js"></script>
  <style>
html, body { margin:0; }
#map {
        position: absolute;
        width: 100%;
        height: 100%;
}
  </style>
</head>

<body>
<div id="map"></div>
<script language="JavaScript">
var map = L.map('map',{
  maxZoom:18,
});
L.tileLayer('http://c.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

var geojsonMarkerOptions = {
    radius: 8,
    fillColor: "#ff7800",
    color: "#000",
    weight: 1,
    opacity: 1,
    fillOpacity: 0.8
};

var geojsonLayer = new L.GeoJSON.AJAX("geojson.php?id=Plaques",{
    pointToLayer: function (feature, latlng) {
	var myIcon = L.icon({
    		iconUrl: feature["properties"]["depiction"],
    		iconSize: [100, 66],
    		iconAnchor: [50, 33],
    		popupAnchor: [-3, -76],
    		shadowSize: [68, 95],
    		shadowAnchor: [22, 94]
	});
        return L.marker(latlng, {icon: myIcon} );
    }

});       
geojsonLayer.addTo(map);

map.fitBounds([
	[51.10719,-1.39286],
	[51.03772,-1.26411]
]);


</script>

</body></html>



