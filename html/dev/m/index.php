<head>
    <title>Taxistas</title>

  <?php
    include("config.conf.php");

    error_reporting(E_ALL);

    date_default_timezone_set("America/Bogota");

    $link = mysqli_connect(MB_HOST,MB_USER,MB_PASS,"appsuser_taxisya_de") or die ('No se pudo conectar a la db');
    if (!$link) {
        echo "No connect to db ----  ";
    }


    $a= array();
    $i=0;
    $result= mysqli_query($link,"SELECT id,name,crt_lat,crt_lng FROM `drivers` WHERE available = 1 and crt_lat <> 0");
    while ($val = mysqli_fetch_array( $result )) {
        /*/$b[]=$val["crt_lat"];
        $b[]=$val["crt_lng"];
        $b[]=$val["id"];
        $b[]=$val["name"];
        */
        $a[$i]=array($val["crt_lat"], $val["crt_lng"],$val["id"],$val["name"]);
        $i++;
    }
    //echo json_encode($a);
?>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">

        function initialize() {

            var myOptions = {
                zoom: 16,
                center: new google.maps.LatLng(4.685331, -74.0611077),
                disableDefaultUI: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              }
              var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
              var loc = <?php echo json_encode($a);?>;
              console.log(loc);
              console.log('Hola mundo');
              var bounds = new google.maps.LatLngBounds();

              for (i = 0; i < loc.length; i++) {
                var point = new google.maps.LatLng( loc[i][0], loc[i][1] );
                var marker = new google.maps.Marker({
                    map:        map,
                    position:   point,
                    title:      loc[i][3],
                    visible:    true
                });
                bounds.extend(point);
             }
             map.fitBounds(bounds);


        }

        google.maps.event.addListener(marker1, 'click', (function(marker1, n)
        {
           return function() {
                infowindow.setContent(locationsb[n][0]);
                infowindow.open(map, marker1);
           }
        })(marker1, n));
    </script>

</head>

<body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: auto; height: 650px"></div>
</body>
