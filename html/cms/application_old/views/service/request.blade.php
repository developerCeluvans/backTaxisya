@layout('layouts.table')
@section('title')
@if(isset($manageBtns['total']))
{{$title}}<strong style="color: red">{{count($items)}}</strong>
@else
{{$title}}
@endif
@endsection
@section('tablesorting')
{{$tablesorting}}
@endsection
@section('contentTable')
<p><h3>Podrá ingresar los datos del servicio que se está requiriendo por teléfono.</h3></p>
<div class="section" style="display: block;">
		<?php $telefono = '';?>
		<?php $calle ='';?>
		<?php $Num1 = '';?>
		<?php $Num2 = '';?>
		<?php $Num3 = '';?>
		<?php $Obse = '';?>
		<?php $Bar = '';?>
		<?php $UserName = '';?>
		<?php $UserId = '';?>
		<?php $ActualizaPantalla = 'true';?>
		@if(isset($phone))
		<?php $telefono = $phone;?>
		@endif
		@if(isset($user))
		<?php $UserName = $user->name.' '.$user->lastname;?>
		<?php $UserId = $user->id;?>
		@endif
		@if(isset($selectaddress))
		<!--?php echo print_r($selectaddress);?-->
		<?php $calle = $selectaddress->index_id;?>
		<?php $Num1 = $selectaddress->comp1;?>
		<?php $Num2 = $selectaddress->comp2;?>
		<?php $Num3 = $selectaddress->no;?>
		<?php $Obse = $selectaddress->obs;?>
		<?php $Bar = $selectaddress->barrio;?>
		@endif
		<table style="width:100%">
		  <tr>
			<td>
				<label style="text-transform:initial;"><small>Tel/celular: </small></label> 
				<input class="wide-font" type = "text" value = "<?php echo $telefono;?>" name = "telephone" id = "telephone" tabindex = "1" style="font-size:15px;height:37px;width:34%;">
				<!--a class="btn  btn-large " href="javascript:dataPoster('service--search');"><i class="icon-search"></i>Buscar</a--> 
				<!--a class="btn btn-large" id="service-0-search"  onclick='formPoster2(this.id)' tabindex = "2">Buscar</a-->
				<button class="btn btn-large" id="service-0-search" onclick='formPoster2(this.id)' tabindex = "2" style="font-size:19px;height:37px;width:12%;margin-top:-1%;">Buscar</button>
			</td>
		  </tr>
		  <tr>	
			<td>
			@if(isset($adresses))
				<?php $cont = count($adresses);?>
				@if($cont >  0)
					<label style="text-transform:initial;"><small>Seleccionar direccion: </small></label> 
					<select size="<?php echo $cont+1?>" style="font-size:40px;width: 1000px;text-align:center;display: inline-block;" type = "text" value = "" name = "choiceadress" id="service-0-filladdress" onChange='formPoster2(this.id)'>
							<!--option value="">Seleccionar</option-->
						@foreach($adresses as $adress)
							<option style="font-size: 20px!important;text-align:left!important;" value="<?php echo $adress->id ?>"><?php echo ($adress->index_id.' No '.$adress->comp1.' - '.$adress->comp2.' '.$adress->obs.' Barrio '.$adress->barrio)?></option>
						@endforeach
					</select>
				@endif
			@else
				<input type='hidden' name = "choiceadress" id="service-0-filladdress" value="-1"/>
			@endif
			</td>
		  </tr>
		  <tr>
			<td>
				<label style="text-transform: initial;"><small>Nombre y Apellido: </small></label> 
				<input type = "text" class = "validate[required] large" value = "<?php echo $UserName;?>" name = "name" id = "name" tabindex = "4" style="font-size:15px;height:37px;width:34%;">
				@if(isset($user))
				@else
				<button class="btn  btn-large " id="service-0-add" onclick='formPoster2(this.id)' tabindex = "5" style="font-size:19px;height:37px;width:12%;margin-top:-1%;">Agregar</button> 	
				@endif
			</td> 
		  </tr>
		  </table>
		  <table>
		  @if(isset($user))
		  <tr>
			<label style="text-transform:initial;"><small>Direccion del servicio: </small></label> 
			<td>
				<label style="text-transform:initial;"><small> </small></label>
				<input type = "text" class = "validate[required] medium" value = "<?php echo $calle;?>" name = "street" id = "street"  size="4" tabindex = "6" style="font-size:15px;height:31px;">
			</td>
			<td>
				<label ><small> </small></label>
				<input type = "text" class = "validate[required] medium" value = "<?php echo $Num1;?>" name = "comp1" id = "comp1"  size="4" tabindex = "7" style="font-size:15px;height:31px;">
			</td>
			<td align="center">
				<label style="text-transform:initial;"><small>#</small></label> 
			</td>
			<td>
				<input type = "text" class = "validate[required] medium" value = "<?php echo $Num2;?>" name = "comp2" id = "comp2"  size="4" tabindex = "8" style="font-size:15px;height:31px;">
			</td>
			<td>
				<label style="text-transform:initial;"><small>-</small></label> 
			</td>
			<td>
				<input type = "text" class = "validate[required] medium" value = "<?php echo $Num3;?>" name = "no" id = "no"  size="4" tabindex = "9" style="font-size:15px;height:31px;">
			</td>
		   </tr>
		  </table>
		  <table>
		  <tr>
			<td>
				<label style="text-transform:initial;"><small>Obs: </small></label> 
				<input type = "text" class = "validate[required] medium" value = "<?php echo $Obse;?>" name = "obs" id = "obs" tabindex = "10" style="font-size:15px;height:31px;width:500px;">
			</td>
			<td>
				<label style="text-transform:initial;"><small>Barrio: </small></label> 
				<input type = "text" class = "validate[required] medium" value = "<?php echo $Bar;?>" name = "" id = "barrio" tabindex = "11" style="font-size:15px;height:31px;width:500px;">		
			</td>
		  </tr>
		  <tr>
			<td>
				@if(isset($conductor))
				<label style="text-transform:initial;"><small>Conductor: </small></label> 
				<input type = "TEXTAREA" class = "validate[required] medium" value = "<?php echo $conductor;?>" name = "" id = "conductor" style="font-size:15px;height:31px;width:500px;">		
				@endif
			</td>
			<td>
				@if(isset($placa))
				<label style="text-transform:initial;"><small>Vehiculo Placa: </small></label> 
				<input type = "TEXTAREA" class = "validate[required] medium" value = "<?php echo $placa;?>" name = "" id = "vahiculo" style="font-size:15px;height:31px;width:500px;">		
				@endif
			</td>
		  </tr>
		  <tr>
			<td>
				@if(isset($celldriver))
				<label style="text-transform:initial;"><small>Celular: </small></label> 
				<input type = "TEXTAREA" class = "validate[required] medium" value = "<?php echo $celldriver;?>" name = "" id = "celldriver" style="font-size:15px;height:31px;width:500px;">		
				@endif
			</td>
			<td>
				@if(isset($movil))
				<label style="text-transform:initial;"><small>Movil: </small></label> 
				<input type = "TEXTAREA" class = "validate[required] medium" value = "<?php echo $movil;?>" name = "" id = "movil" style="font-size:15px;height:31px;width:500px;">		
				@endif
			</td>
		  </tr>
		  @endif
		  <tr>
			<br/>
		  </tr>
		  </table>
		  <table>
		  <tr>
			<td align="left">
				@if(isset($user))
				<button class="btn btn-large" id="service-<?php echo $UserId;?>-realrequest"  onclick='javascript:formRequest(this.id)' tabindex = "12" style="font-size: 19px;height: 37px;width: 98%;margin-top: -1%;background: #1AD72D;color:#ffffff;">Solicitar</button>
				@endif
			</td>
			<td align="center">
				<a class="btn btn-large" id="automatic"  onclick="start()" style="font-size:19px;height:22px;width:83%;margin-top:-1%;background:orange;color:#ffffff;">Actual. Auto.</a>
			</td>
			<td align="right">
				<a class="btn  btn-large " href="javascript:dataPoster('service-0-search');" id="actualizar" style="font-size:19px;height:22px;width:83%;margin-top:-1%;" tabindex="13">Limpiar</a> 
				<input  type='hidden' class = "validate[required] medium" value = "1" id = "actualizarpantalla"  >
			</td>			
		  </tr>
		  <tr>
			<td>
			</td>
		  </tr>
		</table>	
		<!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
