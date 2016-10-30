

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>Open Street Map</title>
        <style type="text/css">
            body { font: normal 10pt Helvetica, Arial; }
            #map { width: 100%; height: 100%; border: 0px; padding: 0px; }
            #list > div { background-color: #aaa; margin-top: 10px; }
        </style>
        <script src="http://openlayers.org/api/OpenLayers.js" type="text/javascript"> </script>
    </head>
    <body onload="initMap()" style="margin:0; border:0; padding:0; width:1000px; height:500px;">
        <div id="map"></div>
        <div id="list" style="width:100%; height: 100%"></div>
    </body>
            <script type="text/javascript">
            var iconSize = new OpenLayers.Size(21, 25);
            var iconOffset = new OpenLayers.Pixel(-(iconSize.w / 2), -iconSize.h);
            var icon = new OpenLayers.Icon("img/fourmarker.png",
                           iconSize, iconOffset);
            var list = document.getElementById('list');


            var zoom, center, currentPopup, map, lyrMarkers;
            var popupClass = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
                "autoSize": true,
                "minSize": new OpenLayers.Size(300, 50),
                "maxSize": new OpenLayers.Size(500, 300),
                "keepInMap": true
            });

            var bounds = new OpenLayers.Bounds();
            function addMarker(id, lng, lat, info) {
                var pt = new OpenLayers.LonLat(lng, lat)
                                       .transform(new OpenLayers.Projection("EPSG:4326"), 
                                       map.getProjectionObject());
                bounds.extend(pt);
                var feature = new OpenLayers.Feature(lyrMarkers, pt);
                feature.closeBox = true;
                feature.popupClass = popupClass;
                feature.data.popupContentHTML = info ;
                feature.data.overflow = "auto";
                var marker = new OpenLayers.Marker(pt, icon.clone());

                var markerClick = function(evt) {
                    if (currentPopup != null && currentPopup.visible()) {
                        currentPopup.hide();
                    }


                    if (this.popup == null) {
                        this.popup = this.createPopup(this.closeBox);
                        map.addPopup(this.popup);
                        this.popup.show();
                    } else {
                        this.popup.toggle();
                    }
                    currentPopup = this.popup;
                    OpenLayers.Event.stop(evt);
                };
                marker.events.register("mousedown", feature, markerClick);
                lyrMarkers.addMarker(marker);

                // add items
                var listItem = OpenLayers.Util.createDiv(this.id, null, null, null, 'relative', null);
                listItem.innerHTML = info;
                list.appendChild(listItem);

                var callback = function(e) {
                    marker.events.triggerEvent('mousedown');
                    console.log(marker);
                    OpenLayers.Event.stop(e);
                };
                OpenLayers.Event.observe(listItem, "touchend", OpenLayers.Function.bindAsEventListener(callback, this));
                OpenLayers.Event.observe(listItem, "click", OpenLayers.Function.bindAsEventListener(callback, this));

            }

            function initMap() {
                var options = {
                    projection: new OpenLayers.Projection("EPSG:900913"),
                    displayProjection: new OpenLayers.Projection("EPSG:4326"),
                    units: "m",
                    numZoomLevels: 19,
                    maxResolution: 156543.0339,
                    maxExtent: new OpenLayers.Bounds(-0.13011, -0.13011, 51.51039, 51.51039)
                };

                map = new OpenLayers.Map("map", options);
                map.addControl(new OpenLayers.Control.DragPan());
                var lyrOsm = new OpenLayers.Layer.OSM();
                map.addLayer(lyrOsm);
                lyrMarkers = new OpenLayers.Layer.Markers("Markers");
                map.addLayer(lyrMarkers);

                 //add marker on given coordinates
                addMarker('1',-0.12519,51.51112 , '<b>Tescos</b><br/>Covent garden');
                addMarker('2',-0.13264,51.50918 , '<b>Spar</b><br/>Leicester Square');
                addMarker('3', -0.12498,51.50807 , '<b>M & S</b><br/>Embankment');
                center = bounds.getCenterLonLat();
                map.setCenter(center, map.getZoomForExtent(bounds) - 1);
                zoom = map.getZoom();
            }



        </script>
</html>