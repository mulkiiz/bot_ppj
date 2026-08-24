<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.3/dist/leaflet.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/python-visualization/folium/folium/templates/leaflet.awesome.rotate.min.css"/>
    
            <meta name="viewport" content="width=device-width,
                initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <style>
                #map_14cd1993c786ac8fc653b5d09c14d823 {
                    position: relative;
                    width: 100.0%;
                    height: 100.0%;
                    left: 0.0%;
                    top: 0.0%;
                }
                .leaflet-container { font-size: 1rem; }
            </style>

            <style>html, body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            </style>

            <style>#map {
                position:absolute;
                top:0;
                bottom:0;
                right:0;
                left:0;
                }
            </style>

            <script>
                L_NO_TOUCH = false;
                L_DISABLE_3D = false;
            </script>

        
    <script src="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@3.0.0/Control.FullScreen.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@3.0.0/Control.FullScreen.css"/>
    <script src="https://cdn.jsdelivr.net/gh/ljagis/leaflet-measure@2.1.7/dist/leaflet-measure.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ljagis/leaflet-measure@2.1.7/dist/leaflet-measure.min.css"/>
</head>
<body>
    
    
<div style="
    position: fixed; bottom: 30px; left: 30px;
    background: white; padding: 12px 14px;
    border: 2px solid #1f4e79; border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    font-family: Arial, sans-serif; font-size: 12px;
    z-index: 9999; max-width: 240px;
">
  <div style="font-weight:700;color:#1f4e79;margin-bottom:6px;
              font-size:13px;border-bottom:1px solid #ddd;padding-bottom:4px;">
    Legenda — PUD Kemranjen
  </div>

  <div style="margin:4px 0;">
    <span style="display:inline-block;width:14px;height:14px;
                 background:#6F4E37;border-radius:50%;margin-right:6px;
                 vertical-align:middle;"></span>
    Kopi
  </div>
  <div style="margin:4px 0;">
    <span style="display:inline-block;width:14px;height:14px;
                 background:#7FB069;border-radius:50%;margin-right:6px;
                 vertical-align:middle;"></span>
    Durian
  </div>
  <div style="margin:4px 0;">
    <span style="display:inline-block;width:14px;height:14px;
                 background:#D4A017;border-radius:50%;margin-right:6px;
                 vertical-align:middle;"></span>
    Gula Kelapa
  </div>

  <div style="margin-top:8px;padding-top:6px;border-top:1px solid #ddd;
              font-size:10px;color:#888;line-height:1.4;">
    <b>PoC Demo</b> — Klik titik untuk melihat<br>
    detail dan ulasan Google (dummy).
  </div>
</div>
    
<div style="
    position: fixed; top: 12px; left: 50%; transform: translateX(-50%);
    background: rgba(31,78,121,0.95); color: white;
    padding: 8px 18px; border-radius: 6px;
    font-family: Arial, sans-serif; font-size: 14px; font-weight: 600;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    z-index: 9999;
">
  PoC — Integrasi PUD & Desa Wisata · Kec. Kemranjen, Banyumas
</div>
    
            <div class="folium-map" id="map_14cd1993c786ac8fc653b5d09c14d823" ></div>
        
