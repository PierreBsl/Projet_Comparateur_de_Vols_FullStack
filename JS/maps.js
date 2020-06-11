let latDepart;
let latArrive;
let longDepart;
let longArrive;

function map(){
    require([
        "esri/Map",
        "esri/views/MapView",
        "esri/Graphic",
        "esri/layers/GraphicsLayer"
    ], function(Map, MapView, Graphic, GraphicsLayer) {

        var map = new Map({
            basemap: "topo-vector"
        });
        let longA=parseInt(longArrive);
        let longD=parseInt(longDepart);

        let latA=parseInt(latArrive);
        let latD=parseInt(latDepart);

        let diffy=(latA+latD)/2;
        let diffx=(longA+longD)/2;
        console.log(diffy);
        console.log(diffx);
        var view = new MapView({
            container: "viewDiv",
            map: map,
            center: [diffx, diffy],
            zoom: 3
        });
        var graphicsLayer = new GraphicsLayer();
        map.add(graphicsLayer);

        var pointdepart = {
            type: "point",
            longitude: longDepart,
            latitude: latDepart
        };
        var pointarrive = {
            type: "point",
            longitude: longArrive,
            latitude: latArrive
        };

        var simpleMarkerSymbol = {
            type: "simple-marker",
            color: [255, 16, 0],  // orange
            outline: {
                color: [255, 255, 255], // white
                width: 1
            }
        };

        var pointGraphic1 = new Graphic({
            geometry: pointdepart,
            symbol: simpleMarkerSymbol
        });

        var pointGraphic2 = new Graphic({
            geometry: pointarrive,
            symbol: simpleMarkerSymbol
        });

        graphicsLayer.add(pointGraphic1);
        graphicsLayer.add(pointGraphic2);

        var simpleLineSymbol = {
            type: "simple-line",
            color: [255, 69, 0], // orange
            width: 2
        };

        var polyline = {
            type: "polyline",
            paths: [
                [longDepart, latDepart],
                [longArrive, latArrive],
            ]
        };

        var polylineGraphic = new Graphic({
            geometry: polyline,
            symbol: simpleLineSymbol
        });

        graphicsLayer.add(polylineGraphic);

    });
}


function coco() {
    console.log("Coco");
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("test1");
            let tab=this.responseText;
            console.log(tab);

            console.log("test2");
            tab=JSON.parse(tab);
            console.log(tab);

            latDepart = tab[0]['lat'];
            longDepart = tab[0]['long'];

            latArrive = tab[1]['lat'];
            longArrive =tab[1]['long'];
            console.log(latArrive);
            console.log(longArrive);


        }
    };
    xmlhttp.open("GET", "getCoordonne.php", true);
    xmlhttp.send();
}

window.onload = function() {
    console.log("Debut SQL");
    coco();

    map();
};

