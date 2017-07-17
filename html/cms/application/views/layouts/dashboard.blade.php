<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{$title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
        <meta name="generator" content="TextMate http://macromates.com/">
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
        <script type="text/javascript" src="js/webcam.js"></script>
        <script type="text/javascript" src="js/zice.custom.js"></script>
        
    </head>        
    <body> 
        <div id="google_translate_element" style="text-align:right;margin-right:3%;position:fixed;z-index: 999;width:100%;background:#ffffff;"></div>
        <script>
          function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, autoDisplay: false}, 'google_translate_element');
          }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <br/><br/>
        @include('common.header')
        @include('common.leftmenu')        
        <div id="content" >
            <div class="inner">

                <div class="row-fluid">
                    <div class="span12 clearfix">
                        <div class="logo"></div>
                        <!-- 
                        <ul id="shortcut" class="clearfix">
                              <li> <a href="#" title="Back To home"> <img src="images/icon/shortcut/home.png" alt="home"/><strong>Home</strong> </a> </li>
                              <li> <a href="#" title="Website Graph"> <img src="images/icon/shortcut/graph.png" alt="graph"/><strong>Graph</strong> </a> </li>
                              <li> <a href="#" title="Setting" > <img src="images/icon/shortcut/setting.png" alt="setting" /><strong>Setting</strong></a> </li> 
                              <li> <a href="#" title="Messages"> <img src="images/icon/shortcut/mail.png" alt="messages" /><strong>Message</strong></a><div class="notification" >10</div></li>
                        </ul>
                        -->
                    </div>
                </div> 
                <div id='mainContainer'>
                    <div class="row-fluid">

                        <!-- Dashboard  widget -->
                        <div class="widget  span12 clearfix">

                            <div class="widget-header">
                                <span><i class="icon-home"></i> Administrador de contenido </span>
                            </div><!-- End widget-header -->	

                            <div class="widget-content">
                                <!--                                <div class="boxtitle">website status</div>-->
                                <div class="row-fluid">
                                    <div class="span6">
                                        <img src="images/001.png">
                                        <!--<table class="chart-pie">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="color : #aed741;">Product Review</th>
                                                    <th style="color : #bedd17;">Webboard</th>
                                                    <th style="color : #c3e171;">Article</th>
                                                    <th style="color : #85b501;">Other</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th></th>
                                                    <td>75</td>
                                                    <td>10</td>
                                                    <td>9</td>
                                                    <td>6</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="chart-pie-shadow"></div>
                                        <div class="chart_title"><span>Pages is popular  in your web</span></div> -->
                                    </div><!-- span6 column-->
                                    <div class="span6">
                                        <!-- 
                                        <form action="">
                                            <div class="section">
                                                <label> Website Name <small>Text custom</small></label>
                                                <div><input type="text" name="sitename" id="sitename"  class=" full"  value="Yoursite.com" /></div>
                                            </div>

                                            <div class="section">
                                                <label> Website title <small>Text custom</small></label>
                                                <div><input type="text" name="sitename" class=" full" /></div>
                                            </div>

                                            <div class="section">
                                                <label> Status <small>website status </small></label>
                                                <div> <input type="checkbox" id="online" name="online"   class="online"  value="1"   checked="checked" /></div>
                                            </div>

                                            <div class="section">
                                                <label> SEO metaTag <small>Text custom</small></label>
                                                <div>
                                                    <input id="tags_input" type="text" class="tags" value="webstie,manager,webdesign,roffle" />
                                                </div>
                                            </div>

                                            <div class="section last">
                                                <div>
                                                    <a class="btn loading"  title="Saving"  rel="1" > save</a> <a class="btn btn-danger" >button</a> <a class="btn  confirm" >button</a>
                                                </div>
                                            </div>
                                        </form> -->
                                    </div><!-- span6 column-->

                                </div><!-- row-fluid column-->
                            </div><!--  end widget-content -->
                        </div><!-- widget  span12 clearfix-->
                    </div>
                </div><!-- row-fluid -->
                @include('common.footer')

            </div> <!--// End inner -->
        </div> <!--// End ID content --> 


    </body>
</html>
