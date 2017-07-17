@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')

<div class="boxtitle min">Datos de usuario</div>
<!--<form id="validation_demo" action=""> -->
{{Form::open('user/update','POST',array('id'=>'validation_demo'))}}
{{Form::token()}}
<div class="row-fluid">
    <div class="section ">
        <label> Nombre<small>de usuario</small></label>   
        <div> 
            <input type="text" class="validate[required] large" value="<?php echo $item->name; ?>" name="name" id="name" readonly>
        </div>
    </div>
    <div class="section ">
        <label> <small></small></label>   
        <div> 
            <input type="hidden" class="validate[required] large" value="<?php echo $item->lastname; ?>" name="lastname" id="lastname" readonly>
        </div>
    </div>
    <div class="section">
        <p>
            {{Form::hidden('id',$item->id)}}
        </p>
        <label> Usuario para entrar  <small>Correo electrónico</small></label>
        <div>
            <input type="text"  placeholder="example@dominio.com" name="email" id="email"  class="validate[required,custom[email]]  large" value="<?php echo $item->email; ?>" readonly/>
            <span class="f_help"> Correo del usuario<br /></span> 
        </div>
        <div>
            <input type="password" placeholder="Contraseña" class="validate[required,minSize[3]] medium"  name="pwd" id="pwd"  readonly />
        </div>
    </div>
    <div class="section ">
        <label> Teléfono<small>celular</small></label>   
        <div> 
            <input type="text" class="validate[required] large" value="<?php echo $item->cellphone; ?>" name="cellphone" id="cellphone" readonly>
        </div>
    </div>
    <div class="section last">
        <!-- <div>
            <a class="btn" id="user-<?php echo $item->id; ?>-update" onclick='formPoster(this.id)'>Guardar</a>
        </div> -->
    </div>
</div>
@if(isset($result))
<script type="text/javascript">
    alertMessage('success', 'Usuario actualizado');
</script>
@endif
<script type="text/javascript">
    $("#extExcel").hide();
</script>
</div><!-- row-fluid -->
{{Form::close()}}
<!-- </form> -->
@endsection

