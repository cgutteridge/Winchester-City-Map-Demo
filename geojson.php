<?php
$datasets = array(
	"Wikipedia"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=0",
	"FHRS"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=946748053",
	"Benches"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=129236089",
	"Plaques"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=332099573",
	"Postcodes"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=2444680",
	"Crime"=>"https://docs.google.com/spreadsheets/d/1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM/export?format=tsv&id=1p36UJLKm3ola-mRQchV4yEKTqGtqVpIwmQpvfiyo4jM&gid=383446051" 
);

$tsv = file_get_contents( $datasets[$_GET["id"]] );
$lines = preg_split( "/\n/", $tsv );
$headings = preg_split( "/\t/", array_shift( $lines ));
$features = array();
foreach( $lines as $line ) {
	$record = array();
	$cells = preg_split( "/\t/", $line );
	for( $i=0; $i<count($headings); ++$i ) {
		$record[$headings[$i]] = $cells[$i];
	}
	if( !isset( $record["latitude"] ) ) { continue; }
	if( !isset( $record["longitude"] ) ) { continue; }
	if( !isset( $record["label"] ) ) { continue; }
	$feature = array( 
		"type"=>"Feature",
		"properties"=>$record,	
		"geometry"=>array(
        		"type"=> "Point",
        		"coordinates"=>array( $record["longitude"], $record["latitude"] )
		)
	);
	$features []= $feature;
}
$collection = array( 
	"type"=>"FeatureCollection",
	"features"=>$features
);
header( "Content-type: application/vnd.geo+json" );
print json_encode( $collection );
