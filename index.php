<?php 
require_once 'config.php';
require_once "libraries/koneksi.php";
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> saya remove ini untuk responsive--> 

    <title>GIS</title><!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="custom.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="js/themes/default/style.css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=drawing,geometry"></script>-->
    <script type="text/javascript" src="petax.js"></script>
	<script type="text/javascript" src="GeoJSON.js"></script>
    <script type="text/javascript" src="jquerylatest.js"></script>
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
    <script type="text/javascript" src="js/jstree.min.js"></script>
    <script type="text/javascript" src="js/drag.js"></script>
    <!--<script type="text/javascript" src="js/jquery.jstree.js"></script>-->
	<script type="text/javascript">
	

		var map;   //var map
		var request_in_process = false;  //var
		var polygoncolor="",Strokecolor="",iconimage, feature_index=0; //var
		//inisialisasi awal 

		currentFeature_or_Features =new Array();  //array currentFeature
		newpolyline=new Array();  //array newpolyline
		var newpolygon="",newmarker="";  //var newpoligon , newmarker
		var roadStyle = {   //var untuk style road
			strokeColor: "#FFFF00",
			strokeWeight: 7,
			strokeOpacity: 0.75
		};
		
		var addressStyle = {   //var untuk style alamat
			icon: "img/marker-house.png"
		}; 
		
		var parcelStyle = {    //var  untuk style parcel
			animation: google.maps.Animation.DROP,  
			icon: "img/marker-house.png", 	
			//end marker style
			
			strokeColor: "#FF7800",
			strokeOpacity: 1,
			strokeWeight: 2,
			fillColor: "#46461F",
			fillOpacity: 1
		};
		
		var infowindow = new google.maps.InfoWindow();  //class infowindow
		
		var drawingManager; //drawingmanager global variabel
		
		var newShape; //UNTUK MENYIMPAN hasil drawing yang baru dibuat kemudian memasukkan event
      	
		var all_overlays = [];

		//INISIALISASI AWAL LAGI UNTUK VARIABLE JAVASCRIPT 


		function deleteAllShape() {
        for (var i=0; i < all_overlays.length; i++)
        {
          all_overlays[i].overlay.setMap(null);
        }
        all_overlays = [];
      }
		//fungsi delete all shape
		
		function drop_satusatu(nama_marker, i) {
    setTimeout(function() {
		nama_marker.setMap(map);
		nama_marker.setAnimation(google.maps.Animation.DROP);
    	}, i * 15); //Interval time ubah aja disini
	}
	//fungsi drop satu satu 
		
		function init(){
			map = new google.maps.Map(document.getElementById('map'),{
				zoom: 7,
				center: new google.maps.LatLng(-8.700499129275814, 116.795654296875),
				minZoom: 7,
				panControl: true,
				panControlOptions: {
				  position: google.maps.ControlPosition.TOP_RIGHT
				},
				zoomControl: true,
				zoomControlOptions: {
				  style: google.maps.ZoomControlStyle.LARGE,
				  position: google.maps.ControlPosition.TOP_RIGHT
				}
			});
			
		// Batas bali yang bisa diliat (South West , North East)
		allowedBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(-11.383109216353258, 113.88427734375), 
		new google.maps.LatLng(-7.2425975109493255, 125.33203125)
		);
		
		google.maps.event.addListener(map, "center_changed", function() {
		if (allowedBounds.contains(map.getCenter())) return;

		// Kalo keluar batas yang ditetepin
		var c = map.getCenter(),
        x = c.lng(),
        y = c.lat(),
        maxX = allowedBounds.getNorthEast().lng(),
        maxY = allowedBounds.getNorthEast().lat(),
        minX = allowedBounds.getSouthWest().lng(),
        minY = allowedBounds.getSouthWest().lat();

		if (x < minX) x = minX;
		if (x > maxX) x = maxX;
		if (y < minY) y = minY;
		if (y > maxY) y = maxY;

		map.setCenter(new google.maps.LatLng(y, x));
		});
			
		/*google.maps.event.addListener(map,'click',function(event) {
		document.getElementById('latlongclicked').innerHTML = event.latLng.lat() + ', ' + event.latLng.lng()
		})*/

		google.maps.event.addListener(map,'mousemove',function(event) {
	/*	document.getElementById('latspan').innerHTML = event.latLng.lat()
		document.getElementById('lngspan').innerHTML = event.latLng.lng()*/
		document.getElementById('latlong').innerHTML = event.latLng.lat().toFixed(5) + ', ' + event.latLng.lng().toFixed(5)
		});	
			
		/*var geodesic = new google.maps.Polyline({geodesic: true});*/
		
		drawingManager = new google.maps.drawing.DrawingManager({
			drawingMode: null,
			drawingControl: false,
			drawingControlOptions: {
			  position: google.maps.ControlPosition.TOP_CENTER,
			  drawingModes: [
				google.maps.drawing.OverlayType.MARKER,
				google.maps.drawing.OverlayType.CIRCLE,
				google.maps.drawing.OverlayType.POLYGON,
				google.maps.drawing.OverlayType.POLYLINE,
				google.maps.drawing.OverlayType.RECTANGLE
			  ]
			},
			markerOptions: {
			 /* icon: 'img/marker-house.png',*/
			  animation: google.maps.Animation.DROP
			},
			polylineOptions:{
				strokeColor: "#FF0000",
				strokeOpacity: 0.6,
				strokeWeight: 3,
				clickable: true,
				editable: true
				},
			polygonOptions:{
				fillColor:'#5DE044',
				strokeColor:'#009B0C',
				fillOpacity:0.6,
				clickable: true,
				editable: true
				},
			rectangleOptions:{
				fillColor:'#7ED2FF',
				strokeColor:'#0092E0',
				fillOpacity:0.6,
				clickable: true,
				editable: true
				},
			circleOptions: {
			  fillColor: '#ffff00',
			  fillOpacity: 0.7,
			  strokeWeight: 3,
			  clickable: false,
			  editable: true,
			  zIndex: 1
			}
		  });
  		drawingManager.setMap(map);
		
		google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
 		 all_overlays.push(event);
		 if (event.type == google.maps.drawing.OverlayType.CIRCLE) {
    	var radius = event.overlay.getRadius();
		document.getElementById('result').innerHTML=((3.1415927*Math.pow(radius,2))/1000000).toPrecision(7)+"km<sup>2<\/sup>";
 		 
		 newShape = event.overlay;
        newShape.type = event.type;
		 
		 google.maps.event.addListener(newShape, 'radius_changed', function(){
		radius = event.overlay.getRadius();
		document.getElementById('result').innerHTML=((3.1415927*Math.pow(radius,2))/1000000).toPrecision(7)+"km<sup>2<\/sup>";
		  });
		 
		 }
		 
		 else if (event.type == google.maps.drawing.OverlayType.POLYLINE) {
    	var coordinate = event.overlay.getPath();
		
		var panjang=google.maps.geometry.spherical.computeLength(coordinate);
		//alert(panjang);
		document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
		
 		 
		 
		 newShape = event.overlay;
         newShape.type = event.type;
		 
		var path = newShape.getPath();
		google.maps.event.addListener(path, 'insert_at', function(){
		//coordinate = newShape.getPath();
		panjang=google.maps.geometry.spherical.computeLength(coordinate);
		//alert(panjang);
		document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
		}); 
		google.maps.event.addListener(path, 'remove_at', function(){
		//coordinate = newShape.getPath();
		panjang=google.maps.geometry.spherical.computeLength(coordinate);
		//alert(panjang);
		document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
		}); 
		google.maps.event.addListener(path, 'set_at', function(){
		//coordinate = newShape.getPath();
		panjang=google.maps.geometry.spherical.computeLength(coordinate);
		//alert(panjang);
		document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
		}); 
		 
		 }
		else if (event.type == google.maps.drawing.OverlayType.RECTANGLE) {
    	var coordinate = event.overlay.getBounds();
		
		var sw = coordinate.getSouthWest();
  		var ne = coordinate.getNorthEast();
	  var southWest = new google.maps.LatLng(sw.lat(), sw.lng());
	  var northEast = new google.maps.LatLng(ne.lat(), ne.lng());
	  var southEast = new google.maps.LatLng(sw.lat(), ne.lng());
	  var northWest = new google.maps.LatLng(ne.lat(), sw.lng());
	  var hasil= google.maps.geometry.spherical.computeArea([northEast, northWest, southWest, southEast]);

		//alert(coordinate);
		
		document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		
		newShape = event.overlay;
        newShape.type = event.type;
		
		google.maps.event.addListener(newShape, 'bounds_changed', function(){
			// Point was removed
			var coordinate = event.overlay.getBounds();
		
		var sw = coordinate.getSouthWest();
  		var ne = coordinate.getNorthEast();
	  	var southWest = new google.maps.LatLng(sw.lat(), sw.lng());
	  	var northEast = new google.maps.LatLng(ne.lat(), ne.lng());
	 	var southEast = new google.maps.LatLng(sw.lat(), ne.lng());
	  	var northWest = new google.maps.LatLng(ne.lat(), sw.lng());
	  	var hasil= google.maps.geometry.spherical.computeArea([northEast, northWest, southWest, southEast]);
	  
			document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		  });
		
 		 
		 }
		 
		 else if (event.type == google.maps.drawing.OverlayType.POLYGON) {
    	var coordinate = event.overlay.getPath();
		
	  	var hasil= google.maps.geometry.spherical.computeArea(coordinate);

		//alert(coordinate);
		document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		 
		 newShape = event.overlay;
         newShape.type = event.type;
				
		newShape.getPaths().forEach(function(path, index){
		
		  google.maps.event.addListener(path, 'insert_at', function(){
			// New point
			//alert("ASEEKKKKKKK");
			hasil= google.maps.geometry.spherical.computeArea(coordinate);
			document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		  });
		
		  google.maps.event.addListener(path, 'remove_at', function(){
			// Point was removed
			hasil= google.maps.geometry.spherical.computeArea(coordinate);
			document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		  });
		
		  google.maps.event.addListener(path, 'set_at', function(){
			// Point was moved
			hasil= google.maps.geometry.spherical.computeArea(coordinate);
			document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		  });
		
		});
		 }
		
		});
		
		//google.maps.event.addListener(drawingManager, 'drawingmode_changed', alert('daaamnnnnn'));
		
		//google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
        google.maps.event.addDomListener(document.getElementById('clearOverlay'), 'click', deleteAllShape);
		
		/*google.maps.event.addDomListener(document.getElementById('polygon'), 'click', drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON));*/
	
		//drawingManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE)
		}//end function initialize
		
		function drawCircle(){
		drawingManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
		}
		function drawPolygon(){
		drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
		}
		function drawPolyline(){
		drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYLINE);
		}
		function drawRectangle(){
		drawingManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
		}
		function drawMarker(){
		drawingManager.setDrawingMode(google.maps.drawing.OverlayType.MARKER);
		}
		function handTool(){
		drawingManager.setDrawingMode(null);
		}
			
		
		
		function clearMap(){
			//alert("clear");
			if (!currentFeature_or_Features)
				return;
			if (currentFeature_or_Features.length){
				for (var i = 0; i < currentFeature_or_Features.length; i++){
					if(currentFeature_or_Features[i].length){
						for(var j = 0; j < currentFeature_or_Features[i].length; j++){
							
							if(currentFeature_or_Features[i][j].length){
								for(var k = 0; k < currentFeature_or_Features[i][j].length; k++){
									currentFeature_or_Features[i][j][k].setMap(null);
									}
								}
							else{
							currentFeature_or_Features[i][j].setMap(null);
							}
						}
					}
					else{
						currentFeature_or_Features[i].setMap(null);
					}
				}
			}else{
				console.log(currentFeature_or_Features.length);
				//currentFeature_or_Features.setMap(null);
			}
			if (infowindow.getMap()){
				infowindow.close();
			}					
		
		}
		
		//start fungsi ini ga dipake kyaknya
		function showFeature(geojson, style){
			clearMap();
			
			//layerto
			currentFeature_or_Features = new GeoJSON(geojson, style || null);
			if (currentFeature_or_Features.type && currentFeature_or_Features.type == "Error"){
				document.getElementById("put_geojson_string_here").value = currentFeature_or_Features.message;
				return;
			}
			if (currentFeature_or_Features.length){
				for (var i = 0; i < currentFeature_or_Features.length; i++){
					if(currentFeature_or_Features[i].length){
						for(var j = 0; j < currentFeature_or_Features[i].length; j++){
							currentFeature_or_Features[i][j].setMap(map);
							if(currentFeature_or_Features[i][j].geojsonProperties) {
								setInfoWindow(currentFeature_or_Features[i][j]);
							}
						}
					}
					else{
						currentFeature_or_Features[i].setMap(map);
					}
					if (currentFeature_or_Features[i].geojsonProperties) {
						setInfoWindow(currentFeature_or_Features[i]);
					}
				}
			}else{
				currentFeature_or_Features.setMap(map)
				if (currentFeature_or_Features.geojsonProperties) {
					setInfoWindow(currentFeature_or_Features);
				}
			}
			
			document.getElementById("put_geojson_string_here").value = JSON.stringify(geojson);
		}
		//end fungsi ini ga dipake kyaknya
		
		
		var json;
		
		$(document).ready(function() {
		$('div#legend-bar').drags(); //legend draggable	
		// harus dibuat hanya setelah di klik kalo ini akan dieksekusi saat window load
		//$('#minimize-layer-selector').show();
		$('#minimize-layer-selector').click(function(e) {
            $('#layer-selector').toggle("fast",function(){
				$( "#minimize-layer-selector>span" ).toggleClass( "glyphicon-minus glyphicon-plus" )
				
				});
        });
			$('#layer-selector').jstree({
				'plugins' : ['themes', 'checkbox', 'types'],
				'checkbox' : {
				  'three_state' : false, // Nessesary to disable default checking
				  "cascade":"undetermined",
				  "whole_node":false,
				  "keep_selected_style" : false,
				  /* "tie_selection":false*/
				},
				
			  });
		//$('#layer-selector').jstree.disable_node("#node5");
				
				var layer_selected=new Array();
				var layer_displayed=new Array();
				//var	temp_polygon=[], temp_polyline=[], temp_marker=[];
				//var	clear_polygon=[], clear_polyline=[], clear_marker=[];
				var i, j, r = [];
				
				$('#layer-selector').on('changed.jstree', function (e, data) {
					
					//if(true) return;
					layer_selected=$("#layer-selector").jstree('get_checked');
					console.log("tree changed "+layer_selected);
				
					if(data.selected.length){
					var check=data.instance.get_node(data.selected[0]).id.split("_")[1];
					
					if(check!='polygon' && check!='marker' && check!='polyline'){
    				//console.log("found");
					return true;
					}
					}
					
				
				
				if(layer_selected.length<layer_displayed.length){
					clearMap();
					currentFeature_or_Features.length=0;
					currentFeature_or_Features=[];
					$( "div#legend-container" ).html("");
					
					for(i = 0, j = data.selected.length; i < j; i++) {
					 
					 r = data.instance.get_node(data.selected[i]).id.split("_");
						if(r[1]=='polygon' || r[1]=='polyline' || r[1]=='marker'){
							
							layer_displayed.push(data.instance.get_node(data.selected[i]).id);
							showLayer(r[0],r[1]);
							
							showLegend(r[0],r[1]);
							
							console.log('showLayer('+r[0]+','+r[1]+')');
							}
						
						}
					
					
					
					}
				else if(layer_selected.length>layer_displayed.length){
					var diff;
					
					jQuery.grep(layer_selected, function(el) {
        			if (jQuery.inArray(el, layer_displayed) == -1) diff=el;
					});
					//clearMap();
					layer_displayed.push(diff);
					
					
					showLayer(diff.split("_")[0],diff.split("_")[1]);
					
					showLegend(diff.split("_")[0],diff.split("_")[1]);
					console.log('show_layer: '+diff.split("_")[0]+'_'+ diff.split("_")[1]);
					}
				  });
				   
	/*		$( "select[name=year]" ).change(function() {
			
			$("#layer-selector").jstree('uncheck_all');
			clearMap();
			});*/
			
			function showLayer(layerid,tipe){
							//if (!request_in_process) {
							//request_in_process=true;
								$.ajax({
								  url: "libraries/layer.php",
								  type: "POST",
								  statusCode: {
										404: function() {
										  alert( "page not found" );
										}
									},
								  data: {/*tahun:$( "select[name=year]" ).val(),*/kategori:tipe,id:layerid},
								  dataType: "json",
								})
								.always(function( html ) {
								//alert('on process...'+html);
								})
								.done(function(data) { 	console.log(data);
								  if(data[0]){
								  var legend="";var color="";var legendfield="";var style="";var icon="";var tipe="";//inisialisasi awal
								  if(data[6]=='polygon'){
									  legend=data[3];
									  color=data[4];
									  legendfield=data[7];
									  tipe="polygon";
								  }
								  else if(data[6]=='polyline'){
									  legend=data[3];
									  color=data[4];
									  tipe="polyline";
								  }
								  else if (data[6]=='marker'){
									tipe="marker";
									legendfield=data[7];
									legend = data[3];
									icon = data[1];
								  }
								  
	
										 $.get(data[0], function(respons) { //sebelumny data[0] digati layer[index]
										})
										.done(function(respons) {
									
										rawGeoJSON(respons,legend,color,legendfield,icon,tipe); //respons, icon, legend color,style,tipe
										 })
										.fail(function() {
										alert( "Maknyooss error" );
									  })
								  }
								  else{
								  alert("Maaf data tidak tersedia, silahkan kontak admin untuk info yang lebih detail");
								  //hilangkan checkbox yg di check jika file tidak ada 
								  //$("#layer-selector").jstree('uncheck_all');
								  //clearMap(); //untuk jaga2 
								  }
								})
								.fail(function( jqXHR, textStatus ) {
								  alert( "Request failed: " + textStatus );
								});	
							//}
						}
								
			});


	</script>

    <script type="text/javascript" src="js/rawjson.js"></script>
    <script type="text/javascript" src="js/legend.js"></script>
    <!-- Favicons -->
	<link rel="icon" href="images/faveicon.png">
