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

    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    
    <!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=drawing,geometry"></script>-->
    <script type="text/javascript" src="peta.js"></script> <!-- GIS API-->
	<script type="text/javascript" src="GeoJSON.js"></script> <!-- Script Geojson conversion untuk meletakkan konveri dari list geojson ke peta  -->
    <script type="text/javascript" src="jquerylatest.js"></script> <!-- latest jquery , yakni jqury yang terbaru -->
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>-->
    <script type="text/javascript" src="js/jstree.min.js"></script> <!-- tree js jquery iletakan di category frontend -->
    <script type="text/javascript" src="js/drag.js"></script> <!-- legend yang bisa di drag-->
    <!--<script type="text/javascript" src="js/jquery.jstree.js"></script>-->

    <script type="text/javascript" src="js/rawjson.js"></script> <!-- rawjson merupakan sambngan dari geojson.js untuk meletakkan konversi geojso ke maps berupa gambar -->
    <script type="text/javascript" src="js/legend.js"></script> <!-- js script yang nantinya menampilkan legend-->
    <!-- Favicons -->
	<link rel="icon" href="images/faveicon.png">

	<script>
		var map;   
		var request_in_process = false;  
		var polygoncolor="",Strokecolor="",iconimage, feature_index=0; 
		var drawingManager;
		var newShape; 
		currentFeature_or_Features =new Array();  
		newpolyline=new Array(); 
		var infowindow = new google.maps.InfoWindow();  

		var all_overlays = [];

		var newpolygon="",newmarker="";  
		var roadStyle = {   
			strokeColor: "#FFFF00",
			strokeWeight: 7,
			strokeOpacity: 0.75
		};
		var addressStyle = {   
			icon: "img/marker-house.png"
		}; 
		var parcelStyle = {   
			animation: google.maps.Animation.DROP,  
			icon: "img/marker-house.png", 	
		
			
			strokeColor: "#FF7800",
			strokeOpacity: 1,
			strokeWeight: 2,
			fillColor: "#46461F",
			fillOpacity: 1
		};
		
	
		
		function deleteAllShape() {
        for (var i=0; i < all_overlays.length; i++)
        {
          all_overlays[i].overlay.setMap(null);
        }
        all_overlays = [];
      }
		
		function drop_satusatu(nama_marker, i) {
    setTimeout(function() {
		nama_marker.setMap(map);
		nama_marker.setAnimation(google.maps.Animation.DROP);
    	}, i * 15); //Interval time ubah aja disini
	}

			function init(){
	//tampilkan peta
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
	//end tampilkan peta



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




		google.maps.event.addListener(map,'mousemove',function(event) {
		document.getElementById('latlong').innerHTML = event.latLng.lat().toFixed(5) + ', ' + event.latLng.lng().toFixed(5)
		});	
	// END semua fungsi Batas bali yang bisa diliat (South West , North East)



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



  		//listener jikaevent merupakan sesuatu dari if , maka tampilkan resultnya 
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
							document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';

							 newShape = event.overlay;
					         newShape.type = event.type;
						 
							var path = newShape.getPath();
							google.maps.event.addListener(path, 'insert_at', function(){
					
							panjang=google.maps.geometry.spherical.computeLength(coordinate);
					
							document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
							}); 
							google.maps.event.addListener(path, 'remove_at', function(){

							panjang=google.maps.geometry.spherical.computeLength(coordinate);
					
							document.getElementById('result').innerHTML=(panjang/1000).toPrecision(7)+' km';
							}); 
							google.maps.event.addListener(path, 'set_at', function(){
						
							panjang=google.maps.geometry.spherical.computeLength(coordinate);
						
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


						document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
		
						newShape = event.overlay;
				        newShape.type = event.type;
						
						google.maps.event.addListener(newShape, 'bounds_changed', function(){
				
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
						document.getElementById('result').innerHTML=(hasil/1000000).toPrecision(7)+ "km<sup>2<\/sup>" ;
						 
						newShape = event.overlay;
				        newShape.type = event.type;
								
										newShape.getPaths().forEach(function(path, index){
										
										  google.maps.event.addListener(path, 'insert_at', function(){
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

  		})
	//End fungsi event listener



	 google.maps.event.addDomListener(document.getElementById('clearOverlay'), 'click', deleteAllShape);


	}
//end init



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

//clear currentFeature_or_Features[] array dimana sebelumnya telah diletakka array geojson di rawjson.js degnan fungsi rawGeoJSON() 
//tergantung jika poliline, marker atau pologon terdapat 3 tipe array 
	function clearMap(){
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
		
			}
			if (infowindow.getMap()){
				infowindow.close();
			}					
		}

		var json;
//awalan dari jquery checkbok dan legend show
		$(document).ready(function() {
		$('div#legend-bar').drags(); 
		$('#minimize-layer-selector').click(function(e) {   //jika layer selected di checkbox di klik kapanpun
            $('#layer-selector').toggle("fast",function(){
				$( "#minimize-layer-selector>span" ).toggleClass( "glyphicon-minus glyphicon-plus" )
				
				});
        });
			$('#layer-selector').jstree({
				'plugins' : ['themes', 'checkbox', 'types'],
				'checkbox' : {
				  'three_state' : false, 
				  "cascade":"undetermined",
				  "whole_node":false,
				  "keep_selected_style" : false,

				},
				
			  });

				
				var layer_selected=new Array();
				var layer_displayed=new Array();

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
					
				
				//jika jumlah layer yang dipilih (layer_selected) kurang dari jumlah layer yang terdisplay (layer_displayed)
				if(layer_selected.length<layer_displayed.length){
					clearMap();
					currentFeature_or_Features.length=0;
					currentFeature_or_Features=[];
					$( "div#legend-container" ).html("");
					
					for(i = 0, j = data.selected.length; i < j; i++) {
					 
					 r = data.instance.get_node(data.selected[i]).id.split("_");
						if(r[1]=='polygon' || r[1]=='polyline' || r[1]=='marker'){
							
							layer_displayed.push(data.instance.get_node(data.selected[i]).id);
							showLayer(r[0],r[1]);  //memanggil fungsi show layer r[0] = layer_id dan r[1] = tipe langsung menuju layer.php
							
							showLegend(r[0],r[1]);  //memanggil fungsi show legennd di fle legend.php
							
							console.log('showLayer('+r[0]+','+r[1]+')');
							}
						
						}
					
					
					
					}
				else if(layer_selected.length>layer_displayed.length){
					var diff;
					
					jQuery.grep(layer_selected, function(el) {
        			if (jQuery.inArray(el, layer_displayed) == -1) diff=el;
					});
	
					layer_displayed.push(diff);
					
					
					showLayer(diff.split("_")[0],diff.split("_")[1]);
					
					showLegend(diff.split("_")[0],diff.split("_")[1]);
					console.log('show_layer: '+diff.split("_")[0]+'_'+ diff.split("_")[1]);
					}
				  });
				   
			
			function showLayer(layerid,tipe){
						
								$.ajax({
								  url: "libraries/layer.php",
								  type: "POST",
								  statusCode: {
										404: function() {
										  alert( "page not found" );
										}
									},
								  data: {kategori:tipe,id:layerid},
								  dataType: "json",
								})
								.always(function( html ) {
					
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
					
								  }
								})
								.fail(function( jqXHR, textStatus ) {
								  alert( "Request failed lo ini, statusnya adalah : " + textStatus );
								});	
							//}
						}
								
			});
      	
		

	</script>
</head>

<body onload="init();">
<div class="printArea">
	
	
	<div class="print printlogo">
        <div class="row">
            <center>
                <div class="col-md-5">
                	<!--<img src="img/logo.png" id="logo" width="50px" height="50px">
                	<h2>PPE BALI NUSRA</h2>-->
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
                <!--	<div class="logo"><img src="images/logo-gis.png" alt="logo-gis"></div>-->
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
    
    </div>
    </div>
    
      <div id="side-bar">

				    <a href="#" id="minimize-layer-selector"><span class="glyphicon glyphicon-minus"></span></a>
				    <input type="button" value="Show Legend" onclick="unhideLegend();" class="btn btn-info btn-xs">
				    <div id="layer-selector">
				   
                    <ul id="">
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