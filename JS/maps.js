require([
    "esri/Map",
    "esri/views/MapView",
    "esri/Graphic",
    "esri/layers/GraphicsLayer"
], function(Map, MapView, Graphic, GraphicsLayer) {

    var map = new Map({
        basemap: "topo-vector"
    });

    var view = new MapView({
        container: "viewDiv",
        map: map,
        center: [-118.80500, 34.02700],
        zoom: 13
    });
    var graphicsLayer = new GraphicsLayer();
    map.add(graphicsLayer);

    var point = {
        type: "point",
        longitude: -118.80657463861,
        latitude: 34.0005930608889
    };
    var point = {
        type: "point",
        longitude: -118.80657463861,
        latitude: 34.0005930608889
    };

    var simpleMarkerSymbol = {
        type: "simple-marker",
        color: [226, 119, 40],  // orange
        outline: {
            color: [255, 255, 255], // white
            width: 1
        }
    };

    var pointGraphic = new Graphic({
        geometry: point,
        symbol: simpleMarkerSymbol
    });

    graphicsLayer.add(pointGraphic);

    var simpleLineSymbol = {
        type: "simple-line",
        color: [255, 69, 0], // orange
        width: 2
    };

    var polyline = {
        type: "polyline",
        paths: [
            [-118.821527826096, 34.0139576938577],
            [-119.814893761649, 32.0080602407843],
        ]
    };

    var polylineGraphic = new Graphic({
        geometry: polyline,
        symbol: simpleLineSymbol
    });

    graphicsLayer.add(polylineGraphic);

});