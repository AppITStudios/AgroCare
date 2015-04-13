$(document).ready(function() {
    var noRoadStyle = [ 
        { 
            featureType: "road", stylers: [ 
                { 
                    visibility: "off" 
                } 
            ] 
        } 
    ];
            
    
    var map = new EasyMap({
        container: 'map_canvas',
        latitude: 13.685449,
        longitude: -89.239938,
        zoom: 10,
        infoWindowSystem: EasyMap.InfoWindowSystem.ONE_WINDOW
    });
    
    map.getStyleManager().addStyleMap({name: 'no_road_style', style: noRoadStyle});
    map.map_obj.setMapTypeId('no_road_style');
    
    
    function marker_callback(marker){
			marker.showInfoWindow();
        }
    map.setMarkersCallbackFunc(marker_callback);
    
    
    map.showCoordinates();
    map.setOnUserPosition(15, function(center){
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
            for (var i=0; i<data.length; i++){
                var marker = map.addMarker({
                    latitude: data[i].lat,
                    longitude: data[i].lng
                });
                marker.setInfoContent(data[i].desc);
            }
		});
        
        //alert(" minX=" + minX + "\n maxX=" + maxX + "\n minY=" + minY + "\n maxY=" + maxY);
    }
});