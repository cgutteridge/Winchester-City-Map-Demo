<?php
$sets = preg_split( "/,/", preg_replace( "/[^A-Za-z0-9,]/","",$_GET['sets']));

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
.popup-title {
	font-size: 120%;
	font-weight: bold;
}
.popup-table th {
	vertical-align:top;
	text-align: right
}
.picMarker {
	border: solid 1px black;
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
var options = {
    pointToLayer: function (feature, latlng) {
        var url = "";
        if( feature["properties"] && feature["properties"]["depiction"] ) {
		url = feature["properties"]["depiction"];
		var myIcon = L.icon({
    			iconUrl: url,
    			iconSize: [100, 66],
    			iconAnchor: [50, 33],
    			popupAnchor: [0, -33],
    			shadowSize: [68, 95],
    			shadowAnchor: [22, 94],
			className: "picMarker"
		});
        	return L.marker(latlng, {icon: myIcon} );
	} else {
	        return L.circleMarker(latlng, geojsonMarkerOptions);
	}
    },
    onEachFeature: function(feature, layer) {
	var popupHtml = "";
	popupHtml += "<div class='popup-title'>"+feature.properties.label+"</div>";
	popupHtml += "<table class='popup-table'>";
	if( feature.properties['depiction'] ) {
		popupHtml += "<img src='"+feature.properties.depiction+"' style='width:100%' />";
	}
	var terms = Object.keys( feature.properties ).sort();
	//alert( JSON.stringify( terms ));	
	for( var i=0;i<terms.length;++i ) {
		var term = terms[i];
		var value = feature.properties[term];
		term = term.trim();
		if( value != "" ) {
			if( term == "copyrightURL" || term == "homepage" || term == "depiction" || term == "wikipediaPage" ) {
				value = "<a href='"+value+"'>"+value+"</a>";
			}
			popupHtml+="<tr><th>"+term+":</th><td>"+value+"</td></tr>";
		}
	}
	popupHtml += "</table>";
	if( feature.properties['copyrightText'] ) {
		var copyright = feature.properties['copyrightText'];
		if( feature.properties['copyrightURL'] ) {
			copyright = "<a href='"+feature.properties['copyrightURL']+"'>"+copyright+"</a>";
		}
		popupHtml+="<p>&copy; "+copyright+"</p>";
	}
       	layer.bindPopup(popupHtml,  { maxWidth : 500 });
    }
};
//new L.GeoJSON.AJAX("geojson.php?id=Plaques",options ).addTo(map);
//new L.GeoJSON.AJAX("geojson.php?id=Benches",options ).addTo(map);
//new L.GeoJSON.AJAX("geojson.php?id=Crime",options ).addTo(map);

map.fitBounds([
	[51.10719,-1.39286],
	[51.03772,-1.26411]
]);
<?php
foreach( $sets as $set ) {
	print "new L.GeoJSON.AJAX(\"geojson.php?id=$set\",options ).addTo(map);\n";
}
?>
</script>

</body></html>



