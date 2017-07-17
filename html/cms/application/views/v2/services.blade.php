<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Servicios</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
			<!-- Link shortcut icon-->
			<link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

			<!-- CSS Stylesheet-->
			<link type="text/css" rel="stylesheet" href="components/bootstrap/bootstrap.css" />
			<link type="text/css" rel="stylesheet" href="components/bootstrap/bootstrap-responsive.css" />
			<link type="text/css" rel="stylesheet" href="css/zice.style.css"/>


			<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="components/flot/excanvas.min.js"></script><![endif]-->

        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="components/ui/jquery.ui.min.js"></script>
        <script type="text/javascript" src="components/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="components/ui/timepicker.js"></script>
        <script type="text/javascript" src="components/colorpicker/js/colorpicker.js"></script>
        <script type="text/javascript" src="components/form/form.js"></script>
        <script type="text/javascript" src="components/elfinder/js/elfinder.full.js"></script>
        <script type="text/javascript" src="components/datatables/dataTables.min.js"></script>
        <script type="text/javascript" src="components/fancybox/jquery.fancybox.js"></script>
        <script type="text/javascript" src="components/jscrollpane/jscrollpane.min.js"></script>
        <script type="text/javascript" src="components/editor/jquery.cleditor.js"></script>
        <script type="text/javascript" src="components/chosen/chosen.js"></script>
        <script type="text/javascript" src="components/validationEngine/jquery.validationEngine.js"></script>
        <script type="text/javascript" src="components/validationEngine/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="components/fullcalendar/fullcalendar.js"></script>
        <script type="text/javascript" src="components/flot/flot.js"></script>
        <script type="text/javascript" src="components/uploadify/uploadify.js"></script>
        <script type="text/javascript" src="components/Jcrop/jquery.Jcrop.js"></script>
        <script type="text/javascript" src="components/smartWizard/jquery.smartWizard.min.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js"></script>
        <script type="text/javascript" src="js/zice.custom.js"></script>

		</head>
		<body>
			@include('common.header')
			@include('common.leftmenu')

			<div id="content" >
				<div class="inner">

					<div class="row-fluid">
						<div class="span12 clearfix">
							<div class="logo"></div>
						</div>
					</div>
					<div id='mainContainer'>
					<p><h3>Podrá revisar en qué estado están los servicios solicitados por los usuarios. </h3></p>
						<ul class="tabs">
							<li style="display: list-item;" class="active" ><a href="#tab1">En espera</a></li>
							<li style="display: list-item;"><a href="#tab2">Asignado</a></li>
							<li style="display: list-item;"><a href="#tab3">Finalizado</a></li>
							<!--li style="display: list-item;"><a href="#tab4">Cancelados</a></li-->
							<li style="display: list-item;"><a href="#tab5">Canc. Sistema</a></li>
							<li style="display: list-item;"><a href="#tab6">Canc. Conductor</a></li>
							<li style="display: list-item;"><a href="#tab7">Canc. Operadora</a></li>
						</ul>

						<div class="tab_container">
							<div id="tab1" class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-1">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
											<!-- <th>Opciones</th> -->
										</tr>
									</thead>
									<tbody>
										@foreach($waiting_services as $service)
											<tr>
											<td>{{ $service->id }}</td>
											<td>{{ $service->user->name  .' '. $service->user->lastname}}</td>
											<td></td>
											<td></td>
											<td>{{ $service->state->descrip}}</td>
											<td>{{ $service->created_at }}</td>
											<td>{{ $service->updated_at }}</td>
											<td></td>
											<td>{{ $service->index_id .' '. $service->comp1 .' '. $service->comp2 .' '. $service->no .' '. $service->obs }}</td>
											<td>
												<span class="tip" >
													<img title="Cancelar" src="images/icon/color_18/cancel.png" id="service-{{$service->id}}-cancel" onclick='dataPoster(this.id)'>
												</span>
											</td> 
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div id="tab2" class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-2">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="tab3" class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-3">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="tab4" class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-4">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="tab5"  class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-5">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="tab6"  class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-6">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="tab7"  class="tab_content">
								<table class="table table-bordered table-striped" id="data-table-7">
									<thead>
										<tr>
											<th>Número</th>
											<th>Nomb. Usuario</th>
											<th>Conductor</th>
											<th>Vehículo</th>
											<th>Estado</th>
											<th>Solicitud</th>
											<th>Finalización</th>
											<th>Calificación</th>
											<th>Dirección</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div><!-- row-fluid -->
					@include('common.footer')

				</div> <!--// End inner -->
			</div> <!--// End ID content -->

			<script>
				$('#data-table-1').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/1/json"
				});
				$('#data-table-2').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/2/json"
				});
				$('#data-table-3').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/5/json"
				});
				$('#data-table-4').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/7/json"
				});
				$('#data-table-5').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/7/json"
				});
				$('#data-table-6').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/8/json"
				});
				$('#data-table-7').dataTable({
					"sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
					"bJQueryUI": false,
					"iDisplayLength": 50,
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_",
						"sSearch": "Buscar"
					},
					"bFilter": true,
					"bServerSide": true,
					"sAjaxSource": "http://www.taxisya.co/cms/public/v2/services/9/json"
				});
    // // Tabs
    // $("ul.tabs li").fadeIn(400);
    // $("ul.tabs li:first").addClass("active").fadeIn(400);
    // $(".tab_content:first").fadeIn();
    // $("ul.tabs li").live('click', function() {
    //     $("ul.tabs li").removeClass("active");
    //     $(this).addClass("active");
    //     var activeTab = $(this).find("a").attr("href");
    //     $('.tab_content').fadeOut();
    //     $(activeTab).delay(400).fadeIn();
    //     ResetForm();
    //     return false;
    // });
			</script>
		</body>
		</html>




