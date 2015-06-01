<?php
function getFullMap($conn){
/* Javascript taken from the Blackboard link example
and edited to suit.*/

	
// This example creates a simple polygon representing the Bermuda Triangle.
// When the user clicks on the polygon an info window opens, showing
// information about the polygon's coordinates.
$js = '
<script type="text/javascript">
var map;
var infoWindow;

function initialize() {
  var mapOptions = {
    zoom: 6,
	scrollwheel: false,
    center: new google.maps.LatLng(57,-4.064941),
  };

  var bermudaTriangle;

  map = new google.maps.Map(document.getElementById("map"),
      mapOptions);

  // Define the LatLng coordinates for the polygon.
  var lowland = [
			new google.maps.LatLng(54.876607,-3.449707),
			new google.maps.LatLng(55.222757,-2.647705),
			new google.maps.LatLng(55.453941,-2.186279),
			new google.maps.LatLng(55.652798,-2.307129),
			new google.maps.LatLng(55.813629,-2.065430),
			new google.maps.LatLng(55.918430,-2.175293),
			new google.maps.LatLng(55.961501,-2.449951),
			new google.maps.LatLng(56.029087,-2.614746),
			new google.maps.LatLng(56.065903,-2.779541),
			new google.maps.LatLng(56.016808,-2.944336),
			new google.maps.LatLng(55.973798,-3.153076),
			new google.maps.LatLng(56.004524,-3.537598),
			new google.maps.LatLng(56.016808,-3.735352),
			new google.maps.LatLng(56.035226,-3.625488),
			new google.maps.LatLng(56.035226,-3.471680),
			new google.maps.LatLng(56.035226,-3.372803),
			new google.maps.LatLng(56.065903,-3.218994),
			new google.maps.LatLng(56.121060,-3.175049),
			new google.maps.LatLng(56.200593,-2.988281),
			new google.maps.LatLng(56.188368,-2.867432),
			new google.maps.LatLng(56.273861,-2.581787),
			new google.maps.LatLng(56.322629,-2.680664),
			new google.maps.LatLng(56.353078,-2.834473),
			new google.maps.LatLng(56.407823,-2.823486),
			new google.maps.LatLng(56.432130,-2.999268),
			new google.maps.LatLng(56.395664,-3.153076),
			new google.maps.LatLng(56.365250,-3.526611),
			new google.maps.LatLng(56.261660,-3.801270),
			new google.maps.LatLng(56.182254,-3.999023),
			new google.maps.LatLng(56.133307,-4.207764),
			new google.maps.LatLng(56.041363,-4.482422),
			new google.maps.LatLng(55.949200,-4.614258),
			new google.maps.LatLng(55.943048,-4.844971),
			new google.maps.LatLng(55.807456,-4.910889),
			new google.maps.LatLng(55.708545,-4.877930),
			new google.maps.LatLng(55.547281,-4.658203),
			new google.maps.LatLng(55.503750,-4.592285),
			new google.maps.LatLng(55.422779,-4.702148),
			new google.maps.LatLng(55.329144,-4.822998),
			new google.maps.LatLng(55.216490,-4.888916),
			new google.maps.LatLng(55.116085,-4.976807),
			new google.maps.LatLng(55.053203,-5.053711),
			new google.maps.LatLng(54.990222,-5.152588),
			new google.maps.LatLng(54.920828,-5.218506),
			new google.maps.LatLng(54.807017,-5.130615),
			new google.maps.LatLng(54.724620,-5.020752),
			new google.maps.LatLng(54.635697,-4.943848),
			new google.maps.LatLng(54.635697,-4.888916),
			new google.maps.LatLng(54.680183,-4.866943),
			new google.maps.LatLng(54.781682,-4.921875),
			new google.maps.LatLng(54.826008,-4.932861),
			new google.maps.LatLng(54.851315,-4.866943),
			new google.maps.LatLng(54.819679,-4.768066),
			new google.maps.LatLng(54.788017,-4.680176),
			new google.maps.LatLng(54.724620,-4.570313),
			new google.maps.LatLng(54.680183,-4.427490),
			new google.maps.LatLng(54.699234,-4.361572),
			new google.maps.LatLng(54.756331,-4.339600),
			new google.maps.LatLng(54.826008,-4.350586),
			new google.maps.LatLng(54.889246,-4.416504),
			new google.maps.LatLng(54.844990,-4.306641),
			new google.maps.LatLng(54.800685,-4.218750),
			new google.maps.LatLng(54.769009,-4.086914),
			new google.maps.LatLng(54.788017,-3.911133),
			new google.maps.LatLng(54.851315,-3.801270),
			new google.maps.LatLng(54.863963,-3.658447),
			new google.maps.LatLng(54.876607,-3.471680)
  ];
  
  var speyside = [
			new google.maps.LatLng(57.615992,-3.834229),
			new google.maps.LatLng(57.674786,-3.636475),
			new google.maps.LatLng(57.727619,-3.427734),
			new google.maps.LatLng(57.727619,-3.273926),
			new google.maps.LatLng(57.674786,-3.120117),
			new google.maps.LatLng(57.674786,-2.999268),
			new google.maps.LatLng(57.715885,-2.889404),
			new google.maps.LatLng(57.692406,-2.713623),
			new google.maps.LatLng(57.674786,-2.526855),
			new google.maps.LatLng(57.668911,-2.416992),
			new google.maps.LatLng(57.704147,-2.340088),
			new google.maps.LatLng(57.680660,-2.219238),
			new google.maps.LatLng(57.504020,-2.438965),
			new google.maps.LatLng(57.468589,-2.691650),
			new google.maps.LatLng(57.433124,-3.142090),
			new google.maps.LatLng(57.397624,-3.427734),
			new google.maps.LatLng(57.444949,-3.636475),
			new google.maps.LatLng(57.521723,-3.867188),
			new google.maps.LatLng(57.627758,-3.867188)
];

var campbeltown = [
			new google.maps.LatLng(56.010666,-5.449219),
			new google.maps.LatLng(56.029087,-5.657959),
			new google.maps.LatLng(55.936895,-5.723877),
			new google.maps.LatLng(55.875311,-5.679932),
			new google.maps.LatLng(55.801281,-5.679932),
			new google.maps.LatLng(55.658996,-5.701904),
			new google.maps.LatLng(55.572134,-5.767822),
			new google.maps.LatLng(55.447711,-5.789795),
			new google.maps.LatLng(55.379110,-5.822754),
			new google.maps.LatLng(55.291628,-5.789795),
			new google.maps.LatLng(55.291628,-5.690918),
			new google.maps.LatLng(55.310391,-5.614014),
			new google.maps.LatLng(55.372868,-5.537109),
			new google.maps.LatLng(55.429013,-5.526123),
			new google.maps.LatLng(55.522412,-5.537109),
			new google.maps.LatLng(55.609384,-5.471191),
			new google.maps.LatLng(55.720923,-5.405273),
			new google.maps.LatLng(55.758032,-5.328369),
			new google.maps.LatLng(55.844482,-5.361328),
			new google.maps.LatLng(55.998381,-5.427246)
];

var island = [
		new google.maps.LatLng(58.711189,-3.142090),
		new google.maps.LatLng(58.642653,-2.878418),
		new google.maps.LatLng(58.711189,-2.680664),
		new google.maps.LatLng(58.972667,-2.526855),
		new google.maps.LatLng(59.209688,-2.175293),
		new google.maps.LatLng(59.456243,-2.197266),
		new google.maps.LatLng(59.500880,-2.724609),
		new google.maps.LatLng(59.445075,-3.251953),
		new google.maps.LatLng(59.310768,-4.130859),
		new google.maps.LatLng(59.119588,-4.702148),
		new google.maps.LatLng(58.983991,-5.251465),
		new google.maps.LatLng(58.836490,-5.910645),
		new google.maps.LatLng(58.665513,-6.416016),
		new google.maps.LatLng(58.516652,-6.965332),
		new google.maps.LatLng(58.205450,-7.250977),
		new google.maps.LatLng(58.031372,-7.470703),
		new google.maps.LatLng(57.786233,-7.646484),
		new google.maps.LatLng(57.539417,-7.888184),
		new google.maps.LatLng(57.028774,-7.910156),
		new google.maps.LatLng(56.498892,-7.624512),
		new google.maps.LatLng(56.304349,-7.338867),
		new google.maps.LatLng(56.170023,-7.185059),
		new google.maps.LatLng(55.801281,-7.009277),
		new google.maps.LatLng(55.441479,-6.547852),
		new google.maps.LatLng(55.441479,-6.306152),
		new google.maps.LatLng(55.291628,-5.998535),
		new google.maps.LatLng(55.141210,-5.822754),
		new google.maps.LatLng(55.015426,-5.581055),
		new google.maps.LatLng(55.090944,-5.339355),
		new google.maps.LatLng(55.254077,-5.119629),
		new google.maps.LatLng(55.516192,-4.877930),
		new google.maps.LatLng(55.689972,-5.075684),
		new google.maps.LatLng(55.751849,-5.339355),
		new google.maps.LatLng(55.553495,-5.449219),
		new google.maps.LatLng(55.391592,-5.361328),
		new google.maps.LatLng(55.254077,-5.471191),
		new google.maps.LatLng(55.191412,-5.603027),
		new google.maps.LatLng(55.241552,-5.888672),
		new google.maps.LatLng(55.391592,-5.976563),
		new google.maps.LatLng(55.603178,-5.954590),
		new google.maps.LatLng(55.788929,-5.844727),
		new google.maps.LatLng(55.924586,-5.800781),
		new google.maps.LatLng(56.121060,-5.756836),
		new google.maps.LatLng(56.304349,-5.756836),
		new google.maps.LatLng(56.401744,-5.668945),
		new google.maps.LatLng(56.511018,-5.734863),
		new google.maps.LatLng(56.547372,-5.954590),
		new google.maps.LatLng(56.692442,-6.130371),
		new google.maps.LatLng(56.824933,-6.196289),
		new google.maps.LatLng(57.040730,-5.954590),
		new google.maps.LatLng(57.160078,-5.734863),
		new google.maps.LatLng(57.279043,-5.690918),
		new google.maps.LatLng(57.373938,-5.778809),
		new google.maps.LatLng(57.421294,-5.954590),
		new google.maps.LatLng(57.657158,-6.020508),
		new google.maps.LatLng(57.833055,-6.086426),
		new google.maps.LatLng(58.031372,-6.174316),
		new google.maps.LatLng(58.424730,-5.625000),
		new google.maps.LatLng(58.665513,-5.339355),
		new google.maps.LatLng(58.768200,-4.921875),
		new google.maps.LatLng(58.756805,-4.196777),
		new google.maps.LatLng(58.722599,-3.208008)
];

  // Construct the Lowland polygon.
  lowlandPoly = new google.maps.Polygon({
    paths: lowland,
    strokeWeight: 0,
    fillColor: "#066700",
    fillOpacity: 0.5,
	zIndex: "0"
  });
  
    // Construct the Speyside polygon.
  speysidePoly = new google.maps.Polygon({
    paths: speyside,
    strokeWeight: 0,
    fillColor: "#9d8231",
    fillOpacity: 0.5
  });
  
   // Construct the Campbeltown polygon.
  campbeltownPoly = new google.maps.Polygon({
    paths: campbeltown,
    strokeWeight: 0,
    fillColor: "#8560a8",
    fillOpacity: 0.5
  });
  
  // Construct the Island polygon.
  islandPoly = new google.maps.Polygon({
    paths: island,
    strokeWeight: 0,
    fillColor: "#0076a3",
    fillOpacity: 0.5
  });'.
  

	getAllMarkers($conn)


  .'lowlandPoly.setMap(map);
  speysidePoly.setMap(map);
  campbeltownPoly.setMap(map);
  islandPoly.setMap(map);
  
//Make each polygon shape a link
google.maps.event.addListener(lowlandPoly, "click", function() {
    window.location.href = "index.php?region=Lowlands";
});

google.maps.event.addListener(speysidePoly, "click", function() {
    window.location.href = "index.php?region=Speyside";
});

google.maps.event.addListener(campbeltownPoly, "click", function() {
    window.location.href = "index.php?region=Campbeltown";
});

google.maps.event.addListener(islandPoly, "click", function() {
    window.location.href = "index.php?region=Island";
});

}


google.maps.event.addDomListener(window, "load", initialize);

</script>';

echo $js;

}

?>