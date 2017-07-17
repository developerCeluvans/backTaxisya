@layout('layouts.table')
@section('title')
@if(isset($manageBtns['total']))
{{$title}}<strong style="color: red">{{count($items)}}</strong>
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
 <p><h3>Se podrán agregar y buscar nuevos y antiguos conductores registrados en la base de datos.</h3></p>
<div class="section" style="display: block;">
    <a class="btn  btn-large " href="javascript:dataPoster('driver-0-new')" ><i class="icon-plus"></i>Agregar conductor</a>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
</div>
<!-- <div id="tab1" class="tab_content">-->
<table class="table table-bordered table-striped" id="dataTable">
    <thead align="center">
        <tr>
            <th width="18">
    <div class="checksquared"><input type="checkbox"  id="checkAll1"   class="checkAll" /><label for="checkAll1"></label></div>
</th>

@foreach($titles as $colNum=>$colTitle)
@if(substr($colNum, 0, 5)=='comb_')
<th>{{substr($colNum,5)}}</th>
@else
<th>{{$colNum}}</th>
@endif

@endforeach
<!--
<th width="60">Media</th>
<th>Name</th>
<th>ID</th>-->
<!--<th width="120">Status</th>-->
<th>Opciones</th>
</tr>
</thead>
<tbody align="center">

<?php
dd($items);
exit();
?>
    @forelse ($items->results as $item)
    <tr>
        <td><div class="checksquared"><input type="checkbox"   name="checkbox[]" /><label></label></div></td>
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
        <!--
        <td><img data-src="holder.js/60x40" alt=""></td>
        <td>Title Name</td>
        <td>18769</td>-->
        <!--
        <td>
            <span class="checkslide">
                <input type="checkbox" checked="checked" disabled="disabled"/>
                <label data-on="On" data-off="Off"></label>
            </span>
        </td> -->
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
</table>
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
        $("#dataTable").table2excel({
            name: "dataTable",
            filename: "dataTable", //do not include extension
            fileext: ".xls"
        });
    });
</script>
@endsection

