$(document).ready(function() {
    var map = new EasyMap({
        container: 'map_canvas',
        latitude: 13.685449,
        longitude: -89.239938,
        zoom: 10,
        infoWindowSystem: EasyMap.InfoWindowSystem.ONE_WINDOW
    });
    
    $("#map_canvas").attr("style", "visibility: hidden");
    
    map.setOnUserPosition(15, function(center){
        map.reverseGeoCode([center.lat(), center.lng()], function(result){
            $("#city").val(result.getCity());
            $("#country").val(result.getCountry());
        });
    });
});