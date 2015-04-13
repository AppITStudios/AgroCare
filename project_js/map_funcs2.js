$(document).ready(function() {
    var map = new EasyMap({
        container: 'map_canvas',
        latitude: 13.685449,
        longitude: -89.239938,
        zoom: 10,
        infoWindowSystem: EasyMap.InfoWindowSystem.ONE_WINDOW
    });
    
    
    function marker_callback(marker){
			marker.showInfoWindow();
        }
    map.setMarkersCallbackFunc(marker_callback);
    
    
    map.showCoordinates();
    map.setOnUserPosition(15, function(center){
        $("#alert_lat").val(center.lat());
        $("#alert_lon").val(center.lng());
        
        $("#alert_lat2").val(center.lat());
        $("#alert_lon2").val(center.lng());
        loadNearData();
        map.onDragEnd(function(e){
            loadNearData();
        });
    });
    
    function loadNearData(){
        var bounds = map.getBounds();
        
        var exclude_markers = [];
        var markers = map.map_markers;
        
        for (var i=0; i<markers.length; i++){
            var marker = markers[i].marker;
            
            if (bounds.contains(marker.getPosition())){
                exclude_markers.push([marker.getPosition().lat(), marker.getPosition().lng()]);
            }
        }
        
        //alert(exclude_markers);
        
        var maxX = bounds.getNorthEast().lng();
        var maxY = bounds.getNorthEast().lat();
        
        var minX = bounds.getSouthWest().lng();
        var minY = bounds.getSouthWest().lat();
        
        $.ajax({
			url: "/mapdata/index.php",
            method: "POST",
            data: {
                max_x: maxX,
                max_y: maxY,
                min_x: minX,
                min_y: minY,
                exclude: exclude_markers
            },
            dataType: 'json'
		}).done(function(data) {
            var coincidencias = [];
            var found = false;
            //alert(data);
            if (data.length > 0){
                
                coincidencias.push([data[0]]);
                
                for (var i=1; i<data.length; i++){
                    var found = false;
                    
                    for (var j=0; j<coincidencias.length; j++){
                        if (coincidencias[j][0].lat == data[i].lat && coincidencias[j][0].lng == data[i].lng){
                            coincidencias[j].push(data[i]);
                            found = true;
                            break;
                        }
                    }
                    
                    if (!found){
                        coincidencias.push([data[i]]);
                    }
                }
                
                // empezamos el despliegue 
                for (var i=0; i<coincidencias.length; i++){
                    if (coincidencias[i].length > 1){
                    
                        var master_marker = new EasyMarkerCluster({
                            latitude: coincidencias[i][0].lat,
                            longitude: coincidencias[i][0].lng,
                            markers: coincidencias[i] 
                        }, map);
                        
                        
                    } else{
                        var mark = coincidencias[i][0];
                        
                        var marker = map.addMarker({
                            latitude: mark.lat,
                            longitude: mark.lng
                        });
                        marker.setInfoContent(mark.desc);
                    }
                }
            }
		});
        
        //alert(" minX=" + minX + "\n maxX=" + maxX + "\n minY=" + minY + "\n maxY=" + maxY);
    }
});