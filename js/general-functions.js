// Converts to uppercase, removes multiple whitespaces and trims inputs on focus out
$(document).on("focusout", "input[type=text]", function() {
    this.value = this.value.toUpperCase().replace(/\s{2,}/g, " ").trim();
});
$(document).on("keypress", ".vLetters", function(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return validateLetters(charCode);
});
$(document).on("keypress", ".vNumbers", function(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return validateNumbers(charCode);
});
$(document).on("keypress", ".vAlphanumeric", function(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return validateAlphanumeric(charCode);
});

// Allows/blocks keys depending on the input class
function validateLetters(charCode) {
    return !(charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32 && (charCode <= 192 || charCode >= 255));
}

function validateNumbers(charCode) {
    return !(charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 32 && (charCode <= 192 || charCode >= 255));
}

function validateAlphanumeric(charCode) {
    return (validateLetters(charCode) || validateNumbers(charCode) || (charCode > 44 && charCode < 48)); // 45 es: -, 46 es; . y 47 es: /
}

// Removes the markers and polygons from the map, but keeps them in the array
function deleteDrawings(drawingArray) {
    for(var i = 0; i < drawingArray.length; i++) {
        drawingArray[i].setMap(null);
    }
}

$('#btnAddMarker').on('click', function() {
    // Delete this
    var latarr = [19.55, 19.7, 20.2, 20.8];
    var lngarr = [-104.5, -104, -103.4, -103.2];

    var tempMarker = new google.maps.Marker({
        position: new google.maps.LatLng(latarr[Math.floor(Math.random() * 4)], lngarr[Math.floor(Math.random() * 4)]),
        map: gMap,
        draggable: false,
        animation: google.maps.Animation.DROP,
        icon: 'images/mapMarkers/uso/caminos.png',
        title: 'Temp title'
    });

    tempMarker.addListener('click', toggleBounce); // This function is in googlemap.js
    gMap.setCenter(tempMarker.getPosition());
    markersArray.push(tempMarker);
});

$('#btnPolygon').on('click', function() {
        // Defines the LatLng coordinates for the polygon's path
        var polygonCoord = [
            {lat: 21, lng: -105},
            {lat: 21.2, lng: -103.5},
            {lat: 20.5, lng: -103.3},
            {lat: 20.9, lng: -102},
            {lat: 20.5, lng: -101},
            {lat: 21, lng: -105}
        ];

        var tempPolygon = new google.maps.Polygon({
            paths: polygonCoord,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35
        });

        tempPolygon.setMap(gMap);
        polygonsArray.push(tempPolygon);
});

$('#btnClear').on('click', function() {
    // Deletes all markers/polygons in the array by removing references to them
    deleteDrawings(markersArray);
    deleteDrawings(polygonsArray);
    markersArray = [];
    polygonsArray =[];
});