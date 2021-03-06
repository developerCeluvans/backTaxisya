@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')
<!--subgroup-->
<div class="boxtitle min">Información</div>
<!--<form id="validation_demo" action=""> -->
{{Form::open($section.'/$action','POST',array('id'=>'create_'.$section))}}
{{Form::token()}}
<div class="row-fluid">
    @if(isset($subgroup))
    <div class="section" style="display: block;">
        <?php foreach ($subgroup as $key => $group) { ?>
            <?php foreach ($group as $groupTitle => $groupSection) { ?>
                <a class = "btn  btn-large " href = "javascript:dataPoster('{{$groupSection}}-{{$idToEdit}}-group')"><i class = "icon-exclamation-sign"></i>{{$groupTitle}}</a>
            <?php } ?>
            <?php
        }
        ?> 
    </div>
    @endif
    <script src="components/juploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="components/juploadify/uploadify.css">
    <?php $uploadOptions = ""; ?>
    @forelse($formTemplate as $key=>$row)
    <label> {{$row['title']['0']}} <small> {{$row['title']['1']}} </small> </label>   
    <div class="section">
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
        if (isset($row['varyName'])) {
            echo ",'prefix':'" . Auth::user()->id . "'";
        }
        ?>
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
                        'auto': <?php echo (isset($row['auto'])) ? "true" : "false"; ?>,
                        'swf': 'components/juploadify/uploadify.swf',
        <?php if (isset($row['onUploaded'])) { ?>
                            'onUploadSuccess' : function(file, data, response) {
                            alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
                            },
        <?php } ?>
        <?php echo (isset($row['fileObjName'])) ? "'fileObjName' :" . $row['fileObjName'] . "" : ''; ?>
                        'uploader': <?php echo (isset($row['fileUploader'])) ? "'" . $row['fileUploader'] . "'" : "'components/juploadify/uploadify.php'"; ?>
                        });
                        });</script>
                    <?php
                    $uploadOptions.="$(\"#" . $row["name"] . "\").uploadify(\"upload\",\"*\");"; //javascript:
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
                case 'textarea':
                    echo Form::textarea($row['name'], $row['value'], $row['attributes']);
                    ?>
                    <span class="f_help"> Límite de caracteres <span class="{{$row['name']}}1"></span></span>
                    <?php if (isset($row['attributes']['id']) && isset($row['limit'])) { ?>
                        <script type="text/javascript">
                            $('#{{$row['attributes']['id']}}').limit('{{$row['limit']}}', '.{{$row['name']}}1');</script>
                        <?php
                    }
                    break;
                case 'reset':
                    //public static function reset($value = null, $attributes = array())
                    echo Form::reset($row['value'], $row['attributes']);
                    break;
                case 'button':
                    //public static function button($value = null, $attributes = array())
                    echo Form::button($row['value'], $row['attributes']);
                    break;
                case 'timePicker':
                    echo Form::text($row['name'], $row['value'], $row['attributes']);
                    ?>
                    <script type="text/javascript">
                        $('input[name="{{$row['name']}}"]').timepicker({});</script>
                    <?php
                    break;
                case 'datePicker':
                    echo Form::text($row['name'], date('m/d/Y', strtotime($row['value'])), $row['attributes']);
                    //<input type = "text" class = "validate[required] large" value = "" name = "pay_date" id = "pay_date" tabindex = "1">
                    ?>
                    <span class="f_help"></span>
                    <script type="text/javascript">
                        $("#{{$row['attributes']['id']}}").datepicker().mask("99/99/9999");</script>
                    <?php
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
                case 'formCloning':
                    ?>
                    <div id="">
                        <!-- Form template-->
                        <div id="appendHere">
                            <div id="cloneFormTemplate">
                                <div class="section">
                                    <?php
                                    $tmpAttributes = $row['attributes'];
                                    $tmpAttributes['id'] = $tmpAttributes['id'] . '1';
                                    if (isset($row['selected']) && $row['selected'] != "") {
                                        //dd($row['selected']);
                                        if (count($row['selected']) > 0) {
                                            //dd($tmpAttributes);
                                            ?>
                                            {{Form::select($row['name']."[1]", $row['options'],$row['selected'][0][0],$tmpAttributes)}}
                                            <a id="cloneForm_remove_current" class="clone-delete" style="display: none" ><i class="icon-remove"></i></a>
                                        <!--<select id="servicioType1" name="servicioType[1]" class="chzn-select">
                                            <option>TAles</option>
                                            <option>TAles2</option>
                                        </select>-->
                                        <!--<input type="text"  id="servicioCant1" name="servicioCant[1]" class="small" />--> 
                                            <input type="text" id="{{$row['name'].'Cant1'}}" name="{{$row['name'].'Cant[1]'}}" value="{{$row['selected'][0][1]}}" class="small">
                                            <?php
                                        } else {
                                            ?>
                                            {{Form::select($row['name']."[1]", $row['options'],'', $tmpAttributes)}}
                                            <a id="cloneForm_remove_current" class="clone-delete" style="display: none"><i class="icon-remove"></i></a>
                                            <!--<select id="servicioType1" name="servicioType[1]" class="chzn-select">
                                                <option>TAles</option>
                                                <option>TAles2</option>
                                            </select>-->
                                            <!--<input type="text"  id="servicioCant1" name="servicioCant[1]" class="small" />--> 
                                            <input type="text" id="{{$row['name'].'Cant1'}}" name="{{$row['name'].'Cant[1]'}}" class="small">
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        {{Form::select($row['name']."[1]", $row['options'],'', $tmpAttributes)}}
                                        <a id="cloneForm_remove_current" class="clone-delete" style="display: none"><i class="icon-remove"></i></a>
                                            <!--<select id="servicioType1" name="servicioType[1]" class="chzn-select">
                                                <option>TAles</option>
                                                <option>TAles2</option>
                                            </select>-->
                                            <!--<input type="text"  id="servicioCant1" name="servicioCant[1]" class="small" />--> 
                                        <input type="text" id="{{$row['name'].'Cant1'}}" name="{{$row['name'].'Cant[1]'}}" class="small">
                                    <?php }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($row['selected']) && $row['selected'] != "") {
                                //dd($row['selected']);
                                if (count($row['selected']) > 1) {
                                    $newCurrent = 1;
                                    foreach ($row['selected'] as $key => $selectedOps) {
                                        if ($key == 0) {
                                            continue;
                                        }
                                        $newCurrent++;
                                        $tmpAttributes = $row['attributes'];
                                        $tmpAttributes['id'] = $tmpAttributes['id'] . $newCurrent;
                                        //dd($tmpAttributes);
                                        ?>
                                        <div class="section">
                                            {{Form::select($row['name']."[".$newCurrent."]", $row['options'],$selectedOps[0], $tmpAttributes)}}
                                            <a class="clone-delete"><i class="icon-remove"></i></a>
                                            <!--<select id="servicioType1" name="servicioType[1]" class="chzn-select">
                                            <option>TAles</option>
                                            <option>TAles2</option>
                                            </select>-->
                                            <!--<input type="text"  id="servicioCant1" name="servicioCant[1]" class="small" />--> 
                                            <input type="text" id="{{$row['name'].'Cant'.$newCurrent}}" name="{{$row['name'].'Cant['.$newCurrent.']'}}" value="<?php echo isset($selectedOps[1]) ? $selectedOps[1] : ''; ?>" class="small">
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div id="cloneForm_noforms_template">
                        <div class="alert alert-block  alert-info"> Selecciona servicios a agregar y definir <strong> cantidad </strong>.</div>
                    </div>
                    <div class="section last">
                        <div id="cloneForm_controls">
                            <span id="addNew" class="tip"><a class="btn btn-large" title="New input"><i class="icon-plus"></i> New input</a></span>
                            <span id="removelast" class="tip"><a class="btn btn-large" title="Remove"><i class="icon-trash"></i></a></span>
                            <span id="removeall" class="tip"><a class="btn btn-large btn-danger" title="Remove All">Remove All</a></span>
                        </div>
                    </div>
                    <script>
                        var current = <?php echo isset($newCurrent) ? $newCurrent : '1'; ?>;
                        $('#addNew').on('click', function(){
                        //console.log($("#appendHere").children().length);
                        var optionsCant = $("#appendHere").children().length;
                        if (optionsCant >= 4){
                        alert("No se pueden seleccionar más de 4 servicios por plan");
                        } else{
                        current++;
                        var clone = $('#cloneFormTemplate').clone();
                        //console.log(clone.html());
                        //                                clone.find('select').attr({'id': 'servicioType' + current, 'name':'servicioType[' + current + ']'});
                        //                                clone.find('input').attr({'id': 'servicioCant' + current, 'name':'servicioCant[' + current + ']'});
                        clone.find('div.chzn-container').remove();
                        clone.find('select').removeAttr('style').removeAttr('class');
                        clone.find('select').attr({'id': '{{$row['name']}}' + current, 'name':'{{$row['name']}}[' + current + ']'});
                        clone.find('select').find('option').removeAttr("selected");
                        clone.find('a.clone-delete').removeAttr("style").live('click', function(){$(this).parent().remove(); });
                        clone.find('select').find('option').first().attr({'selected':'selected'}).change();
                        clone.find('input').attr({'id': '{{$row['name']}}Cant' + current, 'name':'{{$row['name']}}Cant[' + current + ']', 'value':'1'});
                        //clone.find('a.selectBox').remove();

                        /*clone.find('.clone-delete').bind('click', function(){
                        console.log('WTF?');
                        $(this).parent().remove();
                        });*/

                        $('#appendHere').append(clone.html());
                        //console.log($('#appendHere').find('#servicioType' + current).length);
                        //$('#appendHere').find('#servicioType' + current).selectBox();
                        //
                        //                                $('#appendHere').find('#servicioType' + current).chosen();
                        $('#appendHere').find('#{{$row['name']}}' + current).chosen();
                        }
                        });
                        $('a.clone-delete').on('click', function(){
                        $(this).parent().remove();
                        });
                        $('#removelast').on('click', function(){
                        if (current != 1){
                        current--;
                        $('#appendHere').find('.section').last().remove();
                        }
                        });
                        $('#removeall').on('click', function(){
                        current = 1;
                        $('#appendHere > .section').remove();
                        }

                        )
                    </script>
                </div>        
                <?php
                break;
            case "probe":
                ?>

                <?php
                break;
            default:
                /*
                  public static function text($name, $value = null, $attributes = array())
                  public static function hidden($name, $value = null, $attributes = array())
                  public static function search($name, $value = null, $attributes = array())
                  public static function email($name, $value = null, $attributes = array())
                  public static function telephone($name, $value = null, $attributes = array())
                  public static function url($name, $value = null, $attributes = array())
                  public static function number($name, $value = null, $attributes = array())
                  public static function date($name, $value = null, $attributes = array())
                  public static function textarea($name, $value = '', $attributes = array())
                 */
                echo Form::$row['type']($row['name'], $row['value'], $row['attributes']);
                break;
        }
        ?>
    </div>
</div>
@empty
@endforelse

<script type="text/javascript">
    //$('#bookKeyTerms').tagsInput({width: 'auto'});
    //$('#bookAuthors').tagsInput({width: 'auto'});
    $.configureBoxes();
    //$('#bookDescription').limit('250', '.limitchars1');
    $("select").not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage,select#maker,select#model,select#feature").selectBox();
    // Mutiselection
    $(".chzn-select").chosen();</script>
<div class="section last">
    <div>
        <!-- <a class="btn submit_form" >Submit</a> -->
        <a class="btn" id="{{$section}}-{{$idToEdit}}-{{$action}}" >Guardar</a><!--onclick='<?php echo $uploadOptions; ?>formPoster(this.id);-->
    </div>
</div>
</div>
<script type="text/javascript">
    document.getElementById('{{$section}}-{{$idToEdit}}-{{$action}}').onclick = function(){
    <?php
    if (isset($uploadOptions) && $uploadOptions != NULL) {

        echo $uploadOptions;
        ?>
        setTimeout('formPoster("{{$section}}-{{$idToEdit}}-{{$action}}")', 2000);
    <?php } else { ?>
        formPoster(this.id);
    <?php } ?>

    };
    $("#extExcel").hide();
</script>
</div><!-- row-fluid -->
{{Form::close()}}
<!-- </form> -->
@endsection

