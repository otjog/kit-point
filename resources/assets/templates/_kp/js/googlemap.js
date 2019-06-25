export default function InitMap(geo, zoom) {
    let map = document.getElementById('map');

    if(map !== undefined && map !== null){

        let location = {lat: +geo.latitude, lng: +geo.longitude};

        return new google.maps.Map(
            map, {
                zoom: zoom,
                center: location
            });
    }
}