<?php
// create & initialize a curl session
$curl = curl_init();

// set our url with curl_setopt()
curl_setopt($curl, CURLOPT_URL, "https://furkan-gps-tracker-api.herokuapp.com/api/tracker");

// return the transfer as a string, also with setopt()
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// curl_exec() executes the started curl session
// $output contains the output string
$output = curl_exec($curl);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);

$data = json_decode($output, true)

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <title>Add custom markers in Mapbox GL JS</title>
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .marker {
            background-image: url('png-clipart-dogs-dogs-thumbnail.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div id='map'></div>

<script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiZXZjaWxvbCIsImEiOiJjbDR2NGZ1cjExdTVuM2RzMnhtNjRjd29kIn0.HQO4C82wMJ20ALoWn98hXQ';

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v10',
        center: [35.20951625007283,   39.004098240821996],
        zoom: 3
    });
    const geojson = {
        type: 'FeatureCollection',
        features: [
            {
                type: 'Feature',
                geometry: {
                    type: 'Point',
                    coordinates: [<?= $data[0]["lng"] ?>, <?= $data[0]["lat"] ?>]
                },

                properties: {
                    title: 'Muffy',
                    description: "<php><i class='fa fa-thermometer-empty'>50</i> <\php>",
                }
            },
        ]
    };
    for (const feature of geojson.features) {
        // create a HTML element for each feature
        const el = document.createElement('div');
        el.className = 'marker';
        // make a marker for each feature and add to the map
        new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates)
            .setPopup(
                new mapboxgl.Popup({ offset: 25 }) // add popups
                    .setHTML(
                        `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
                    )
            )
            .addTo(map);

    }
</script>

</body>
</html>
