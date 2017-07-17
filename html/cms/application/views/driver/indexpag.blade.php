@layout('layouts.table')
@section('title')
@if(isset($manageBtns['total']))
<!--{{$title}}<strong style="color: red">{{count($items->results)}}</strong>-->
<!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
@else
{{$title}}
@endif
{{"  Conductores Activos: "}}<strong style="color: red">{{$avaiables}}</strong>
{{" Conductores Inactivos: "}}<strong style="color: red">{{$notavaiables}}</strong>
@endsection
@section('customButtons')
@endsection
@section('contentTable')
<div class="section" style="display: block;">
    <a class="btn  btn-large " href="javascript:dataPoster('driver-0-new')" ><i class="icon-plus"></i>Agregar usuario</a>
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
		@forelse ($items->results as $item)
		<tr>
				@foreach($titles as $colNum=>$colTitle)
					@if(is_array($colTitle))
					<?php $tmpObj = ($item->$colTitle[0] != NULL) ? $item->$colTitle[0]->$colTitle[1] : ''; ?>
					<td>{{$tmpObj}}</td>
					@else
						@if($colTitle=='available')
						<td>
							<span class="checkslide">
								<input type="checkbox" <?php echo ($item->$colTitle == '1') ? 'checked="checked"' : ''; ?> disabled="disabled"/>
								<label data-on="On" data-off="Off"></label>
							</span>
						</td>
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
					@endif
				@endforeach	
			<td>
				@if(isset($manageBtns['custom']))
					@forelse($manageBtns['custom'] as $customBtn) 
							<span class="tip" ><img title="{{$customBtn['0']}}" src="{{$customBtn['3']}}" id="{{$customBtn['2']}}-{{$item->id}}-{{$customBtn['1']}}" onclick='<?php echo isset($customBtn['4']) ? $customBtn['4'] : 'dataPoster(this.id)'; ?>'></span> 
					@empty
					@endforelse
				@endif
				<span class="tip" ><img title="EDIT" src="images/icon/icon_edit.png" id="driver-<?php echo $item->id; ?>-edit" onclick='dataPoster(this.id)'></span> 
				<!--<span class="tip" ><a href="javascript:void(0)" class="Delete" data-name="delete name" title="Delete"  ><img src="images/icon/icon_delete.png" ></a></span>--> 
				<span class="tip" ><img title="ELIMINAR" src="images/icon/icon_delete.png" id="driver-<?php echo $item->id; ?>-delete" onclick='dataPoster(this.id)'></span> 

			</td>
		</tr>
		@empty
		@foreach($titles as $colNum=>$colTitle)
	<td>''</td>
	@endforeach
	@endforelse
	</tbody>
	<tfoot>
	<!--?php echo $items->previous().' '.$items->next(); ?-->
	</tfoot>
</table>
<?php echo $items->links(); ?>
@if(isset($message))
@if ($result == '1')
<script type = "text/javascript" >
                alertMessage('success', "<?php echo $message; ?>");
</script>
@else
<script type="text/javascript">
    alertMessage('error', "<?php echo $message; ?>");
</script>
@endif

@endif
<script type="text/javascript">
	$("#extExcel").click(function (e) {
        $("#dataTable{{$role->id}}").table2excel({
            name: "dataTable{{$role->id}}",
            filename: "dataTable{{$role->id}}", //do not include extension
            fileext: ".xls"
        });
    });
</script>
<!--</div> <!--tab1-->
@endsection

