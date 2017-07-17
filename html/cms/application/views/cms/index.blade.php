@layout('layouts.table')
@section('title')
@if(isset($manageBtns['total']))
{{$title}}<strong style="color: red">{{count($items)}}</strong>
<!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
@else
{{$title}}
@endif

@endsection
@section('contentTable')
<!-- <div id="tab1" class="tab_content">-->
@if(isset($manageBtns['tabs']))
<div id="UITab" style="position:relative;">
    <p><h3>Podrá editar y buscar las diferentes versiones de la
aplicación para taxistas y usuarios.</h3></p>
    <ul class="tabs" >
        @foreach($manageBtns['tabs']['options'] as $tabData)
        <li ><a href="#tab{{$tabData['id']}}">{{$tabData['description']}}</a></li>            
        @endforeach                
    </ul>
    <div class="tab_container" >

        @foreach($manageBtns['tabs']['options'] as $tabData)
        <div id="tab{{$tabData['id']}}" class="tab_content"> 
            <!-- <div class="btn-group pull-top-right btn-square">
              <a class="btn  btn-large " href="javascript:void(0)"><i class="icon-plus"></i>  Add Product</a>
              <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a>
            </div> -->
            <div class="section" style="display: block;">
                @if(isset($manageBtns['group']))
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$manageBtns['group']}}-new')"><i class="icon-plus"></i>Agregar Item</a>
                @else

                @if($manageBtns['add']==true)
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-0-new')"><i class="icon-plus"></i>Agregar Item</a>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
                @endif

                @endif
                @if(isset($manageBtns['export']))
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$tabData['id']}}-export')"><i class="icon-plus"></i>Exportar tabla</a>
                @endif

                @if(isset($manageBtns['back']))
                <a class="btn  btn-large " href="javascript:dataPoster('{{$manageBtns['back']['section']}}-{{$manageBtns['back']['id']}}-{{$manageBtns['back']['action']}}')"><i class="icon-link"></i>Volver</a>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
                @endif
                @if(isset($manageBtns['total']))
                <h2>Total:<span id="totalRows{{$tabData['id']}}"></span></h2>
    <!-- <a class="btn  btn-large btn-danger DeleteAll" href="javascript:void(0)"><i class="icon-trash"></i> Delete  All</a> -->
                @endif
            </div>
            <table class="table table-bordered table-striped" id="dataTable{{$tabData['id']}}">
                <thead align="center">
                    <tr>
<!--                        <th width="18">
                <div class="checksquared"><input type="checkbox"  id="checkAll1"   class="checkAll" /><label for="checkAll1"></label></div>
            </th>-->
                        @foreach($titles as $colNum=>$colTitle)
                        @if(substr($colNum, 0, 5)=='comb_')
                        <th>{{substr($colNum,5)}}</th>
                        @else
                        <th>{{$colNum}}</th>
                        @endif
                        @endforeach

                        @if(isset($roleMetaDataTitles))
                        @if($role->id==$roleMetaData['role'])

                        @foreach($roleMetaDataTitles as $roleMetaDataTitle)
                        <th>{{$roleMetaDataTitle->descript}}</th>
                        @endforeach

                        @endif
                        @endif

                        <!--
                        <th width="60">Media</th>
                        <th>Name</th>
                        <th>ID</th>-->
                        <!--
                        <th width="120">Status</th>-->
                        <th>Opciones</th>
                    </tr>
                </thead>
                <?php $rowsTotal = 0; //dd($titles); ?>
                <tbody align="center">

                    @forelse ($items as $item)
                    @if($item->$manageBtns['tabs']['tabber']!=$tabData['id'])
                    <?php continue; ?>
                    @endif
                    <?php $rowsTotal++; ?>
                    <tr>
                        <!--<td><div class="checksquared"><input type="checkbox"   name="checkbox[]" /><label></label></div></td>-->
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


                        @if(isset($roleMetaDataTitles))
                        @if($roleMetaData['role']==$role->id)


                        @foreach($roleMetaDataTitles as $roleMetaDataTitle)
                        @if(isset($item->$roleMetaData['metaData']))
                        @foreach($item->$roleMetaData['metaData'] as $itemMetaData)
                        <?php $metaNotFound = true; ?>
                        @if($roleMetaDataTitle->id == $itemMetaData->id)
                        @if($itemMetaData->id!='6')
                        <td><img title="{{$roleMetaDataTitle->descript}}" src="images/icon/color_18/checkmark2.png"></td>
                        @else
                        <td>{{$itemMetaData->pivot->others}}</td>
                        @endif
                        <?php
                        $metaNotFound = false;
                        break;
                        ?>
                        @else
                        <?php $metaNotFound = true; ?>
                        @endif
                        @endforeach
                        @if($metaNotFound == true)
                        <td></td>
                        @endif
                        @else
                        <td></td>
                        @endif
                        @endforeach

                        @endif
                        @endif

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
                            @if(isset($manageBtns['custom']))
                            @forelse($manageBtns['custom'] as $customBtn) 
                            @if($customBtn['5']==$tabData['id'])
                            <span class="tip" ><img title="{{$customBtn['0']}}" src="{{$customBtn['3']}}" id="{{$customBtn['2']}}-{{$item->id}}-{{$customBtn['1']}}" onclick='<?php echo isset($customBtn['4']) ? $customBtn['4'] : 'dataPoster(this.id)'; ?>'></span> 
                            @endif
                            @empty
                            @endforelse
                            @endif
                            @if($manageBtns['edit']==true)
                            <span class="tip" ><img title="EDIT" src="images/icon/icon_edit.png" id="{{$section}}-<?php echo $item->id; ?>-edit" onclick='dataPoster(this.id)'></span> 
                            @endif
                            @if($manageBtns['del']==true)
                            <span class="tip" ><img title="ELIMINAR" src="images/icon/icon_delete.png" id="{{$section}}-<?php echo $item->id; ?>-delete" onclick='dataPoster(this.id)'></span> 
                            @endif
                        </td>
                    </tr>
                    @empty
                <!--<td><div class="checksquared"><input type="checkbox"   name="checkbox[]" /><label></label></div></td>-->
                    @endforelse
                </tbody>
            </table>
        </div><!--tab1-->
        <script type='text/javascript'>
                                //DataTable
                                $('#dataTable{{$tabData["id"]}}').dataTable({
                                    "sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
                                    "bJQueryUI": false,
                                    "iDisplayLength": 50,
                                    "sPaginationType": "bootstrap",
                                    "oLanguage": {
                                        "sLengthMenu": "_MENU_",
                                        "sSearch": "Buscar"
                                    }
                                });
                                @if (isset($manageBtns['total']))
                                        $("#totalRows{{$tabData['id']}}").empty().html("{{$rowsTotal}}");
                                @endif

        </script>
        @endforeach
    </div>
</div><!-- End UITab -->
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
@else

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
@endif
@if(isset($message))
<script type = "text/javascript" >
    alertMessage('{{$result}}', "<?php echo $message; ?>");
</script>
@endif
<script type="text/javascript">
    $("#extExcel").click(function (e) {
        $("#dataTable{{$tabData['id']}}).table2excel({
            name: "dataTable{{$tabData['id']}}",
            filename: "dataTable{{$tabData['id']}}", //do not include extension
            fileext: ".xls"
        });
    });
</script>
@endsection