</head>

<body onload="init();">
<div class="printArea">
	
	
	<div class="print printlogo">
        <div class="row">
            <center>
                <div class="col-md-5">
                	<img src="img/logo.png" id="logo" width="50px" height="50px">
                	<h2>PPE BALI NUSRA</h2>
                </div>
            </center>
        </div><br>
    </div>
    
    <div id="mapPrint">
    </div>
    
    
    
    
</div>

    <header>
        <div class="container absolute-center">
            <div class="row">
                <div class="col-md-4">
                	<div class="logo"><img src="images/logo-gis.png" alt="logo-gis"></div>
                </div>

                <div class="col-md-8 header-kanan">
                	<div class="row"><div class="col-md-12" style="margin-top: 0;">
		                       
		                       
		                    <div class="row">
		                    
			                    <div class="col-md-8">
				                    <div class="toolbar-atas toolbar-options">
				                    
				                    <div class="alert alert-info" role="alert">
				                    <div><strong>Tools:</strong></div>
				                    <div>
					                    <button type="button" title="Move Tool" id="" onclick="handTool()" class="btn btn-default btn-lg" data-placement="bottom">
		                      <!-- handtool --><span class="glyphicon glyphicon-move"></span></button>
		                        <button type="button" title="Put Marker" id="" onclick="drawMarker()" class="btn btn-default btn-lg">
		                       <!-- drop pin location --><span class="glyphicon glyphicon-map-marker"></span></button>
		                        
                                <button type="button" title="Draw Circle" id="" onclick="drawCircle()"  class="btn btn-default btn-lg">
		                      <!-- draw circle --><span class="glyphicon glyphicon-record"></span></button>
                              
		                        <button title="Draw Polyline" id="" onclick="drawPolyline()" type="button" class="btn btn-default btn-lg">
		                        <!-- draw line --><span class="glyphicon glyphicon-pencil"></span></button>
		                        
                                <button type="button" title="Draw Rectangle" id="" onclick="drawRectangle()" class="btn btn-default btn-lg">
		                       <!-- draw square --><span class="glyphicon glyphicon-stop"></span></button>
                                   
                                   <button type="button" title="Draw Polygon" id="" onclick="drawPolygon()" class="btn btn-default btn-lg">
		                     <span class="glyphicon glyphicon-th-large"></span></button>
		                       
                                <button id="clearOverlay" title="Clear Drawing" type="button"  class="btn btn-default btn-lg">
		                        <!-- erase -->
		                        
		                        <span class="glyphicon glyphicon-remove"></span></button>
		                        
		                        <button type="button" class="btn btn-default btn-lg" onclick="window.print()">
		                        <span class="glyphicon glyphicon-print"></span>
		                       		                       </button>

					                    
				                    </div>
				                    </div>
				                  
				                    
				                  		                        		                  	
		                        		                  	
	                        </div></div>
			                   
			                    
			                    <div class="col-md-4" style="margin-top:25px; min-height: 83px">
				                    <div class="alert alert-info" role="alert">
				                    <div class="eventtext">
									<div>coordinate: <span id="latlong"></span></div>
									<div id="div-result" class="">Result: <span id="result"></span></div>
								</div>
		                    
