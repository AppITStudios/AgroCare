$(document).ready(function() {
    var map = new EasyMap({
        container: 'map_canvas',
        latitude: 13.685449,
        longitude: -89.239938,
        zoom: 10,
        infoWindowSystem: EasyMap.InfoWindowSystem.ONE_WINDOW
    });
    
    map.setOnUserPosition(15, function(center){
        $("#alert_lat").val(center.lat());
        $("#alert_lon").val(center.lng());
        
        $("#alert_lat2").val(center.lat());
        $("#alert_lon2").val(center.lng());
    });
});