
<script type="text/javascript" src="js/jquery.table2excel.js"></script>
<div class="row-fluid">
    @yield('customButtons')
</div>
<div class="row-fluid">
    <!-- Table widget -->
    <div class="widget  span12 clearfix">

        <div class="widget-header">
            <span><i class="icon-table"></i>@yield('title')</span>
        </div><!-- End widget-header -->	

        <div class="widget-content">
            <!-- Table UITab -->
            <!-- <div id="UITab" style="position:relative;"> -->
            <!--<ul class="tabs" >
                    <li ><a href="#tab1"></a></li>  
            </ul>-->
            <!--<div class="tab_container" >-->
            @yield('contentTable')
             <input type="button" id="extExcel" value="Exportar a Excel"/>					
            <!-- </div> -->
            <script type='text/javascript'>
                //DataTable
                $('#dataTable').dataTable({
                    "sDom": "<'row-fluid tb-head'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid tb-foot'<'span4'i><'span8'p>>",
                    "bJQueryUI": false,
                    "iDisplayLength": 50,
                    "sPaginationType": "bootstrap",
                    @yield('tablesorting')
                    "oLanguage": {
                        "sLengthMenu": "_MENU_",
                        "sSearch": "Buscar"
                    }
                });
            </script>
            <!-- </div>--><!-- End UITab -->
            <!-- <div class="clearfix"></div> -->

        </div><!--  end widget-content -->
    </div><!-- widget  span12 clearfix-->
</div><!-- End of row-fluid -->