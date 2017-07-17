@layout('layouts.table')
@section('title')
Usuarios:<strong style="color: red">{{count($usuarios)}}</strong>
@endsection
@section('contentTable')
<!-- <div id="tab1" class="tab_content">-->
 <p><h3>Acá podrá encontrar y eliminar los usuarios que están registrados en la aplicación.</h3></p>
<div class="btn-group pull-top-right btn-square">
    <a class="btn  btn-large " href="javascript:void(0)"><i class="icon-plus"></i>Agregar usuario</a>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
</div>
<table class="table table-bordered table-striped" id="dataTable">
    <thead align="center">
        <tr>
            <th width="18">
    <div class="checksquared"><input type="checkbox"  id="checkAll1"   class="checkAll" /><label for="checkAll1"></label></div>
</th>
@foreach($titles as $colNum=>$colTitle)
<th>{{$colNum}}</th>
@endforeach
<!--
<th width="60">Media</th>
<th>Name</th>
<th>ID</th>-->

<!--
<th width="120">Status</th>-->
<th>Detalle</th>

</tr>
</thead>
<tbody align="center">
    @forelse ($usuarios as $user)
    <tr>
        <td><div class="checksquared"><input type="checkbox"   name="checkbox[]" /><label></label></div></td>
        @foreach($titles as $colNum=>$colTitle)
        <td>{{$user->$colTitle}}</td>
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
        </td>-->
        <td>
            <!-- <span class="tip" ><img title="EDIT" src="images/icon/icon_users.png" id="user-<?php echo $user->id; ?>-edit" onclick='dataPoster(this.id)'></span> -->
            <span class="tip" ><img title="ELIMINAR" src="images/icon/icon_delete.png" id="user-<?php echo $user->id; ?>-delete" onclick='dataPoster(this.id)'></span>
        </td>
    </tr>
    @empty
    @foreach($titles as $colNum=>$colTitle)
<td>''</td>
@endforeach
@endforelse
</tbody>
</table>
<!--</div> <!--tab1-->

<script type="text/javascript">
    $("#extExcel").click(function (e) {
        $("#dataTable").table2excel({
            name: "dataTable",
            filename: "dataTable", //do not include extension
            fileext: ".xls",
            exclude_img: true,
            exclude_inputs: true
        });
    });
</script>
@endsection