</div>
				                    
			                    </div>
			                    
			                <!--     <div class="col-md-2"> -->
			                    <!--
<div class="print">
		                  	<button type="button" class="btn btn-default btn-xs" onclick="window.print()"><span>print</span></button>
		                  </div></div>
-->
			                    
			                  <!--   </div> -->
		                    
		                      </div>
	               
	               
	               </div>
                    </div>
            </div>
        </div>
    </header>

    <div id="map">
		</div>

	</div>
    <div class="container">
    <div id="legend-bar">
    <button type="button" title="Close Legend" id="" onclick="hideLegend()" class="btn btn-default btn-md close-legend">
		                     <span class="glyphicon glyphicon-remove"></span></button>
    
    <div id="judul-legend">Legend</div>
    <div id="legend-container">
    
  <!--  <p class="nama-legend">Dataran Tinggi</p>
    <div class="legend-item-marker">
    <span class="attribut-legend-nama">&gt;100M</span> <span class="" style="">
    <img class="marker-legend-value" src="img/marker-pink.png"></span>
    </div>
 	
    <div class="legend-item">
    <span class="attribut-legend-nama">&gt;200M</span> <span class="attribut-legend-value-polyline" style="background-color:red"></span>
    </div>-->
        
    </div>
    </div>
    
      <div id="side-bar">
   <!-- *-------* -->
				    <a href="#" id="minimize-layer-selector"><span class="glyphicon glyphicon-minus"></span></a>
				    <input type="button" value="Show Legend" onclick="unhideLegend();" class="btn btn-info btn-xs">
				    <div id="layer-selector">
				   
                    <ul id="">
				    <!--   <li data-jstree='{"type":"disabled"}' class="root jstree-no-checkboxes">Tutupan Lahan
				    
				   <ul>
				        <li data-jstree='{"icon":"jstree-default-large jstree-file"}' id="1_polygon"><a href="#">Tutupan lahan Bali</a></li>
				        <li data-jstree='{"icon":"jstree-default-large jstree-file"}' id="2_polygon" ><a href="#">Tutupan lahan Nusteng</a></li>
				      </ul>
				    </li>
				    <li rel="disabled" class="root jstree-no-checkboxes">Mineral
				      <ul>
				        <li data-jstree='{"icon":"jstree-default-large jstree-file"}' id="1_marker">Non Logam</li>
				      </ul>
				    </li>
				      <li rel="disabled" class="root jstree-no-checkboxes">Batas wilayah
				      <ul>
				        <li data-jstree='{"icon":"jstree-default-large jstree-file"}' id="1_polyline">Bali Batas Wilayah</li>
		      </ul>
		    </li>-->
             <?php
					echo
					$select_category=mysql_query("SELECT `category` FROM `categories`");
					while ($category_item=mysql_fetch_array($select_category)){
					echo"<li data-jstree='{\"type\":\"disabled\"}' class=\"root jstree-no-checkboxes\">$category_item[category]<ul>";
					
					$query=mysql_query("(SELECT `title`,`tipe`,`id`,`tahun` FROM `marker` WHERE category='$category_item[category]')
					UNION
					(SELECT `title`,`tipe`,`id`,`tahun` FROM `polygon` WHERE category='$category_item[category]')
					UNION
					(SELECT `title`,`tipe`,`id`,`tahun` FROM `polyline` WHERE category='$category_item[category]')");
					while ($layer_item=mysql_fetch_array($query)){
		echo"<li data-jstree='{\"icon\":\"jstree-default-large jstree-file\"}' id=\"$layer_item[id]_$layer_item[tipe]\"><a href=\"#\">$layer_item[title]-$layer_item[tahun]</a></li>";
						}
					
					echo"</ul></li>";	
					}
					?>
		  </ul>
		 
     
      
      <!-- *------* -->
  </div>
  </div>
    
    </div>

    <div class="footer">
        <div class="container footer-note">
            <p>Copyright &copy; 2014 Pusat Pengelolaan Ekoregion(PPE) Bali Dan Nusa Tenggara Kementerian Lingkungan Hidup</p>
        </div>
    </div>
</body>
</html>