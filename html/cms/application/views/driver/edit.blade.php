@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')
<script src="components/juploadify/jquery.uploadify.min.js" type="text/javascript"></script>

<script type="text/javascript" src="components/jqueryrotate/jQueryRotate.js"></script>
<script>
    $("#extExcel").hide();
  function rotar(){
    var giro=document.getElementById('giro').value;
    giro=giro*1+90;
    if(giro==360)
      giro=0;
    document.getElementById('giro').value=giro;
    $("#avatar").rotate(giro);
  }
</script>

<!-- <script type="text/javascript" src="js/webcam.js"></script> -->
<link rel="stylesheet" type="text/css" href="components/juploadify/uploadify.css">
<meta name="generator" content="TextMate http://macromates.com/">
<div class="boxtitle min">Take a picture with Webcam</div>
<!--<form id="validation_demo" action=""> -->
{{Form::open('driver/update','POST',array('id'=>'validation_demo'))}}
{{Form::token()}}
<script type="text/javascript">
    var d = new Date();
    var n = d.getTime();
</script>
<div class="row-fluid">
    <div class="span4">
        <div class="profileSetting" >
        
          <input type="hidden" id="giro" value="0">
          <div style='position: absolute;margin-left: 19%;margin-top: 2%;'><img src="img/books/arrow-turn-icon.png" onclick="rotar();" />&nbsp;<b>Girar</b></div>
          
          <br/><br/>
        
            <div class="avartar" id="avatar"><img src="<?php echo substr($item->picture, 11); ?>?v=<?php echo microtime(true); ?>" width="180" height="180" alt="avatar" /></div>
            <div class="avartar">
                <input type="file" name="picture" id="photoUploader" class="fileupload" />
                <script type='text/javascript'>
				<?php $timestamp = time(); ?>
                    $('#photoUploader').uploadify({
                        'formData': {
                             'timestamp': '<?php echo $timestamp; ?>',
                            'token': '<?php echo md5('unique_salt' . $timestamp); ?>',
                            'rs': './../img/drivers',
                            'dfn': '<?php echo $item->id; ?>.jpg'
                        },
                        'fileSizeLimit': '10000KB',
                        'auto': true,
                        'swf': 'components/juploadify/uploadify.swf',
                        'uploader': 'components/juploadify/uploadify.php',
                        'onUploadSuccess': function(file, data, response) {
//                            alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
                            dataPoster("driver-<?php echo $item->id; ?>-wcuploader");
                        }
                    });</script>
                <?php
                //$uploadOptions.="$(\"#photoUploader\").uploadify(\"upload\",\"*\");"; //javascript:
                // upload
                //$("input.fileupload").filestyle(); ?>
                </script>
                
                
                
                <p align="center"><span> OR </span>Take a picture with <a class="takeWebcam" href=javascript:mostrarCamara(); >Webcam</a></p>
            </div>
        </div>
        <hr/>
    </div>

    <div class="span8">
        <div class="section webcam">
            <label> Take a picture<small>With  webcam</small></label>   
            <div> 
                <div id="screen"></div>
                <div class="buttonPane">
                    <a id="takeButton" class="uibutton" onClick=tomarFoto(); >Capturar</a> <a id="closeButton" class="uibutton special" href=javascript:ocultarCamara();>Close</a>
					<input type=button value="Configure..." onClick="webcam.configure()">
                </div>
                <div class="buttonPane hideme">
                    <a id="uploadAvatar" class="uibutton confirm">Cargar Imagen</a> <a id="retakeButton" class="uibutton special">Volver a tomar</a> 
                </div>
            </div>
            <script type="text/javascript">

		function mostrarCamara(){
			//$(".webcam").show('blind');
			var foto = window.open("webcam.php?id=<?php echo $item->id; ?>", "", "width=400,height=400,menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left=100,top=100");		
		}

		function ocultarCamara(){
			$(".webcam").hide('blind');		
		}

		function tomarFoto(){
		    console.log("Hola ","TEst");
		    //webcam.set_api_url( 'test.php' );
			//webcam.set_quality( 90 ); // JPEG quality (1 - 100)
			//webcam.set_shutter_sound( true ); // play shutter click sound
		    webcam.snap();
		    //webcam.upload();
			//togglePane()
			//webcam.reset();
			//dataPoster("driver-<?php echo $item->id; ?>-wcuploader");
			return false;
		}
		

                // Profile webcam 
			var camera = $('#camera'), screen = $('#screen');
			webcam.set_api_url('test.php?id=<?php echo $item->id; ?>');
            webcam.set_hook( 'onComplete', 'my_completion_handler' );
            webcam.set_hook( 'onLoad', 'my_load_handler' );
		
            </script>
        </div>

        <div class="section ">
            <label> Nombre<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->name; ?>" name="name" id="name">
            </div>
        </div>
        <div class="section ">
            <label> Apellido<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->lastname; ?>" name="lastname" id="lastname">
            </div>
        </div>
        <div class="section">
            <p>
                {{Form::hidden('id',$item->id)}}
            </p>
            <label> Usuario para entrar  <small>Correo electrónico</small></label>
            <div>
                <input type="text"  placeholder="example@dominio.com" name="email" id="email"  class="validate[required,custom[email]]  large" value="<?php echo $item->email; ?>" />
                <span class="f_help"> Correo del conductor<br /></span> 
            </div>
            <div>
                <input type="text" placeholder="Contraseña" class="validate[required,minSize[3]] medium"  name="pwd" id="pwd"  />
                <a class="btn" id="pwdGen" onclick='randomPwd()'>Generar contraseña</a>
                <script type="text/javascript">
                function randomPwd() {
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
                    //return randomstring;
                }
                </script>
            </div>
        </div>
        <div class="section">
            <label> Vehiculos <small>Placa, Referencia</small></label>   
            <div>
				@if(isset($car_id1))
				{{Form::select('car_id',$cars,$car_id1,array('class'=>'chzn-select'))}}
				@else
                {{Form::select('car_id',$cars,$item->car_id,array('class'=>'chzn-select'))}}
				@endif
            </div>
			<div>
				@if(isset($car_id2))
                {{Form::select('car_id2',$cars,$car_id2,array('class'=>'chzn-select'))}}
				@else
				{{Form::select('car_id2',$cars,'0',array('class'=>'chzn-select'))}}
				@endif
			</div>
			<div>
                @if(isset($car_id3))
                {{Form::select('car_id3',$cars,$car_id3,array('class'=>'chzn-select'))}}
				@else
				{{Form::select('car_id3',$cars,'0',array('class'=>'chzn-select'))}}
				@endif
            </div>
			<div>
                @if(isset($car_id4))
                {{Form::select('car_id4',$cars,$car_id4,array('class'=>'chzn-select'))}}
				@else
				{{Form::select('car_id4',$cars,'0',array('class'=>'chzn-select'))}}
				@endif
            </div>
			<div>
                @if(isset($car_id5))
                {{Form::select('car_id5',$cars,$car_id5,array('class'=>'chzn-select'))}}
				@else
				{{Form::select('car_id5',$cars,'0',array('class'=>'chzn-select'))}}
				@endif
            </div>
        </div>
        <script type="text/javascript">
            $("select").not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage,select#maker,select#model,select#feature").selectBox();
            // Mutiselection
            $(".chzn-select").chosen();</script>
        <!-- <div class="section ">
            <label>gender<small>Text custom</small></label>   
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
            <label> Celular<small></small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->cellphone; ?>" name="cellphone" id="cellphone">
            </div>
        </div>
        <div class="section ">
            <label> Teléfono<small>fijo</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->telephone; ?>" name="telephone" id="telephone">
            </div>
        </div>
        <div class="section ">
            <label> Cédula<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->cedula; ?>" name="cedula" id="cedula">
            </div>
        </div>
        <div class="section ">
            <label> Licencia<small>de conducción</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->license; ?>" name="license" id="license">
            </div>
        </div>
