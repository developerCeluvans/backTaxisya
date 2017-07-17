@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')
<!-- <div id="tab1" class="tab_content">-->
<p><h3>Podrá buscar y editar vehículos con sus afiliaciones vencidas.</h3></p>
@if($manageBtns['add']==true)
<div class="section" style="display: block;">
    <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-0-new')"><i class="icon-plus"></i>Agregar Item</a>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
</div>
@endif
<div class="section" style="display: block;">
    <!--a class="btn  btn-large " href="javascript:dataPoster('notifier-0-expired')"><i class="icon-plus"></i>Notificar a todos los conductores</a-->
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
</div>
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
<!--
<th width="120">Status</th>-->
<th>Opciones</th>
</tr>
</thead>
<?php //dd($titles); ?>
<tbody align="center">
    @forelse ($items as $item)
    <tr>
        <td><div class="checksquared"><input type="checkbox"   name="checkbox[]" /><label></label></div></td>
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
        <!--
        <td><img data-src="holder.js/60x40" alt=""></td>
        <td>Title Name</td>
        <td>18769</td>-->

        <!--
        <td>
            <span class="checkslide">
                <input type="checkbox" checked="checked" />
                <label data-on="On" data-off="Off"></label>
            </span>
        </td>
        <td>
            <span class="tip" ><a href="modalEdit.html?idEdit=edit" class="pop_box" title="Edit" ><img src="images/icon/icon_edit.png" ></a></span> 
            <span class="tip" ><a href="javascript:void(0)" class="Delete" data-name="delete name" title="Delete"  ><img src="images/icon/icon_delete.png" ></a></span> 
        </td> -->
        <td>
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
<script type = "text/javascript" >
    $("#extExcel").click(function (e) {
        $("#dataTable").table2excel({
            name: "dataTable",
            filename: "dataTable", //do not include extension
            fileext: ".xls"
        });
    });
</script>
<!--</div> <!--tab1-->
@endsection

