@layout('layouts.table')
@section('title')
{{$title}}
@endsection
@section('tablesorting')
{{$tablesorting}}
@endsection
@section('contentTable')
<p><h3>Podrá agregar y buscar agendamientos.</h3></p>
<div id="UITab" style="position:relative;">
    <ul class="tabs" >
        @foreach($manageBtns['tabs']['options'] as $tabData)
        <li ><a href="#tab{{$tabData['id']}}">{{$tabData['description']}}</a></li>            
        @endforeach                
    </ul>
    <div class="tab_container" >
        @foreach($manageBtns['tabs']['options'] as $tabData)
        <div id="tab{{$tabData['id']}}" class="tab_content"> 
            <div class="section" style="display: block;">
                
				@if(isset($manageBtns['group']))
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$manageBtns['group']}}-new')"><i class="icon-plus"></i>Agregar Item</a>
                @else
					@if($manageBtns['add']==true)
					<a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-0-new')"><i class="icon-plus"></i>Agregar Item</a>
					@endif
                @endif
				
                @if(isset($manageBtns['export']))
                <a class="btn  btn-large " href="javascript:dataPoster('<?php echo $section; ?>-{{$tabData['id']}}-export')"><i class="icon-plus"></i>Exportar tabla</a>
                @endif

                @if(isset($manageBtns['back']))
                <a class="btn  btn-large " href="javascript:dataPoster('{{$manageBtns['back']['section']}}-{{$manageBtns['back']['id']}}-{{$manageBtns['back']['action']}}')"><i class="icon-link"></i>Volver</a>
                @endif

                @if(isset($manageBtns['total']))
				<h2>Total:<span id="totalRows{{$tabData['id']}}"></span></h2>
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
						<th>Agendar</th>
					</tr>
				</thead>
				<?php $rowsTotal = 0;?>
                <tbody align="center">
					@forelse ($items as $item)
						@if($item->$manageBtns['tabs']['tabber']!=$tabData['id'])
						<?php continue; ?>
						@endif
						<?php $rowsTotal++; ?>
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
									<td>{{$tmpObj}}</td>
									@else
									<?php $tmpObj = ($item->$colTitle[0] != NULL) ? $item->$colTitle[0]->$colTitle[1] : ''; ?>
									<td>{{$tmpObj}}</td>
									@endif
								@else
									@if(substr($colNum, 0, 5)=='comb_')
									<?php
									$dataToComb = explode(".", $colTitle);
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
						   <!--td>
								<span class="tip" ><img title="EDIT" src="images/icon/icon_edit.png" id="schedule-<?php echo $item->id; ?>-edit" onclick='dataPoster(this.id)'></span> 
								<span class="tip" ><a href="javascript:void(0)" class="Delete" data-name="delete name" title="Delete"  ><img src="images/icon/icon_delete.png" ></a></span> 
							</td-->
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
						@foreach($titles as $colNum=>$colTitle)
							<td>''</td>
						@endforeach
						<td></td>
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
                                        "sSearch": "Search"
                                    }
                                });
                                $("#extExcel").click(function (e) {
				                    $("#dataTable{{$tabData['id']}}").table2excel({
				                        name: "dataTable{{$tabData['id']}}",
				                        filename: "dataTable{{$tabData['id']}}", //do not include extension
            							fileext: ".xls",
				                    });
				                });
								 @if (isset($manageBtns['total']))
                                        $("#totalRows{{$tabData['id']}}").empty().html("{{$rowsTotal}}");
                                @endif
        </script>
		<script type="text/javascript">
			// Tabs
			$("ul.tabs li").fadeIn(400);
			$("ul.tabs li:first").addClass("active").fadeIn(400);
			$(".tab_content:first").fadeIn();
		</script>
        @endforeach
    </div>
</div><!-- End UITab -->
@endsection