<!--        <div class="section ">
            <label> Móvil<small>de conductor</small></label>   
            <div> 
                <input type="text" class="validate[required] small" value="{{$item->movil}}" name="movil" id="movil">
            </div>
        </div>-->
        <div class="section ">
            <label> Dirección<small>de residencia</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->dir; ?>" name="dir" id="dir">
            </div>
        </div>
        <div class="section ">
            <label> Status</small></label>   
            <div> 
                {{Form::select('status',$status,$item->status,array('class'=>'chzn-select'))}}
            </div>
        </div>
        <!-- <div class="section ">
            <label>Fecha de último pago<small> mm/dd/aaaa</small></label>
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo date('d/m/Y', strtotime($item->join_date)); ?>" name="join_date" id="join_date" tabindex="1">
                <span class="f_help"></span>
                <script type="text/javascript">
                    $("#join_date").datepicker().mask("99-99-9999");
                </script>
            </div>
        </div> -->
        <div class="section last">
            <div>
                <a class="btn" id="driver-<?php echo $item->id; ?>-update" onclick='formPoster(this.id)'>Submit</a>
            </div>
        </div>
    </div>
    @if(isset($result))
    <script type="text/javascript">
            alertMessage('success', 'Usuario actualizado');
    </script>
    @endif
</div><!-- row-fluid -->
{{Form::close()}}
<!-- </form> -->
@endsection

