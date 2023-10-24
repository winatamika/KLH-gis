		function rawGeoJSON(jsonval,legend,color,legendfield,icon,tipe){

			//berhbungan dengan class GeoJSON.js
			currentFeature_or_Features.push(new GeoJSON(JSON.parse(jsonval)));
			//sebelimnya currentFeature_or_Features.push(new GeoJSON(JSON.parse(jsonval),style)); -->ada tambahan style diremove karena style dynamic
					var i=currentFeature_or_Features.length-1;
					console.log('length'+currentFeature_or_Features[i].length);
					//return;
					
					if(currentFeature_or_Features[i].length){
					for(var j = 0; j < currentFeature_or_Features[i].length; j++){
							
							
						if(currentFeature_or_Features[i][j].length){
							for(var k = 0; k < currentFeature_or_Features[i][j].length; k++){
				currentFeature_or_Features[i][j][k]=setLayerToMap(tipe,currentFeature_or_Features[i][j][k],legend,legendfield,color,icon);
								
								
								
								if(tipe=='marker'){
									drop_satusatu(currentFeature_or_Features[i][j][k],j);
									}
									
								else{ currentFeature_or_Features[i][j][k].setMap(map);}
							
								if(currentFeature_or_Features[i][j][k].geojsonProperties) {
									setInfoWindow(currentFeature_or_Features[i][j][k]);
								}
								}
							}
							
						else{
					currentFeature_or_Features[i][j]=setLayerToMap(tipe,currentFeature_or_Features[i][j],legend,legendfield,color,icon);		
								if(tipe=='marker'){
									drop_satusatu(currentFeature_or_Features[i][j],j);
									}
									
								else{ currentFeature_or_Features[i][j].setMap(map);}
							
								if(currentFeature_or_Features[i][j].geojsonProperties) {
									setInfoWindow(currentFeature_or_Features[i][j]);
								}
							}
							
						}
					}
					else{
					currentFeature_or_Features[i]=setLayerToMap(tipe,currentFeature_or_Features[i],legend,legendfield,color,icon);
					currentFeature_or_Features[i].setMap(map);
						if(currentFeature_or_Features[i].geojsonProperties) {
								setInfoWindow(currentFeature_or_Features[i]);
							}
					}
					
		}
		function setInfoWindow (feature) {
			google.maps.event.addListener(feature, "click", function(event) {
				var content = "<div id='infoBox'><strong>Info Layer</strong><br />";
				for (var j in this.geojsonProperties) {
					content += j + ": " + this.geojsonProperties[j] + "<br />";
				}
				content += "</div>";
				infowindow.setContent(content);
				infowindow.setPosition(event.latLng);
				infowindow.open(map);
			});
		}
		
		function setLayerToMap(tipe,feature,legend,legendfield,color,icon){
			
			if(tipe=='polygon'){
								polygoncolor='black';//Default Value
								Strokecolor='black';
								if(feature.geojsonProperties){
								for(var k = 0; k < legend.length; k++){
									if(feature.geojsonProperties[legendfield]==legend[k]){
									polygoncolor=color[k];
									Strokecolor="transparent";
									}
								}
								}
								newpolygon="";
								newpolygon=new google.maps.Polygon(feature);
								newpolygon.setOptions({fillColor: polygoncolor,strokeColor: Strokecolor,fillOpacity:0.7,zIndex:1});
								return newpolygon;
							}
							else if(tipe=='polyline'){
								
								Strokecolor='black';//Default Value
								
									for(var k = 0; k < legend.length; k++){
									if (legend.length==1){
										Strokecolor=color[k];
										}
									else{
										if(feature.geojsonProperties[legendfield]==legend[k]){
										Strokecolor=color[k];
										}
									}
									}
	
								
							
								newpolyline=feature;
								newpolyline.setOptions({strokeColor: Strokecolor,strokeOpacity:1,strokeWeight:1});
								return newpolyline;
		
								}
							else if(tipe=='marker'){
								iconimage='img/marker-black.png';//Default Value
								
									for(var k = 0; k < legend.length; k++){
									if(feature.geojsonProperties[legendfield]==legend[k]){
									iconimage=icon[k];
									}
								}
								newmarker=new google.maps.Marker(feature);
								newmarker.setOptions({icon: iconimage,animation:google.maps.Animation.DROP});
								
								return newmarker;
								}

			
			}