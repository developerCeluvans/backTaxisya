<!-- <div class="row-fluid"> -->

    <!-- <div class="span8"> -->
        <!-- <div class="section "> -->
            <!-- <label> Nombre -->
                <!-- <small>del país</small> -->
            <!-- </label> -->

            <!-- <div> -->
                <!-- <input type="text" class="validate[required] large" -->
                       <!-- value="<?php echo $items->name; ?>" name="name" id="name"> -->
            <!-- </div> -->

        <!-- </div> -->
    <!-- </div> -->
<!-- </div> -->


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
    @forelse($formTemplate as $key=>$row)
    <label> {{$row['title']['0']}} <small> {{$row['title']['1']}} </small> </label>
    <div class="section ">
        <div >
            <?php
            switch ($row['type']) {
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
                        $(function() {
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
                                'fileSizeLimit' : '10000KB',
                                'auto': false,
                                'swf': 'components/juploadify/uploadify.swf',
                                'uploader': 'components/juploadify/uploadify.php'
                        });
                        });</script>
                    <?php
                    $uploadOptions.="javascript:$(\"#" . $row["name"] . "\").uploadify(\"upload\",\"*\");";
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
                $(".chzn-select").chosen();</script>
    <div class="section last">
        <div>
            <!-- <a class="btn submit_form" >Submit</a> -->
            <a class="btn" id="{{$section}}-{{$idToEdit}}-{{$action}}" onclick='<?php echo $uploadOptions; ?>formPoster(this.id)'>Guardar</a>
        </div>
    </div>
</div>

</div><!-- row-fluid -->
{{Form::close()}}
<!-- </form> -->
@endsection


