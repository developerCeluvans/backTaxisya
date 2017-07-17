@layout('layouts.table')
@section('title')
    {{$title}}
@endsection
@section('contentTable')

    <div class="boxtitle min">Información</div>
    <!--<form id="validation_demo" action=""> -->
    {{Form::open($section.'/$action','POST',array('id'=>'create_'.$section))}}
    {{Form::token()}}

    <div class="row-fluid">
        <script src="components/juploadify/jquery.uploadify.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="components/juploadify/uploadify.css">
        <?php $uploadOptions = " "; ?>





    <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
        {{ Form::label('address', 'Ciudad: ', ['class' => 'col-sm-3 control-label']) }}
        <div class="col-sm-6">
            {{ Form::text('address', null, ['class' => 'form-control', 'required' => 'required']) }}
            {{ $errors->first('address', '<p class="help-block">:message</p>') }}

            <a href="#" class="btn btn-primary pull-right btn-sm" id="search-btn">Buscar Ciudad</a>

        </div>
    </div>

    <div class="col-sm-6">
        <div id="map-canvas" style="width: auto; height: 150px"></div>

    </div>

    <div class="form-group {{ $errors->has('latitude') ? 'has-error' : ''}}">
        {{ Form::label('latitude', 'Latitude: ', ['class' => 'col-sm-3 control-label']) }}
        <div class="col-sm-6">
            {{ Form::number('latitude', null, ['class' => 'form-control']) }}
            {{ $errors->first('latitude', '<p class="help-block">:message</p>') }}
        </div>
    </div>
    <div class="form-group {{ $errors->has('longitude') ? 'has-error' : ''}}">
        {{ Form::label('longitude', 'Longitude: ', ['class' => 'col-sm-3 control-label']) }}
        <div class="col-sm-6">
            {{ Form::number('longitude', null, ['class' => 'form-control', 'required' => 'required']) }}
            {{ $errors->first('longitude', '<p class="help-block">:message</p>') }}
        </div>
    </div>








        @forelse($formTemplate as $key=>$row)
            <label> {{$row['title']['0']}}
                <small> {{$row['title']['1']}} </small>
            </label>
            <div class="section ">
                <div>
                    <?php
                    switch ($row['type']){
                    case 'select':
//public static function select($name, $options = array(), $selected = null, $attributes = array())
                        echo Form::select($row['name'], $row['options'], $row['selected'], $row['attributes']);
                        break;
                    case 'password':
//public static function password($name, $attributes = array())
                        echo Form::password($row['name'], $row['attributes']);
                        break;
                    case 'file':
                    //public static function file($name, $attributes = array())
                    //echo Form::file($row['name'], $row['attributes']);
                    ?>
                    <div id="queue"></div>
                    <?php echo Form::file($row['name'], $row['attributes']); ?>
                    <script type="text/javascript">
                        <?php $timestamp = time(); ?>
                        $(function () {
                            $('#{{$row["name"]}}').uploadify({
                                'formData': {
                                    'timestamp': '<?php echo $timestamp; ?>',
                                    'token': '<?php echo md5('unique_salt' . $timestamp); ?>',
                                    'rs': '<?php echo $row['folderURL']; ?>'
                                    <?php
                                    if (isset($row['dataType'])) {
                                        echo ",'vdt':" . $row['dataType'] . "";
                                    }
                                    ?>


                                    <?php
                                    if (isset($row['defaultName'])) {
                                        echo ",'dfn':" . $row['defaultName'] . "";
                                    }
                                    ?>
                                },
                                'fileSizeLimit': '10000KB',
                                'auto': false,
                                'swf': 'components/juploadify/uploadify.swf',
                                'uploader': 'components/juploadify/uploadify.php'
                            });
                        });</script>
                    <?php
                    $uploadOptions .= "javascript:$(\"#" . $row["name"] . "\").uploadify(\"upload\",\"*\");";
                    break;
                    case 'checkbox':
                        //public static function checkbox($name, $value = 1, $checked = false, $attributes = array())
                        echo Form::checkbox($row['name'], $row['value'], $row['checked'], $row['attributes']);
                        break;
                    case 'radio':
                        //public static function radio($name, $value = null, $checked = false, $attributes = array())
                        echo Form::radio($row['name'], $row['value'], $row['checked'], $row['attributes']);
                        break;
                    case 'image':
                        //public static function image($url, $name = null, $attributes = array())
                        echo Form::image($row['url'], $row['name'], $row['attributes']);
                        break;
                    case 'reset':
                        //public static function reset($value = null, $attributes = array())
                        echo Form::reset($row['value'], $row['attributes']);
                        break;
                    case 'button':
                        //public static function button($value = null, $attributes = array())
                        echo Form::button($row['value'], $row['attributes']);
                        break;
                    case 'submit':
                        //public static function submit($value = null, $attributes = array())
                        echo Form::submit($row['value'], $row['attributes']);
                        break;
                    case 'video':
                    ?>
                    <video width="320" height="240" controls>
                        <source src="movie.mp4" type="video/mp4">
                        <source src="movie.ogg" type="video/ogg">
                        Your browser does not support the video tag.
                    </video>
                    <?php
                    break;
                    case 'datePicker':
                    echo Form::text($row['name'], date('m/d/Y', strtotime($row['value'])), $row['attributes']);
                    ?>
                    <span class="f_help"></span>
                    <script type="text/javascript">
                        $("#{{$row['attributes']['id']}}").datepicker().mask("99/99/9999");
                        $('#datepicker').datepicker({dateFormat: 'dd-mm-yy'}).val();</script>
                    <?php
                    break;
                    default:
                        echo Form::$row['type']($row['name'], $row['value'], $row['attributes']);
                        break;
                    }
                    ?>
                </div>
            </div>
        @empty
        @endforelse

        <script type="text/javascript">
            $("#extExcel").hide();
            $('#bookKeyTerms').tagsInput({width: 'auto'});
            $('#bookAuthors').tagsInput({width: 'auto'});
            $.configureBoxes();
            $('#bookDescription').limit('250', '.limitchars1');
            $("select").not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage,select#maker,select#model,select#feature").selectBox();
            // Mutiselection
            $(".chzn-select").chosen();
        </script>
        <div class="section last">
            <div>
                <!-- <a class="btn submit_form" >Submit</a> -->
                <a class="btn" id="{{$section}}-{{$idToEdit}}-{{$action}}"
                   onclick='<?php echo $uploadOptions; ?>formPoster(this.id)'>Guardar</a>
            </div>
        </div>
    </div>

    </div><!-- row-fluid -->









    {{Form::close()}}
    <!-- </form> -->



    <script type="text/javascript">
        /*
         * Google Maps: Latitude-Longitude Finder Tool
         * http://salman-w.blogspot.com/2009/03/latitude-longitude-finder-tool.html
         */
        function loadmap() {
            // TODO
            // cargar las coordenadas si se esta editando la ciudad
            // initialize map
            var map = new google.maps.Map(document.getElementById("map-canvas"), {
                center: new google.maps.LatLng(4.648323, -74.107807),
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            // initialize marker
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                draggable: true,
                map: map
            });
            // intercept map and marker movements
            google.maps.event.addListener(map, "idle", function () {
                marker.setPosition(map.getCenter());
                document.getElementById("latitude").value = map.getCenter().lat().toFixed(6);
                document.getElementById("longitude").value = map.getCenter().lng().toFixed(6);
            });
            google.maps.event.addListener(marker, "dragend", function (mapEvent) {
                map.panTo(mapEvent.latLng);
                geocoder.geocode({address: document.getElementById("address").value}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var result = results[0];

                        document.getElementById("address").value = result.formatted_address;
                        document.getElementById("latitude").value = map.getCenter().lat().toFixed(6);
                        document.getElementById("longitude").value = map.getCenter().lng().toFixed(6);

                        if (result.geometry.viewport) {
                            map.fitBounds(result.geometry.viewport);
                        } else {
                            map.setCenter(result.geometry.location);
                        }
                    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                        alert("Sorry, geocoder API failed to locate the address.");
                    } else {
                        alert("Sorry, geocoder API failed with an error.");
                    }
                });
            });

            google.maps.event.addListener(map, "click", function () {
                marker.setPosition(map.getCenter());

                getAddress(map.getCenter());


            });

            // initialize geocoder
            var geocoder = new google.maps.Geocoder();
            google.maps.event.addDomListener(document.getElementById("search-btn"), "click", function () {
                geocoder.geocode({address: document.getElementById("address").value}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var result = results[0];

                        document.getElementById("address").value = result.formatted_address;
                        document.getElementById("latitude").value = map.getCenter().lat().toFixed(6);
                        document.getElementById("longitude").value = map.getCenter().lng().toFixed(6);

                        if (result.geometry.viewport) {
                            map.fitBounds(result.geometry.viewport);
                        } else {
                            map.setCenter(result.geometry.location);
                        }
                    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                        alert("Sorry, geocoder API failed to locate the address.");
                    } else {
                        alert("Sorry, geocoder API failed with an error.");
                    }
                });
            });
            google.maps.event.addDomListener(document.getElementById("address"), "keydown", function (domEvent) {
                if (domEvent.which === 13 || domEvent.keyCode === 13) {
                    google.maps.event.trigger(document.getElementById("search-btn"), "click");

                }
            });
            // initialize geolocation
            if (navigator.geolocation) {
                google.maps.event.addDomListener(document.getElementById("detect-btn"), "click", function () {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
                    }, function () {
                        alert("Sorry, geolocation API failed to detect your location.");
                    });
                });
                document.getElementById("detect-btn").disabled = false;
            }
        }





        function getAddress(latLng) {
            geocoder.geocode( {'latLng': latLng},
                    function(results, status) {
                        if(status == google.maps.GeocoderStatus.OK) {
                            if(results[0]) {
                                document.getElementById("address").value = results[0].formatted_address;
                            }
                            else {
                                document.getElementById("address").value = "No results";
                            }
                        }
                        else {
                            document.getElementById("address").value = status;
                        }
                    });
        }
    </script>

    <script src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;callback=loadmap" defer></script>


@endsection