</div>
<div class="section" style="display: block;">
    @if($manageBtns['add']==true)
    @if(isset($manageBtns['group']))
    <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$manageBtns['group']}}-new')"><i class="icon-plus"></i>Agregar Item</a>
    @else
    <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-0-new')"><i class="icon-plus"></i>Agregar Item</a>
    @endif
    @endif
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
    @if(isset($manageBtns['back']))
    <a class="btn  btn-large " href="javascript:dataPoster('{{$manageBtns['back']['section']}}-{{$manageBtns['back']['id']}}-{{$manageBtns['back']['action']}}')"><i class="icon-link"></i>Volver</a>
<!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
    @endif
    @if(isset($manageBtns['export'])&&$manageBtns['export']==true)
    <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$tabData['id']}}-export')"><i class="icon-plus"></i>Exportar tabla</a>
    @endif
</div>
<table class="table table-bordered table-striped" id="dataTable">
    <thead align="center">
        <tr>

            @foreach($titles as $colNum=>$colTitle)
            @if(substr($colNum, 0, 5)=='comb_')
            <th>{{substr($colNum,5)}}</th>
            @else
            <th>{{$colNum}}</th>
            @endif
            @endforeach
            <th>Opciones</th>
        </tr>
    </thead>
	
    <tbody align="center">
        @forelse ($items as $item)
        <tr>
            @foreach($titles as $colNum=>$colTitle)
            @if(is_array($colTitle))
            @if(is_array($colTitle[0]))
            <?php
            $tmpObj = '';
            foreach ($colTitle as $colKey => $part) {
                //dd($item->$part[0]);
                if ($item->$part[0] != NULL) {
                    $tmpObj .= " " . $item->$part[0]->$part[1];
                }
            }
            ?>
            <?php //$tmpObj = ($item->$colTitle[0][0] != NULL) ? $item->$colTitle[0][0]->$colTitle[0][1] . " " . $item->$colTitle[1][0]->$colTitle[1][1] : ''; ?>
            <?php
            //$tmpObj = $item->state->descrip;
            //dd($item->state->descrip);
            ?>
            <td>{{$tmpObj}}</td>
            @else
            <?php $tmpObj = ($item->$colTitle[0] != NULL) ? $item->$colTitle[0]->$colTitle[1] : ''; ?>
            <?php
            //$tmpObj = $item->state->descrip;
            //dd($item->state->descrip);
            ?>
            <td>{{$tmpObj}}</td>
            @endif
            @else
            @if(substr($colNum, 0, 5)=='comb_')
            <?php
            $dataToComb = explode(".", $colTitle);
            //dd($dataToComb);
            $combResult = '';
            foreach ($dataToComb as $key => $value) {
                if ($item->$value == NULL) {
                    $combResult .= " ";
                } else {
                    $combResult .= " " . $item->$value;
                }
            }
            ?>
            <td>{{$combResult}}</td>
            @else
            <?php if ($item->$colTitle == NULL) { ?>
                <td></td>
            <?php } else { ?>
                <td>{{$item->$colTitle}}</td>
            <?php } ?>
            @endif
            @endif
            @endforeach								
            <td>
                @if(isset($manageBtns['custom']))
                @forelse($manageBtns['custom'] as $customBtn) 
				<!--?php echo print_r($customBtn)?-->
                <span class="tip" ><img title="{{$customBtn['0']}}" src="{{$customBtn['3']}}" id="{{$customBtn['2']}}-{{$item->id}}-{{$customBtn['1']}}" onclick='<?php echo isset($customBtn['4']) ? $customBtn['4'] : 'dataPoster(this.id)'; ?>'></span> 
                @empty
                @endforelse
                @endif
                @if($manageBtns['edit']==true)
                <span class="tip" ><img title="EDITAR" src="images/icon/icon_edit.png" id="{{$section}}-<?php echo $item->id; ?>-edit" onclick='dataPoster(this.id)'></span> 
                @endif
                @if($manageBtns['del']==true)
                <span class="tip" ><img title="ELIMINAR" src="images/icon/icon_delete.png" id="{{$section}}-<?php echo $item->id; ?>-delete" onclick='dataPoster(this.id)'></span> 
                @endif
            </td>
        </tr>
        @empty
        @foreach($titles as $colNum=>$colTitle)
        @endforeach
        @endforelse
    </tbody>
</table>

@if(isset($message))
<script type = "text/javascript" >
    alertMessage('{{$result}}', "<?php echo $message; ?>");
</script>
@endif

<script>
var myVar =setInterval(function(){myTimer()},30000);
clearTimeout(myVar);
function start(){
	myVar=setInterval(function(){myTimer()},5000);
	if(document.getElementById("telephone").value=='')
	   document.getElementById('automatic').style.display = 'none';
}
function myTimer() {
	if(document.getElementById("actualizarpantalla").value=='1')
	{
		if(document.getElementById("telephone").value=='')
		{	
			dataPoster('service-0-search');
		}
	}
    //var d = new Date();
    document.getElementById("actualizar").innerHTML = d.toLocaleTimeString();
}
$("#extExcel").click(function (e) {
    $("#dataTable").table2excel({
        name: "dataTable",
        filename: "dataTable", //do not include extension
        fileext: ".xls",
    })
});
</script>

@endsection

