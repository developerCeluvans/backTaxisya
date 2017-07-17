@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')

<div class="boxtitle min">Asignar agendamiento</div>
<!--<form id="validation_demo" action=""> -->
{{Form::open('schedule/update','POST',array('id'=>'editForm'))}}
{{Form::token()}}
<div class="row-fluid">
    <div class="span4">
    </div>

    <div class="span8">
        <div class="section ">
            <label> Nombre<small>de usuario</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->user->name; ?> <?php echo $item->user->lastname; ?>" name="fullName" id="fullName" readonly>
            </div>
        </div>
        <div class="section ">
            <label> Fecha<small>de agendamiento</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->service_date_time; ?>" name="schedule_date_time" id="schedule_date_time" readonly>
            </div>
        </div>
        <div class="section ">
            <label> Tipo<small>de agendamiento</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->schedule_type; ?>" name="type" id="type" readonly>
            </div>
        </div>
        <div class="section ">
            <label> Dirección<small>de agendamiento</small></label>   
            <div> 
                <input type="text" class="validate[required] large" value="<?php echo $item->address_index . " " . $item->comp1 . " # " . $item->comp2 . "-" . $item->no . " " . $item->barrio . " obs:" . $item->obs; ?>" name="type" id="type" readonly>
            </div>
        </div>
        <div class="section">
            <label> Conductor<small>a asignar</small></label>   
            <div>
                {{Form::select('driver_id',$drivers,$item->driver_id,array('class'=>'chzn-select'))}}
            </div>
        </div>
        <script type="text/javascript">
            $("select").not("select.chzn-select,select[multiple],select#box1Storage,select#box2Storage,select#maker,select#model,select#feature").selectBox();
            // Mutiselection
            $(".chzn-select").chosen();
        </script>
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
        <div class="section last">
            <div>
                <p>
                    {{Form::hidden('id',$item->id)}}
                </p>
                <a class="btn" id="schedule-<?php echo $item->id; ?>-update" onclick='formPoster(this.id)'>Submit</a>
            </div>
        </div>
    </div>
    @if(isset($result))
    <script type="text/javascript">
            alertMessage('success', 'Agendamiento actualizado!');
    </script>
    @endif
</div><!-- row-fluid -->
{{Form::close()}}
<!-- </form> -->
@endsection
<script type="text/javascript">
    $("#extExcel").hide();
</script>