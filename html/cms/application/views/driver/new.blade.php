@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')
<div class="boxtitle min">Información de conductor</div>
<!--<form id="validation_demo" action=""> -->
{{Form::open('driver/create','POST',array('id'=>'create_driver'))}}
{{Form::token()}}
<div class="row-fluid">
    <!--
    <div class="span4">
                <div class="profileSetting" >
                    <div class="avartar"><img src="" width="180" height="180" alt="" /></div>
                    <div class="avartar">
                        <input type="file" class="fileupload" />
                        <script type='text/javascript'>
                            // upload
                            $("input.fileupload").filestyle();
                        </script>
                        <p align="center"><span> o </span>Toma una foto con la <a class="takeWebcam">Webcam</a></p>
                    </div>
                </div>
        <hr/>
    </div>

    <div class="span8">
            
        <div class="section webcam">
            <label style="text-transform:initial;"> Take a picture<small>With  webcam</small></label>   
            <div> 
                <div id="screen"></div>
                <div class="buttonPane">
                    <a id="takeButton" class="uibutton">Take Me</a> <a id="closeButton" class="uibutton special">Close</a>
                </div>
                <div class="buttonPane hideme">
                    <a id="uploadAvatar" class="uibutton confirm">Upload Avartar</a> <a id="retakeButton" class="uibutton special">Retake</a> 
                </div>
            </div>
            <script type="text/javascript">
                // Profile webcam 
                var camera = $('#camera'), screen = $('#screen');
                webcam.set_api_url('avartarUpload.php');
                screen.html(webcam.get_html(screen.width(), screen.height()));
                var shootEnabled = false;
                $(".takeWebcam").click(function() {
                    $(".webcam").show('blind');
                    return false;
                });
                $("#closeButton").click(function() {
                    $(".webcam").hide('blind');
                    return false;
                });
                $('#takeButton').click(function() {
                    if (!shootEnabled) {
                        return false;
                    }
                    webcam.freeze();
                    togglePane()
                    return false;
                });
                $('#retakeButton').click(function() {
                    webcam.reset();
                    togglePane()
                    return false;
                });
                $('#uploadAvatar').click(function() {
                    webcam.upload();
                    togglePane()
                    webcam.reset();
                    return false;
                });
                webcam.set_hook('onLoad', function() {
                    shootEnabled = true;
                });
                webcam.set_hook('onError', function(e) {
                    screen.html(e);
                });
                function togglePane() {
                    var visible = $(' .buttonPane:visible:first');
                    var hidden = $(' .buttonPane:hidden:first');
                    visible.fadeOut('fast', function() {
                        hidden.show();
                    });
                }
            </script>
        </div>
        -->


        <div class="section ">
            <label style="text-transform:initial;"> Nombre<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="name" id="name">
            </div>
        </div>
        <div class="section ">
            <label style="text-transform:initial;"> Apellido<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="lastname" id="lastname">
            </div>
        </div>
        <div class="section">
            <label style="text-transform:initial;"> Usuario para entrar  <small>Correo electrónico</small></label>
            <div>
                <input type="text"  placeholder="example@dominio.com" name="email" id="email"  class="validate[required,custom[email]]  large" value="" />
                <span class="f_help"> Correo del conductor<br /></span> 
            </div>
            <label style="text-transform:initial;"> Contraseña  <small>de conductor</small></label>
            <div>
                <input type="text" placeholder="Contraseña" class="validate[required,minSize[3]] medium"  name="pwd" id="pwd"/>
            </div>
        </div>
        
        
        
        
        
        <div class="section">
            <label style="text-transform:initial;"> Vehículo <small>Placa, Referencia</small></label>   
            <div>
                {{Form::select('car_id',$cars,'0',array('class'=>'chzn-select', 'id'=>'car_id'))}}
            </div>
			<div>
                {{Form::select('car_id2',$cars,'0',array('class'=>'chzn-select'))}}
            </div>
			<div>
                {{Form::select('car_id3',$cars,'0',array('class'=>'chzn-select'))}}
            </div>
			<div>
                {{Form::select('car_id4',$cars,'0',array('class'=>'chzn-select'))}}
            </div>
			<div>
                {{Form::select('car_id5',$cars,'0',array('class'=>'chzn-select'))}}
            </div>
			<!--a class="btn" id="driver-0-addcar" onclick='formPoster(this.id)'>Adicionar Vehiculo</a-->
        </div>
        <script type="text/javascript">
            $("select").not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage,select#maker,select#model,select#feature").selectBox();
            // Mutiselection
            $(".chzn-select").chosen();
        </script>
        <!-- <div class="section ">
            <label style="text-transform:initial;">gender<small>Text custom</small></label>   
            <div> 
                <div>
                    <input type="radio" name="opinions" id="radio-1" value="1"  class="ck"/>
                    <label for="radio-1">Male</label>
                </div>
                <div>
                    <input type="radio" name="opinions" id="radio-2" value="1"  class="ck"  checked="checked"/>
                    <label for="radio-2" >Female</label>
                </div>
            </div>
        </div> -->

        <div class="section ">
            <label style="text-transform:initial;"> Celular<small></small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="cellphone" id="cellphone">
            </div>
        </div>
        <div class="section ">
            <label style="text-transform:initial;"> Teléfono<small>fijo</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="telephone" id="telephone">
            </div>
        </div>
        <div class="section ">
            <label style="text-transform:initial;"> Cédula<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="cedula" id="cedula">
            </div>
        </div>
        <div class="section ">
            <label style="text-transform:initial;"> Licencia<small>de conducción</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="license" id="license">
            </div>
        </div>
<!--        <div class="section ">
            <label style="text-transform:initial;"> Móvil<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] small" value="" name="movil" id="movil">
            </div>
        </div>-->
        <div class="section ">
            <label style="text-transform:initial;"> Dirección<small>de residencia</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="" name="dir" id="dir">
            </div>
        </div>
        <!-- <div class="section ">
            <label style="text-transform:initial;">Fecha de último pago<small> mm/dd/aaaa</small></label>
            <div> 
                <input type="text" class="validate[required] large" value="" name="join_date" id="join_date" tabindex="1">
                <span class="f_help"></span>
                <script type="text/javascript">
                    $("#join_date").datepicker().mask("99-99-9999");
                </script>
            </div>
        </div> -->
        

        <div class="section last">
            <div>
                <!-- <a class="btn submit_form" >Submit</a> -->
                <a class="btn" id="driver-0-create" onclick='formPosterDriver(this.id)'>Guardar</a>
            </div>
        </div>
    </div>
</div><!-- row-fluid -->
<script type="text/javascript">
            var chars = "ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
            var string_length = 8;
            var randomstring = '';
            var charCount = 0;
            var numCount = 0;

            for (var i = 0; i < string_length; i++) {
                // If random bit is 0, there are less than 3 digits already saved, and there are not already 5 characters saved, generate a numeric value. 
                if ((Math.floor(Math.random() * 2) == 0) && numCount < 3 || charCount >= 5) {
                    var rnum = Math.floor(Math.random() * 10);
                    randomstring += rnum;
                    numCount += 1;
                } else {
                    // If any of the above criteria fail, go ahead and generate an alpha character from the chars string
                    var rnum = Math.floor(Math.random() * chars.length);
                    randomstring += chars.substring(rnum, rnum + 1);
                    charCount += 1;
                }
            }
            $('#pwd').val(randomstring);
            //alert(randomstring);
</script>
{{Form::close()}}
<!-- </form> -->
<script type="text/javascript">
    $("#extExcel").hide();
</script>
@endsection

