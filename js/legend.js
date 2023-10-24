legend = new Array();
		function showLegend(layerid,tipe){
							$.ajax({
									  url: "libraries/legend.php",
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
									
									
									})
									.done(function(data) {
										
										
										
					//clearMap(); clear legend	
													
							if(data[3]=='polygon'){
										$( "div#legend-container" ).append( "<p class=\"nama-legend\">"+data[2]+"</p>" );
										
										for (var k=0; k<data[0].length; k++){
												$( "div#legend-container" ).append("<div class=\"legend-item\"><span class=\"attribut-legend-nama\">"+data[0][k]+"</span><span class=\"attribut-legend-value\" style=\"background-color:"+data[1][k]+" !important;\"></span></div>"
												);
										}
									
									}
									else if(data[3]=='polyline'){
										$( "div#legend-container" ).append("<p class=\"nama-legend\">"+data[2]+"</p>" );
										
										for (var k=0; k<data[0].length; k++){
												$( "div#legend-container" ).append("<div class=\"legend-item\"><span class=\"attribut-legend-nama\">"+data[0][k]+"</span><span class=\"attribut-legend-value-polyline\" style=\"background-color:"+data[1][k]+"!important\"></span></div>"
												);
										}
									
									}
									else if(data[3]=='marker'){
										$("div#legend-container" ).append("<p class=\"nama-legend\">"+data[2]+"</p>" );
										
										for (var k=0; k<data[0].length; k++){
										$("div#legend-container" ).append("<div class=\"legend-item-marker\"><span class=\"attribut-legend-nama\">"+data[0][k]+"</span><span><img class=\"marker-legend-value\" src='"+data[1][k]+"'></span></div>");
										}
									
									}
												
										})
			
						}
						
			function unhideLegend(){
				$("div#legend-bar").fadeIn("fast");
				}
			function hideLegend(){
				$("div#legend-bar").fadeOut("fast");
				}
		