</body>
<script>
    
    
            var map_14cd1993c786ac8fc653b5d09c14d823 = L.map(
                "map_14cd1993c786ac8fc653b5d09c14d823",
                {
                    center: [-7.555, 109.3],
                    crs: L.CRS.EPSG3857,
                    ...{
  "zoom": 13,
  "zoomControl": true,
  "preferCanvas": false,
}

                }
            );
            L.control.scale().addTo(map_14cd1993c786ac8fc653b5d09c14d823);

            

        
    
            var tile_layer_4495f73cdd92af1dfc1a46afd0d3951c = L.tileLayer(
                "https://tile.openstreetmap.org/{z}/{x}/{y}.png",
                {
  "minZoom": 0,
  "maxZoom": 19,
  "maxNativeZoom": 19,
  "noWrap": false,
  "attribution": "\u0026copy; \u003ca href=\"https://www.openstreetmap.org/copyright\"\u003eOpenStreetMap\u003c/a\u003e contributors",
  "subdomains": "abc",
  "detectRetina": false,
  "tms": false,
  "opacity": 1,
}

            );
        
    
            tile_layer_4495f73cdd92af1dfc1a46afd0d3951c.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var tile_layer_870d4b2435c0c6e1e2206f8121ca124d = L.tileLayer(
                "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
                {
  "minZoom": 0,
  "maxZoom": 18,
  "maxNativeZoom": 18,
  "noWrap": false,
  "attribution": "Esri World Imagery",
  "subdomains": "abc",
  "detectRetina": false,
  "tms": false,
  "opacity": 1,
}

            );
        
    
            tile_layer_870d4b2435c0c6e1e2206f8121ca124d.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
        function geo_json_bb2676130288253882134cd5ce6499a1_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "dashArray": "8, 6", "fillColor": "transparent", "weight": 3};
            }
        }

        function geo_json_bb2676130288253882134cd5ce6499a1_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_bb2676130288253882134cd5ce6499a1 = L.geoJson(null, {
                onEachFeature: geo_json_bb2676130288253882134cd5ce6499a1_onEachFeature,
            
                style: geo_json_bb2676130288253882134cd5ce6499a1_styler,
            ...{
}
        });

        function geo_json_bb2676130288253882134cd5ce6499a1_add (data) {
            geo_json_bb2676130288253882134cd5ce6499a1
                .addData(data);
        }
            geo_json_bb2676130288253882134cd5ce6499a1_add({"features": [{"geometry": {"coordinates": [[[109.245, -7.51], [109.345, -7.505], [109.35, -7.595], [109.245, -7.605], [109.245, -7.51]]], "type": "Polygon"}, "properties": {"name": "Kec. Kemranjen"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_bb2676130288253882134cd5ce6499a1.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var feature_group_2f07059e89e2ae0cb438d207b7fb3a5a = L.featureGroup(
                {
}
            );
        
    
        function geo_json_f9782870bbb00ea72367d67f67bf224d_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_f9782870bbb00ea72367d67f67bf224d_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_f9782870bbb00ea72367d67f67bf224d = L.geoJson(null, {
                onEachFeature: geo_json_f9782870bbb00ea72367d67f67bf224d_onEachFeature,
            
                style: geo_json_f9782870bbb00ea72367d67f67bf224d_styler,
            ...{
}
        });

        function geo_json_f9782870bbb00ea72367d67f67bf224d_add (data) {
            geo_json_f9782870bbb00ea72367d67f67bf224d
                .addData(data);
        }
            geo_json_f9782870bbb00ea72367d67f67bf224d_add({"features": [{"geometry": {"coordinates": [[[109.27338235294118, -7.558088235294114], [109.27090909090909, -7.570454545454549], [109.245, -7.5859999999999985], [109.245, -7.539166666666679], [109.27338235294118, -7.558088235294114]]], "type": "Polygon"}, "properties": {"name": "Sidamulya"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_f9782870bbb00ea72367d67f67bf224d.bindTooltip(
                `<div>
                     <b>Desa Sidamulya</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_f9782870bbb00ea72367d67f67bf224d.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_df778f35a39f05c8bf526aa941f442fd = L.marker(
                [-7.56, 109.26],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_2833c3eed4c785fd463162733ab8d38f = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eSidamulya\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_df778f35a39f05c8bf526aa941f442fd.setIcon(div_icon_2833c3eed4c785fd463162733ab8d38f);
            
    
        function geo_json_f97bf4724fb22c204c9c00afcbaba546_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_f97bf4724fb22c204c9c00afcbaba546_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_f97bf4724fb22c204c9c00afcbaba546 = L.geoJson(null, {
                onEachFeature: geo_json_f97bf4724fb22c204c9c00afcbaba546_onEachFeature,
            
                style: geo_json_f97bf4724fb22c204c9c00afcbaba546_styler,
            ...{
}
        });

        function geo_json_f97bf4724fb22c204c9c00afcbaba546_add (data) {
            geo_json_f97bf4724fb22c204c9c00afcbaba546
                .addData(data);
        }
            geo_json_f97bf4724fb22c204c9c00afcbaba546_add({"features": [{"geometry": {"coordinates": [[[109.27338235294118, -7.558088235294114], [109.2775, -7.554999999999993], [109.29625, -7.5643750000000045], [109.286875, -7.578437499999996], [109.27090909090909, -7.570454545454549], [109.27338235294118, -7.558088235294114]]], "type": "Polygon"}, "properties": {"name": "Kecila"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_f97bf4724fb22c204c9c00afcbaba546.bindTooltip(
                `<div>
                     <b>Desa Kecila</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_f97bf4724fb22c204c9c00afcbaba546.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_1c68611146c07a90a3b0187f3e3db590 = L.marker(
                [-7.565, 109.285],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_c0a862c2ac862e32c55adfc12fdcf643 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKecila\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_1c68611146c07a90a3b0187f3e3db590.setIcon(div_icon_c0a862c2ac862e32c55adfc12fdcf643);
            
    
        function geo_json_45d7d0a61016fe96bef460b45e498ef8_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_45d7d0a61016fe96bef460b45e498ef8_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_45d7d0a61016fe96bef460b45e498ef8 = L.geoJson(null, {
                onEachFeature: geo_json_45d7d0a61016fe96bef460b45e498ef8_onEachFeature,
            
                style: geo_json_45d7d0a61016fe96bef460b45e498ef8_styler,
            ...{
}
        });

        function geo_json_45d7d0a61016fe96bef460b45e498ef8_add (data) {
            geo_json_45d7d0a61016fe96bef460b45e498ef8
                .addData(data);
        }
            geo_json_45d7d0a61016fe96bef460b45e498ef8_add({"features": [{"geometry": {"coordinates": [[[109.28583333333334, -7.5425], [109.2825, -7.545000000000007], [109.245, -7.5262499999999735], [109.245, -7.51], [109.27450819672131, -7.508524590163934], [109.28583333333334, -7.5425]]], "type": "Polygon"}, "properties": {"name": "Petarangan"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_45d7d0a61016fe96bef460b45e498ef8.bindTooltip(
                `<div>
                     <b>Desa Petarangan</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_45d7d0a61016fe96bef460b45e498ef8.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_ad519eab33f62aa24ea10afdc1c749d2 = L.marker(
                [-7.535, 109.275],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_205d4234fc81a9fe33e8087c4aa65db7 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003ePetarangan\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_ad519eab33f62aa24ea10afdc1c749d2.setIcon(div_icon_205d4234fc81a9fe33e8087c4aa65db7);
            
    
        function geo_json_0c0fc6e4408f08de7b6b084684bebca7_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_0c0fc6e4408f08de7b6b084684bebca7_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_0c0fc6e4408f08de7b6b084684bebca7 = L.geoJson(null, {
                onEachFeature: geo_json_0c0fc6e4408f08de7b6b084684bebca7_onEachFeature,
            
                style: geo_json_0c0fc6e4408f08de7b6b084684bebca7_styler,
            ...{
}
        });

        function geo_json_0c0fc6e4408f08de7b6b084684bebca7_add (data) {
            geo_json_0c0fc6e4408f08de7b6b084684bebca7
                .addData(data);
        }
            geo_json_0c0fc6e4408f08de7b6b084684bebca7_add({"features": [{"geometry": {"coordinates": [[[109.2825, -7.545000000000007], [109.2775, -7.554999999999993], [109.27338235294118, -7.558088235294114], [109.245, -7.539166666666679], [109.245, -7.5262499999999735], [109.2825, -7.545000000000007]]], "type": "Polygon"}, "properties": {"name": "Karanggintung"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_0c0fc6e4408f08de7b6b084684bebca7.bindTooltip(
                `<div>
                     <b>Desa Karanggintung</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_0c0fc6e4408f08de7b6b084684bebca7.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_9c0f300545207ce568d087eceb783bd0 = L.marker(
                [-7.545, 109.27],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_a727d3102d2ed156d6ada16891f3c4b0 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKaranggintung\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_9c0f300545207ce568d087eceb783bd0.setIcon(div_icon_a727d3102d2ed156d6ada16891f3c4b0);
            
    
        function geo_json_23fa9d7d1a828d688d1619f319bb7ddc_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_23fa9d7d1a828d688d1619f319bb7ddc_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_23fa9d7d1a828d688d1619f319bb7ddc = L.geoJson(null, {
                onEachFeature: geo_json_23fa9d7d1a828d688d1619f319bb7ddc_onEachFeature,
            
                style: geo_json_23fa9d7d1a828d688d1619f319bb7ddc_styler,
            ...{
}
        });

        function geo_json_23fa9d7d1a828d688d1619f319bb7ddc_add (data) {
            geo_json_23fa9d7d1a828d688d1619f319bb7ddc
                .addData(data);
        }
            geo_json_23fa9d7d1a828d688d1619f319bb7ddc_add({"features": [{"geometry": {"coordinates": [[[109.29014705882354, -7.586617647058831], [109.30931818181817, -7.580227272727271], [109.32100746268657, -7.59776119402985], [109.2877620967742, -7.600927419354838], [109.29014705882354, -7.586617647058831]]], "type": "Polygon"}, "properties": {"name": "Sirau"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_23fa9d7d1a828d688d1619f319bb7ddc.bindTooltip(
                `<div>
                     <b>Desa Sirau</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_23fa9d7d1a828d688d1619f319bb7ddc.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_725ef0b8ae5ec1c380ecee41719f73c6 = L.marker(
                [-7.59, 109.305],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_b1b346caa8144bb85f5b6dc8ee4d2d88 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eSirau\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_725ef0b8ae5ec1c380ecee41719f73c6.setIcon(div_icon_b1b346caa8144bb85f5b6dc8ee4d2d88);
            
    
        function geo_json_d8d09ac4885ccc5aa3df07371d66eee6_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_d8d09ac4885ccc5aa3df07371d66eee6_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_d8d09ac4885ccc5aa3df07371d66eee6 = L.geoJson(null, {
                onEachFeature: geo_json_d8d09ac4885ccc5aa3df07371d66eee6_onEachFeature,
            
                style: geo_json_d8d09ac4885ccc5aa3df07371d66eee6_styler,
            ...{
}
        });

        function geo_json_d8d09ac4885ccc5aa3df07371d66eee6_add (data) {
            geo_json_d8d09ac4885ccc5aa3df07371d66eee6
                .addData(data);
        }
            geo_json_d8d09ac4885ccc5aa3df07371d66eee6_add({"features": [{"geometry": {"coordinates": [[[109.27090909090909, -7.570454545454549], [109.286875, -7.578437499999996], [109.29014705882354, -7.586617647058831], [109.2877620967742, -7.600927419354838], [109.245, -7.605], [109.245, -7.5859999999999985], [109.27090909090909, -7.570454545454549]]], "type": "Polygon"}, "properties": {"name": "Nusamangir"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_d8d09ac4885ccc5aa3df07371d66eee6.bindTooltip(
                `<div>
                     <b>Desa Nusamangir</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_d8d09ac4885ccc5aa3df07371d66eee6.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_f08b2d9c072e3ea24aaed3bffb2a4a78 = L.marker(
                [-7.585, 109.275],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_3589a5a4e950222a0992970b26be17d8 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eNusamangir\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_f08b2d9c072e3ea24aaed3bffb2a4a78.setIcon(div_icon_3589a5a4e950222a0992970b26be17d8);
            
    
        function geo_json_a85dc6e05f7ceafe232e557bc6644858_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_a85dc6e05f7ceafe232e557bc6644858_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_a85dc6e05f7ceafe232e557bc6644858 = L.geoJson(null, {
                onEachFeature: geo_json_a85dc6e05f7ceafe232e557bc6644858_onEachFeature,
            
                style: geo_json_a85dc6e05f7ceafe232e557bc6644858_styler,
            ...{
}
        });

        function geo_json_a85dc6e05f7ceafe232e557bc6644858_add (data) {
            geo_json_a85dc6e05f7ceafe232e557bc6644858
                .addData(data);
        }
            geo_json_a85dc6e05f7ceafe232e557bc6644858_add({"features": [{"geometry": {"coordinates": [[[109.28583333333334, -7.5425], [109.29416666666667, -7.5425], [109.29964285714286, -7.5589285714285674], [109.29857142857144, -7.563214285714286], [109.29625, -7.5643750000000045], [109.2775, -7.554999999999993], [109.2825, -7.545000000000007], [109.28583333333334, -7.5425]]], "type": "Polygon"}, "properties": {"name": "Karangjati"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_a85dc6e05f7ceafe232e557bc6644858.bindTooltip(
                `<div>
                     <b>Desa Karangjati</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_a85dc6e05f7ceafe232e557bc6644858.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_d275a4d1d88760991b977365162d9340 = L.marker(
                [-7.555, 109.29],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_a9eb79fb385fd783dae68f364d78dc47 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKarangjati\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_d275a4d1d88760991b977365162d9340.setIcon(div_icon_a9eb79fb385fd783dae68f364d78dc47);
            
    
        function geo_json_257de77808486f6f9ef4983ea72e324d_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_257de77808486f6f9ef4983ea72e324d_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_257de77808486f6f9ef4983ea72e324d = L.geoJson(null, {
                onEachFeature: geo_json_257de77808486f6f9ef4983ea72e324d_onEachFeature,
            
                style: geo_json_257de77808486f6f9ef4983ea72e324d_styler,
            ...{
}
        });

        function geo_json_257de77808486f6f9ef4983ea72e324d_add (data) {
            geo_json_257de77808486f6f9ef4983ea72e324d
                .addData(data);
        }
            geo_json_257de77808486f6f9ef4983ea72e324d_add({"features": [{"geometry": {"coordinates": [[[109.286875, -7.578437499999996], [109.29625, -7.5643750000000045], [109.29857142857144, -7.563214285714286], [109.31142857142856, -7.5717857142857135], [109.30931818181817, -7.580227272727271], [109.29014705882354, -7.586617647058831], [109.286875, -7.578437499999996]]], "type": "Polygon"}, "properties": {"name": "Kedungpring"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_257de77808486f6f9ef4983ea72e324d.bindTooltip(
                `<div>
                     <b>Desa Kedungpring</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_257de77808486f6f9ef4983ea72e324d.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_476236f4df862b5f3d18255f312a2688 = L.marker(
                [-7.575, 109.3],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_4a9db9deb24876489e2b6501eea59348 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKedungpring\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_476236f4df862b5f3d18255f312a2688.setIcon(div_icon_4a9db9deb24876489e2b6501eea59348);
            
    
        function geo_json_3fdb2e363b13ee2d677c3351983c325f_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_3fdb2e363b13ee2d677c3351983c325f_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_3fdb2e363b13ee2d677c3351983c325f = L.geoJson(null, {
                onEachFeature: geo_json_3fdb2e363b13ee2d677c3351983c325f_onEachFeature,
            
                style: geo_json_3fdb2e363b13ee2d677c3351983c325f_styler,
            ...{
}
        });

        function geo_json_3fdb2e363b13ee2d677c3351983c325f_add (data) {
            geo_json_3fdb2e363b13ee2d677c3351983c325f
                .addData(data);
        }
            geo_json_3fdb2e363b13ee2d677c3351983c325f_add({"features": [{"geometry": {"coordinates": [[[109.30583333333333, -7.535], [109.30416666666667, -7.535], [109.28612903225807, -7.507943548387097], [109.345, -7.505], [109.34503333333333, -7.505600000000022], [109.30583333333333, -7.535]]], "type": "Polygon"}, "properties": {"name": "Pageralang"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_3fdb2e363b13ee2d677c3351983c325f.bindTooltip(
                `<div>
                     <b>Desa Pageralang</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_3fdb2e363b13ee2d677c3351983c325f.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_be0cf0a7422d2256de5a7f05af1123c3 = L.marker(
                [-7.52, 109.305],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_e949ef6c808f3421634e12f496e71bbd = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003ePageralang\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_be0cf0a7422d2256de5a7f05af1123c3.setIcon(div_icon_e949ef6c808f3421634e12f496e71bbd);
            
    
        function geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_c6d2a9e7f024d4480a3717ddc176c4d9 = L.geoJson(null, {
                onEachFeature: geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_onEachFeature,
            
                style: geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_styler,
            ...{
}
        });

        function geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_add (data) {
            geo_json_c6d2a9e7f024d4480a3717ddc176c4d9
                .addData(data);
        }
            geo_json_c6d2a9e7f024d4480a3717ddc176c4d9_add({"features": [{"geometry": {"coordinates": [[[109.30416666666667, -7.535], [109.29416666666667, -7.5425], [109.28583333333334, -7.5425], [109.27450819672131, -7.508524590163934], [109.28612903225807, -7.507943548387097], [109.30416666666667, -7.535]]], "type": "Polygon"}, "properties": {"name": "Alasmalang"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_c6d2a9e7f024d4480a3717ddc176c4d9.bindTooltip(
                `<div>
                     <b>Desa Alasmalang</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_c6d2a9e7f024d4480a3717ddc176c4d9.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_9fb0fcd080414d6cc1e210d3602275c1 = L.marker(
                [-7.53, 109.29],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_6f512958b15fc945758c523014c19f20 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eAlasmalang\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_9fb0fcd080414d6cc1e210d3602275c1.setIcon(div_icon_6f512958b15fc945758c523014c19f20);
            
    
        function geo_json_8934c3fdfb73f2f7c5511bf9e4917755_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_8934c3fdfb73f2f7c5511bf9e4917755_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_8934c3fdfb73f2f7c5511bf9e4917755 = L.geoJson(null, {
                onEachFeature: geo_json_8934c3fdfb73f2f7c5511bf9e4917755_onEachFeature,
            
                style: geo_json_8934c3fdfb73f2f7c5511bf9e4917755_styler,
            ...{
}
        });

        function geo_json_8934c3fdfb73f2f7c5511bf9e4917755_add (data) {
            geo_json_8934c3fdfb73f2f7c5511bf9e4917755
                .addData(data);
        }
            geo_json_8934c3fdfb73f2f7c5511bf9e4917755_add({"features": [{"geometry": {"coordinates": [[[109.29416666666667, -7.5425], [109.30416666666667, -7.535], [109.30583333333333, -7.535], [109.31625000000001, -7.550625000000003], [109.29964285714286, -7.5589285714285674], [109.29416666666667, -7.5425]]], "type": "Polygon"}, "properties": {"name": "Kebarongan"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_8934c3fdfb73f2f7c5511bf9e4917755.bindTooltip(
                `<div>
                     <b>Desa Kebarongan</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_8934c3fdfb73f2f7c5511bf9e4917755.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_da0f4361a5e810a7a43d5d1a4fb7d5de = L.marker(
                [-7.55, 109.305],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_b1caf878c8da3912db09ee2ddd84a8b1 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKebarongan\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_da0f4361a5e810a7a43d5d1a4fb7d5de.setIcon(div_icon_b1caf878c8da3912db09ee2ddd84a8b1);
            
    
        function geo_json_47ad14b45d7a46618a4a5477bafbc79e_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_47ad14b45d7a46618a4a5477bafbc79e_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_47ad14b45d7a46618a4a5477bafbc79e = L.geoJson(null, {
                onEachFeature: geo_json_47ad14b45d7a46618a4a5477bafbc79e_onEachFeature,
            
                style: geo_json_47ad14b45d7a46618a4a5477bafbc79e_styler,
            ...{
}
        });

        function geo_json_47ad14b45d7a46618a4a5477bafbc79e_add (data) {
            geo_json_47ad14b45d7a46618a4a5477bafbc79e
                .addData(data);
        }
            geo_json_47ad14b45d7a46618a4a5477bafbc79e_add({"features": [{"geometry": {"coordinates": [[[109.29964285714286, -7.5589285714285674], [109.31625000000001, -7.550625000000003], [109.324375, -7.554687499999998], [109.31375, -7.570624999999995], [109.31142857142856, -7.5717857142857135], [109.29857142857144, -7.563214285714286], [109.29964285714286, -7.5589285714285674]]], "type": "Polygon"}, "properties": {"name": "Karangsalam"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_47ad14b45d7a46618a4a5477bafbc79e.bindTooltip(
                `<div>
                     <b>Desa Karangsalam</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_47ad14b45d7a46618a4a5477bafbc79e.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_ad0130ff4d52e996e0deb1b2c900c23d = L.marker(
                [-7.56, 109.31],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_39edfcc73a143a06302c3a819f4f17da = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eKarangsalam\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_ad0130ff4d52e996e0deb1b2c900c23d.setIcon(div_icon_39edfcc73a143a06302c3a819f4f17da);
            
    
        function geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2 = L.geoJson(null, {
                onEachFeature: geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_onEachFeature,
            
                style: geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_styler,
            ...{
}
        });

        function geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_add (data) {
            geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2
                .addData(data);
        }
            geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2_add({"features": [{"geometry": {"coordinates": [[[109.324375, -7.554687499999998], [109.31625000000001, -7.550625000000003], [109.30583333333333, -7.535], [109.34503333333333, -7.505600000000022], [109.34754587155963, -7.550825688073386], [109.324375, -7.554687499999998]]], "type": "Polygon"}, "properties": {"name": "Grujugan"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2.bindTooltip(
                `<div>
                     <b>Desa Grujugan</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_6e8ce7b0a2df198737bd79cb7ffe8fd2.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_ee78df2a002b0270eb8e1332bb5e0b6b = L.marker(
                [-7.54, 109.32],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_b115c13f38cfa37bbcf71e838a4e638d = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eGrujugan\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_ee78df2a002b0270eb8e1332bb5e0b6b.setIcon(div_icon_b115c13f38cfa37bbcf71e838a4e638d);
            
    
        function geo_json_bcc613a662111631d3d5623411153fa5_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_bcc613a662111631d3d5623411153fa5_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_bcc613a662111631d3d5623411153fa5 = L.geoJson(null, {
                onEachFeature: geo_json_bcc613a662111631d3d5623411153fa5_onEachFeature,
            
                style: geo_json_bcc613a662111631d3d5623411153fa5_styler,
            ...{
}
        });

        function geo_json_bcc613a662111631d3d5623411153fa5_add (data) {
            geo_json_bcc613a662111631d3d5623411153fa5
                .addData(data);
        }
            geo_json_bcc613a662111631d3d5623411153fa5_add({"features": [{"geometry": {"coordinates": [[[109.30931818181817, -7.580227272727271], [109.31142857142856, -7.5717857142857135], [109.31375, -7.570624999999995], [109.34964285714285, -7.588571428571457], [109.35, -7.595], [109.32100746268657, -7.59776119402985], [109.30931818181817, -7.580227272727271]]], "type": "Polygon"}, "properties": {"name": "Sibalung"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_bcc613a662111631d3d5623411153fa5.bindTooltip(
                `<div>
                     <b>Desa Sibalung</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_bcc613a662111631d3d5623411153fa5.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_996c1a8a140a15765ae5f0eb8fad0e89 = L.marker(
                [-7.58, 109.32],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_b3f4cb445f70036c4a7270480373865e = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eSibalung\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_996c1a8a140a15765ae5f0eb8fad0e89.setIcon(div_icon_b3f4cb445f70036c4a7270480373865e);
            
    
        function geo_json_907808ab8a6700b64b9d9de591b23060_styler(feature) {
            switch(feature.properties.name) {
                default:
                    return {"color": "#1f4e79", "fillColor": "#a8c5e8", "fillOpacity": 0.15, "weight": 1.5};
            }
        }

        function geo_json_907808ab8a6700b64b9d9de591b23060_onEachFeature(feature, layer) {

            layer.on({
            });
        };
        var geo_json_907808ab8a6700b64b9d9de591b23060 = L.geoJson(null, {
                onEachFeature: geo_json_907808ab8a6700b64b9d9de591b23060_onEachFeature,
            
                style: geo_json_907808ab8a6700b64b9d9de591b23060_styler,
            ...{
}
        });

        function geo_json_907808ab8a6700b64b9d9de591b23060_add (data) {
            geo_json_907808ab8a6700b64b9d9de591b23060
                .addData(data);
        }
            geo_json_907808ab8a6700b64b9d9de591b23060_add({"features": [{"geometry": {"coordinates": [[[109.31375, -7.570624999999995], [109.324375, -7.554687499999998], [109.34754587155963, -7.550825688073386], [109.34964285714285, -7.588571428571457], [109.31375, -7.570624999999995]]], "type": "Polygon"}, "properties": {"name": "Sibrama"}, "type": "Feature"}], "type": "FeatureCollection"});

        
    
            geo_json_907808ab8a6700b64b9d9de591b23060.bindTooltip(
                `<div>
                     <b>Desa Sibrama</b><br><i>Kec. Kemranjen, Kab. Banyumas</i>
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
            geo_json_907808ab8a6700b64b9d9de591b23060.addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var marker_d14f88be78b2b02e3aeb53f6e6b7e649 = L.marker(
                [-7.57, 109.325],
                {
}
            ).addTo(feature_group_2f07059e89e2ae0cb438d207b7fb3a5a);
        
    
            var div_icon_9c78c432742a7d51e09ea50f74a9dfe0 = L.divIcon({
  "html": "\u003cdiv style=\"font-size:10px;color:#1f4e79;font-weight:600;text-shadow:1px 1px 2px white;\"\u003eSibrama\u003c/div\u003e",
  "iconSize": [90, 16],
  "iconAnchor": [45, 8],
  "className": "empty",
});
        
    
                marker_d14f88be78b2b02e3aeb53f6e6b7e649.setIcon(div_icon_9c78c432742a7d51e09ea50f74a9dfe0);
            
    
            feature_group_2f07059e89e2ae0cb438d207b7fb3a5a.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var feature_group_d7d492f93612d7767d14c387bcb11c5b = L.featureGroup(
                {
}
            );
        
    
            var marker_f768d28866aa27a3a1e03b7ea81a0710 = L.marker(
                [-7.518, 109.302],
                {
}
            ).addTo(feature_group_d7d492f93612d7767d14c387bcb11c5b);
        
    
            var icon_bccc54745288539dd837b1177ad0c457 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#6F4E37",
  "icon": "coffee",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_41e97e1910dcf0623eed2a7b4c518965 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_cea2fd67dce1fbf7e24223110456d285 = $(`<div id="html_cea2fd67dce1fbf7e24223110456d285" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#6F4E37;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Kopi</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Kelompok Tani Kopi Pageralang         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Pageralang, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Sentra kopi robusta lereng utara, ~12 ha, produksi ±3 ton/tahun.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Pak Slamet (Ketua Poktan) — WA 081xxx       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★★           <span style="color:#333;font-size:13px;margin-left:6px;">             4.7/5.0           </span>           <span style="color:#999;font-size:11px;">             (3 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Andi P.</b>             <span style="color:#888;">2 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Kopi robustanya khas, body kuat, after-taste cokelat. Bisa beli langsung di rumah pengelola.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Sri Wahyuni</b>             <span style="color:#888;">1 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Sudah coba versi natural process-nya, mantap. Kemasan masih sederhana.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Bagus R.</b>             <span style="color:#888;">3 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Lokasi kebunnya bisa dikunjungi, edukatif untuk anak. Recommended untuk wisata agro.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_41e97e1910dcf0623eed2a7b4c518965.setContent(html_cea2fd67dce1fbf7e24223110456d285);
            
        

        marker_f768d28866aa27a3a1e03b7ea81a0710.bindPopup(popup_41e97e1910dcf0623eed2a7b4c518965)
        ;

        
    
    
            marker_f768d28866aa27a3a1e03b7ea81a0710.bindTooltip(
                `<div>
                     Kopi: Kelompok Tani Kopi Pageralang
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_f768d28866aa27a3a1e03b7ea81a0710.setIcon(icon_bccc54745288539dd837b1177ad0c457);
            
    
            var marker_a78c1e4d5ef213137c5b60421290161a = L.marker(
                [-7.533, 109.278],
                {
}
            ).addTo(feature_group_d7d492f93612d7767d14c387bcb11c5b);
        
    
            var icon_d0dfe236ed0e8be27ca25676a6491cb0 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#6F4E37",
  "icon": "coffee",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_d1b552a3cd0a5f6a50a49646911e06d9 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_f7a069585d8b24f106f3aae615223735 = $(`<div id="html_f7a069585d8b24f106f3aae615223735" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#6F4E37;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Kopi</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Kebun Kopi Petarangan         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Petarangan, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Kopi arabika-robusta mix, dikelola petani perorangan, ±5 ha.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Bu Ratih — WA 082xxx       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★☆           <span style="color:#333;font-size:13px;margin-left:6px;">             3.5/5.0           </span>           <span style="color:#999;font-size:11px;">             (2 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Dimas</b>             <span style="color:#888;">1 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Tempatnya adem, view bagus. Bisa cupping bareng petani.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Lina K.</b>             <span style="color:#888;">2 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★☆☆</div>           <div style="color:#333;margin-top:2px;">Akses jalan masih perlu diperbaiki, tapi kopinya enak.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_d1b552a3cd0a5f6a50a49646911e06d9.setContent(html_f7a069585d8b24f106f3aae615223735);
            
        

        marker_a78c1e4d5ef213137c5b60421290161a.bindPopup(popup_d1b552a3cd0a5f6a50a49646911e06d9)
        ;

        
    
    
            marker_a78c1e4d5ef213137c5b60421290161a.bindTooltip(
                `<div>
                     Kopi: Kebun Kopi Petarangan
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_a78c1e4d5ef213137c5b60421290161a.setIcon(icon_d0dfe236ed0e8be27ca25676a6491cb0);
            
    
            feature_group_d7d492f93612d7767d14c387bcb11c5b.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var feature_group_4ead5eebf77e8ad427e29793a3558d60 = L.featureGroup(
                {
}
            );
        
    
            var marker_3cf8aa0597cc7a7da372db48aeb32dd2 = L.marker(
                [-7.528, 109.288],
                {
}
            ).addTo(feature_group_4ead5eebf77e8ad427e29793a3558d60);
        
    
            var icon_5485dbc64eb697adc8a8150e8e0ca9e8 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#7FB069",
  "icon": "leaf",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_66bf273e1145a3150da78dd3760e2c7a = L.popup({
  "maxWidth": 360,
});

        
            
                var html_f8a815e31359f7e4ca0f9f47e7559d5f = $(`<div id="html_f8a815e31359f7e4ca0f9f47e7559d5f" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#7FB069;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Durian</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Kebun Durian Alasmalang         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Alasmalang, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Sentra durian lokal varietas Bhinneka & Petruk, panen Nov–Feb.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Pak Hadi — WA 0813xxx       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★★           <span style="color:#333;font-size:13px;margin-left:6px;">             4.8/5.0           </span>           <span style="color:#999;font-size:11px;">             (4 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Galih S.</b>             <span style="color:#888;">5 hari lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Durian Petruk-nya legit, manis-pahit pas. Bisa makan di tempat di gubug kebun.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Mira A.</b>             <span style="color:#888;">3 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Pengalaman seru petik durian langsung. Harga jauh lebih murah dari pasar.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Doni Wira</b>             <span style="color:#888;">2 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Musim ramai harus pesan dulu, sering kehabisan. Suasana kebun asri.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Eka L.</b>             <span style="color:#888;">5 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Saya bawa rombongan keluarga, semua puas. Cocok untuk paket agrowisata.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_66bf273e1145a3150da78dd3760e2c7a.setContent(html_f8a815e31359f7e4ca0f9f47e7559d5f);
            
        

        marker_3cf8aa0597cc7a7da372db48aeb32dd2.bindPopup(popup_66bf273e1145a3150da78dd3760e2c7a)
        ;

        
    
    
            marker_3cf8aa0597cc7a7da372db48aeb32dd2.bindTooltip(
                `<div>
                     Durian: Kebun Durian Alasmalang
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_3cf8aa0597cc7a7da372db48aeb32dd2.setIcon(icon_5485dbc64eb697adc8a8150e8e0ca9e8);
            
    
            var marker_9d8271eaa4d5472f3142cf3f6371f0ac = L.marker(
                [-7.542, 109.322],
                {
}
            ).addTo(feature_group_4ead5eebf77e8ad427e29793a3558d60);
        
    
            var icon_f7c5a4c64fbc0bb2791c7860618b899e = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#7FB069",
  "icon": "leaf",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_b0e2a8a7d10005cd5cc7bd00bbbaac56 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_dd6e17612f12a9824374e7929a47e99a = $(`<div id="html_dd6e17612f12a9824374e7929a47e99a" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#7FB069;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Durian</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Sentra Durian Grujugan         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Grujugan, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Kebun komunal warga, ±60 pohon produktif, varietas lokal.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Poktan Grujugan Lestari       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★☆           <span style="color:#333;font-size:13px;margin-left:6px;">             4.5/5.0           </span>           <span style="color:#999;font-size:11px;">             (2 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Rendy P.</b>             <span style="color:#888;">2 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Durian-nya enak, tapi belum ada papan nama jalan, agak susah cari lokasi.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Sinta</b>             <span style="color:#888;">1 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Worth-it. Petani ramah, bisa pilih sendiri buahnya.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_b0e2a8a7d10005cd5cc7bd00bbbaac56.setContent(html_dd6e17612f12a9824374e7929a47e99a);
            
        

        marker_9d8271eaa4d5472f3142cf3f6371f0ac.bindPopup(popup_b0e2a8a7d10005cd5cc7bd00bbbaac56)
        ;

        
    
    
            marker_9d8271eaa4d5472f3142cf3f6371f0ac.bindTooltip(
                `<div>
                     Durian: Sentra Durian Grujugan
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_9d8271eaa4d5472f3142cf3f6371f0ac.setIcon(icon_f7c5a4c64fbc0bb2791c7860618b899e);
            
    
            var marker_58ba9f9be72f54f98c407bbe061c687b = L.marker(
                [-7.582, 109.318],
                {
}
            ).addTo(feature_group_4ead5eebf77e8ad427e29793a3558d60);
        
    
            var icon_2fd8a45923f316a0069a7296c61f2a68 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#7FB069",
  "icon": "leaf",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_b160646304787e6a69a0ad0b0c9dbafb = L.popup({
  "maxWidth": 360,
});

        
            
                var html_1e1049e73f60fe9b93de03fa527e7f2e = $(`<div id="html_1e1049e73f60fe9b93de03fa527e7f2e" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#7FB069;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Durian</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Kebun Durian Sibalung         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Sibalung, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Sentra durian baru berkembang, kerjasama dengan BUMDes.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> BUMDes Sibalung       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★☆           <span style="color:#333;font-size:13px;margin-left:6px;">             4.0/5.0           </span>           <span style="color:#999;font-size:11px;">             (1 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Yusuf H.</b>             <span style="color:#888;">3 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Baru pertama kali ke sini, durian montong-nya besar-besar.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_b160646304787e6a69a0ad0b0c9dbafb.setContent(html_1e1049e73f60fe9b93de03fa527e7f2e);
            
        

        marker_58ba9f9be72f54f98c407bbe061c687b.bindPopup(popup_b160646304787e6a69a0ad0b0c9dbafb)
        ;

        
    
    
            marker_58ba9f9be72f54f98c407bbe061c687b.bindTooltip(
                `<div>
                     Durian: Kebun Durian Sibalung
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_58ba9f9be72f54f98c407bbe061c687b.setIcon(icon_2fd8a45923f316a0069a7296c61f2a68);
            
    
            feature_group_4ead5eebf77e8ad427e29793a3558d60.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var feature_group_1bdda221809a727a17a8732dd1122517 = L.featureGroup(
                {
}
            );
        
    
            var marker_cb879555be3b95fddcac053e714cf126 = L.marker(
                [-7.552, 109.307],
                {
}
            ).addTo(feature_group_1bdda221809a727a17a8732dd1122517);
        
    
            var icon_ae315bc9262fe120d2037503f0c8bd34 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#D4A017",
  "icon": "industry",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_9b80884de20593a942629891ec3c0c11 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_82dbfed09ff9b68b3f5088e0a5f00718 = $(`<div id="html_82dbfed09ff9b68b3f5088e0a5f00718" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#D4A017;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Gula Kelapa</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Pengrajin Gula Semut Kebarongan         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Kebarongan, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Kelompok pengrajin gula semut organik, sudah ekspor ke Eropa.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Koperasi Nira Mukti Kebarongan       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★★           <span style="color:#333;font-size:13px;margin-left:6px;">             4.7/5.0           </span>           <span style="color:#999;font-size:11px;">             (3 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Diana O.</b>             <span style="color:#888;">1 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Gula semutnya wangi banget, halus, dan benar-benar organik. Cocok jadi oleh-oleh.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Pram</b>             <span style="color:#888;">1 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Bisa lihat proses pembuatannya dari nira sampai jadi gula semut, sangat edukatif.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Lila</b>             <span style="color:#888;">2 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Kemasannya sudah cantik, sayang display di workshop masih sederhana.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_9b80884de20593a942629891ec3c0c11.setContent(html_82dbfed09ff9b68b3f5088e0a5f00718);
            
        

        marker_cb879555be3b95fddcac053e714cf126.bindPopup(popup_9b80884de20593a942629891ec3c0c11)
        ;

        
    
    
            marker_cb879555be3b95fddcac053e714cf126.bindTooltip(
                `<div>
                     Gula Kelapa: Pengrajin Gula Semut Kebarongan
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_cb879555be3b95fddcac053e714cf126.setIcon(icon_ae315bc9262fe120d2037503f0c8bd34);
            
    
            var marker_dc6d93d46df8f75995f81d7369ac55c9 = L.marker(
                [-7.557, 109.293],
                {
}
            ).addTo(feature_group_1bdda221809a727a17a8732dd1122517);
        
    
            var icon_051c89ae6c2d1c6ba38009510e6e0ed6 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#D4A017",
  "icon": "industry",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_9f38d9791fcbbc86151a5ad20aeffa97 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_c771c24d198f31c90c807486b5c04506 = $(`<div id="html_c771c24d198f31c90c807486b5c04506" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#D4A017;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Gula Kelapa</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Sentra Gula Kelapa Karangjati         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Karangjati, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Sentra penderes tradisional, ±80 KK penderes aktif.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Paguyuban Penderes Karangjati       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★☆           <span style="color:#333;font-size:13px;margin-left:6px;">             4.5/5.0           </span>           <span style="color:#999;font-size:11px;">             (2 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Andi M.</b>             <span style="color:#888;">2 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">Gula cetak tradisionalnya autentik, beda sama yang di pasar modern.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Wulan</b>             <span style="color:#888;">3 minggu lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Tour memanjat pohon kelapa-nya seru sekali, pengalaman langka.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_9f38d9791fcbbc86151a5ad20aeffa97.setContent(html_c771c24d198f31c90c807486b5c04506);
            
        

        marker_dc6d93d46df8f75995f81d7369ac55c9.bindPopup(popup_9f38d9791fcbbc86151a5ad20aeffa97)
        ;

        
    
    
            marker_dc6d93d46df8f75995f81d7369ac55c9.bindTooltip(
                `<div>
                     Gula Kelapa: Sentra Gula Kelapa Karangjati
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_dc6d93d46df8f75995f81d7369ac55c9.setIcon(icon_051c89ae6c2d1c6ba38009510e6e0ed6);
            
    
            var marker_9bcc3c0e4c73018896d545b77cecd7b6 = L.marker(
                [-7.588, 109.278],
                {
}
            ).addTo(feature_group_1bdda221809a727a17a8732dd1122517);
        
    
            var icon_f10f619a42710dd81a7d9ec730dce8b6 = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#D4A017",
  "icon": "industry",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_dc7c146fa474706cfbc210eba005fba8 = L.popup({
  "maxWidth": 360,
});

        
            
                var html_7ff82c1c3a637c4641e85c795acd221c = $(`<div id="html_7ff82c1c3a637c4641e85c795acd221c" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#D4A017;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Gula Kelapa</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Workshop Gula Semut Nusamangir         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Nusamangir, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         BUMDes Nusamangir mengelola workshop edukasi gula semut.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> BUMDes Nusamangir       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★★☆           <span style="color:#333;font-size:13px;margin-left:6px;">             4.5/5.0           </span>           <span style="color:#999;font-size:11px;">             (2 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Hendra</b>             <span style="color:#888;">1 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★☆</div>           <div style="color:#333;margin-top:2px;">Paket edukasi anak menarik, ada sesi cetak gula sendiri.</div>         </div>                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Tata D.</b>             <span style="color:#888;">2 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★★★</div>           <div style="color:#333;margin-top:2px;">BUMDes-nya aktif, produk gula semutnya rapi packaging-nya.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_dc7c146fa474706cfbc210eba005fba8.setContent(html_7ff82c1c3a637c4641e85c795acd221c);
            
        

        marker_9bcc3c0e4c73018896d545b77cecd7b6.bindPopup(popup_dc7c146fa474706cfbc210eba005fba8)
        ;

        
    
    
            marker_9bcc3c0e4c73018896d545b77cecd7b6.bindTooltip(
                `<div>
                     Gula Kelapa: Workshop Gula Semut Nusamangir
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_9bcc3c0e4c73018896d545b77cecd7b6.setIcon(icon_f10f619a42710dd81a7d9ec730dce8b6);
            
    
            var marker_9d51e949ede50561823b1dd36c9943f9 = L.marker(
                [-7.592, 109.302],
                {
}
            ).addTo(feature_group_1bdda221809a727a17a8732dd1122517);
        
    
            var icon_f06464486be57f381550e9b92749259e = L.AwesomeMarkers.icon(
                {
  "markerColor": "white",
  "iconColor": "#D4A017",
  "icon": "industry",
  "prefix": "fa",
  "extraClasses": "fa-rotate-0",
}
            );
        
    
        var popup_ce702d65e203e147e4a5267864eb2a1e = L.popup({
  "maxWidth": 360,
});

        
            
                var html_736d6316b0671e7dc815b4c3a402a879 = $(`<div id="html_736d6316b0671e7dc815b4c3a402a879" style="width: 100.0%; height: 100.0%;">     <div style="font-family:Arial,sans-serif;width:320px;">       <div style="background:#D4A017;color:white;padding:8px 10px;                   margin:-9px -9px 8px -9px;border-radius:3px 3px 0 0;">         <div style="font-size:10px;text-transform:uppercase;letter-spacing:1px;                     opacity:0.85;">PUD — Gula Kelapa</div>         <div style="font-size:14px;font-weight:700;margin-top:2px;">           Pengrajin Gula Kelapa Sirau         </div>         <div style="font-size:11px;margin-top:2px;opacity:0.9;">           Desa Sirau, Kec. Kemranjen         </div>       </div>        <div style="font-size:12px;color:#444;margin-bottom:6px;">         Pengrajin gula kelapa cetak skala rumahan, belum terorganisir koperasi.       </div>       <div style="font-size:11px;color:#666;margin-bottom:8px;">         <b>Kontak:</b> Belum ada kontak resmi       </div>        <div style="background:#f8f8f8;padding:6px 8px;border-radius:4px;                   margin-bottom:6px;">         <div style="font-size:11px;color:#666;">           <b>Rating Google (simulasi)</b>         </div>         <div style="font-size:18px;color:#f5a623;line-height:1.2;">           ★★★☆☆           <span style="color:#333;font-size:13px;margin-left:6px;">             3.0/5.0           </span>           <span style="color:#999;font-size:11px;">             (1 ulasan)           </span>         </div>       </div>        <div style="font-size:11px;color:#666;font-weight:600;                   margin:6px 0 2px 0;">         Ulasan Terbaru:       </div>       <div style="max-height:200px;overflow-y:auto;">                  <div style="border-top:1px solid #eee;padding:6px 0;font-size:11px;">           <div style="display:flex;justify-content:space-between;">             <b>Bayu A.</b>             <span style="color:#888;">1 bulan lalu</span>           </div>           <div style="color:#f5a623;font-size:13px;">★★★☆☆</div>           <div style="color:#333;margin-top:2px;">Produknya bagus tapi distribusi terbatas. Perlu bantuan branding.</div>         </div>                </div>        <div style="margin-top:8px;padding-top:6px;border-top:1px solid #eee;                   font-size:10px;color:#999;text-align:center;">         Data ulasan: <i>dummy / demonstrasi PoC</i>       </div>     </div>     </div>`)[0];
                popup_ce702d65e203e147e4a5267864eb2a1e.setContent(html_736d6316b0671e7dc815b4c3a402a879);
            
        

        marker_9d51e949ede50561823b1dd36c9943f9.bindPopup(popup_ce702d65e203e147e4a5267864eb2a1e)
        ;

        
    
    
            marker_9d51e949ede50561823b1dd36c9943f9.bindTooltip(
                `<div>
                     Gula Kelapa: Pengrajin Gula Kelapa Sirau
                 </div>`,
                {
  "sticky": true,
}
            );
        
    
                marker_9d51e949ede50561823b1dd36c9943f9.setIcon(icon_f06464486be57f381550e9b92749259e);
            
    
            feature_group_1bdda221809a727a17a8732dd1122517.addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var layer_control_446c95e9267db3e9fc5986d26b1801ac_layers = {
                base_layers : {
                    "openstreetmap" : tile_layer_4495f73cdd92af1dfc1a46afd0d3951c,
                    "Citra Satelit" : tile_layer_870d4b2435c0c6e1e2206f8121ca124d,
                },
                overlays :  {
                    "Batas Kecamatan" : geo_json_bb2676130288253882134cd5ce6499a1,
                    "Batas Desa (15 desa)" : feature_group_2f07059e89e2ae0cb438d207b7fb3a5a,
                    "PUD: Kopi" : feature_group_d7d492f93612d7767d14c387bcb11c5b,
                    "PUD: Durian" : feature_group_4ead5eebf77e8ad427e29793a3558d60,
                    "PUD: Gula Kelapa" : feature_group_1bdda221809a727a17a8732dd1122517,
                },
            };
            let layer_control_446c95e9267db3e9fc5986d26b1801ac = L.control.layers(
                layer_control_446c95e9267db3e9fc5986d26b1801ac_layers.base_layers,
                layer_control_446c95e9267db3e9fc5986d26b1801ac_layers.overlays,
                {
  "position": "topright",
  "collapsed": false,
  "autoZIndex": true,
}
            ).addTo(map_14cd1993c786ac8fc653b5d09c14d823);

        
    
            L.control.fullscreen(
                {
  "position": "topright",
  "title": "Full Screen",
  "titleCancel": "Exit Full Screen",
  "forceSeparateButton": false,
}
            ).addTo(map_14cd1993c786ac8fc653b5d09c14d823);
        
    
            var measure_control_8a9c265006a29aa590b474cfc39de39e = new L.Control.Measure(
                {
  "position": "topright",
  "primaryLengthUnit": "meters",
  "secondaryLengthUnit": "miles",
  "primaryAreaUnit": "sqmeters",
  "secondaryAreaUnit": "acres",
});
            map_14cd1993c786ac8fc653b5d09c14d823.addControl(measure_control_8a9c265006a29aa590b474cfc39de39e);

            // Workaround for using this plugin with Leaflet>=1.8.0
            // https://github.com/ljagis/leaflet-measure/issues/171
            L.Control.Measure.include({
                _setCaptureMarkerIcon: function () {
                    // disable autopan
                    this._captureMarker.options.autoPanOnFocus = false;
                    // default function
                    this._captureMarker.setIcon(
                        L.divIcon({
                            iconSize: this._map.getSize().multiplyBy(2)
                        })
                    );
                },
            });

        
</script>
</html>