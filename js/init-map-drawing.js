var map;
		var request_in_process = false;
		var polygoncolor="",Strokecolor="",iconimage, feature_index=0;
		
		currentFeature_or_Features =new Array();
		newpolyline=new Array();
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
			animation: google.maps.Animation.DROP, //marker style
			icon: "img/marker-house.png", 	
			//end marker style
			
			strokeColor: "#FF7800",
			strokeOpacity: 1,
			strokeWeight: 2,
			fillColor: "#46461F",
			fillOpacity: 1
		};
		
		var infowindow = new google.maps.InfoWindow();
		
		var drawingManager; //drawingmanager global variabel
		
		var newShape; //UNTUK MENYIMPAN hasil drawing yang baru dibuat kemudian memasukkan event
      	
		var all_overlays = [];
		
		function deleteAllShape() {
        for (var i=0; i < all_overlays.length; i++)
        {
          all_overlays[i].overlay.setMap(null);
        }
        all_overlays = [];
      }
		
		
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
		document.getElementById('latlong').innerHTML = event.latLng.lat() + ', ' + event.latLng.lng()
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
							currentFeature_or_Features[i][j].setMap(null);
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
		
		/*newpolygon.setMap(null);
		newmarker.setMap(null);*/
								
		
		}