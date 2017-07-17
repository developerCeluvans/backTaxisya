@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('contentTable')
<!-- <div id="tab1" class="tab_content">-->
<div id="UITab" style="position:relative;">
    <ul class="tabs" >
        @foreach($roles as $role)
        <li ><a href="#tab{{$role->id}}">{{$role->type}}</a></li>
        @endforeach
    </ul>
    <div class="tab_container" >
        @foreach($roles as $role)
        <div id="tab{{$role->id}}" class="tab_content">
            <!-- <div class="btn-group pull-top-right btn-square">
              <a class="btn  btn-large " href="javascript:void(0)"><i class="icon-plus"></i>  Add Product</a>
              <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a>
            </div> -->
            @if($manageBtns['add']==true)
            <div class="section" style="display: block;">
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-0-new')"><i class="icon-plus"></i>Agregar Cliente</a>
                <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
            </div>
            @endif
            <table class="table table-bordered table-striped" id="dataTable{{$role->id}}">
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
                <th>Management</th>
                </tr>
                </thead>
                <?php //dd($titles); ?>
                <tbody align="center">
                    @forelse ($items as $item)
                    @if($item->role->id!=$role->id)
                    <?php continue; ?>
                    @endif
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
                            <span class="tip" ><img title="EDIT" src="images/icon/icon_edit.png" id="{{$section}}-<?php echo $item->id; ?>-edit" onclick='dataPoster(this.id)'></span>
                            @endif
                            @if($manageBtns['del']==true)
                            <span class="tip" ><img title="ELIMINAR" src="images/icon/icon_delete.png" id="{{$section}}-<?php echo $item->id; ?>-delete" onclick='dataPoster(this.id)'></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div><!--tab1-->
        <script type='text/javascript'>
                                //DataTable
                                $('#dataTable{{$role->id}}').dataTable({
                                    "sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
                                    "bJQueryUI": false,
                                    "iDisplayLength": 10,
                                    "sPaginationType": "bootstrap",
                                    "oLanguage": {
                                        "sLengthMenu": "_MENU_",
                                        "sSearch": "Search"
                                    }
                                });
                $("#extExcel").click(function (e) {
                    $("#dataTable{{$role->id}}").table2excel({
                        name: "dataTable{{$role->id}}",
                        filename: "dataTable{{$role->id}}", //do not include extension
                        fileext: ".xls"
                    });
                });
        </script>
        @endforeach
    </div>
</div><!-- End UITab -->
@if(isset($message))
<script type = "text/javascript" >
    alertMessage('{{$result}}', "<?php echo $message; ?>");
</script>
@endif
<script type="text/javascript">
    // Tabs
    $("ul.tabs li").fadeIn(400);
    $("ul.tabs li:first").addClass("active").fadeIn(400);
    $(".tab_content:first").fadeIn();
    /*$("ul.tabs li").live('click', function() {
     $("ul.tabs li").removeClass("active");
     $(this).addClass("active");
     var activeTab = $(this).find("a").attr("href");
     $('.tab_content').fadeOut();
     $(activeTab).delay(400).fadeIn();
     ResetForm();
     return false;
     });*/
</script>
@endsection

