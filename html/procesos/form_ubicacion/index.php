<?php
  $cone=mysql_connect("localhost","root","imaginamos2015");
  mysql_select_db("appsuser_taxisya_de");
?>

<style>
  .titulo_form_ubicacion{
    font-weight: normal !important;
    color: #FFD779;
    font-family: 'Montserrat Alternates', sans-serif;
  }
  .campo_select{
    width: 84%!important;
  }
</style>

<form action="http://www.taxisya.co/#sp-middle-wrapper" method="POST">
  <b>Recuerde que para realizar un agendamiento debe estar registrado en el sistema, registrese <a href='http://www.taxisya.co/taxisya/registro_pasajeros.php'>aquí</a></b>
  <br/>
  <input type='hidden' id='proc' name='proc' />
  <div class="form-group gcore-form-row" id="form-row-text10">
    <label for="text10" class="control-label gcore-label-left required_label">
      Correo Electr&oacute;nico:  
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-text10">
      <input name="mail" id="mail" required value="" placeholder="" maxlength="" size="60" class="validate['required'] form-control A" title="" style="" data-inputmask="" data-load-state="" data-tooltip="" type="email">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-datepicker2">
    <label for="datepicker2" class="control-label gcore-label-left">Tipo de Agendamiento*</label>
    <br>
    <div class="gcore-input gcore-display-table" id="fin-datepicker1">
      <select name="tipo_agen" id="tipo_agen" style="width: 465px;color: #fff;background: rgba(224, 119, 42, 0.7);border: 1px solid #FFA85F;">
        <option value="">- Seleccionar -</option>
        <option value="4">Por horas</option>
        <option value="2">Fuera de la ciudad</option>
        <option value="1">Aeropuerto</option>
        <option value="3">Mensajeria</option>
      </select>
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-text3">
    <label for="text3" class="control-label gcore-label-left required_label">
      Inicio de destino* 
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-text3">
      <input name="inicio" id="inicio" value="" placeholder="" maxlength="" size="60" class="validate['required'] form-control A" title="" style="" data-inputmask="" data-load-state="" data-tooltip="" type="text">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-text4">
    <label for="text4" class="control-label gcore-label-left required_label">
      Fin de destino* 
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-text4">
      <input name="fin" id="fin" value="" placeholder="" maxlength="" size="60" class="validate['required'] form-control A" title="" style="" data-inputmask="" data-load-state="" data-tooltip="" type="text">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-radio7">
    <label for="radio7" class="control-label gcore-label-left gcore-label-checkbox required_label">
      choose vehicle 
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-radio7">
      <div class="gcore-single-column" id="fclmn13">
        <div class="gcore-radio-item" id="fitem6">
          <input name="radio7" id="radio75" value="0" class="validate['group:7'] A" title="" style="" data-load-state="" data-tooltip="" type="radio">
          <label class="control-label gcore-label-checkbox" for="radio75">town taxi</label>
        </div>
        <div class="gcore-radio-item" id="fitem8">
          <input name="radio7" id="radio77" value="1" class="validate['group:7'] A" title="" style="" data-load-state="" data-tooltip="" type="radio">
          <label class="control-label gcore-label-checkbox" for="radio77">hybrid taxi</label>
        </div>
        <div class="gcore-radio-item" id="fitem10">
          <input name="radio7" id="radio79" value="2" class="validate['group:7'] A" title="" style="" data-load-state="" data-tooltip="" type="radio">
          <label class="control-label gcore-label-checkbox" for="radio79">limousine taxi</label>
        </div>
        <div class="gcore-radio-item" id="fitem12">
          <input name="radio7" id="radio711" value="3" class="validate['group:7'] A" title="" style="" data-load-state="" data-tooltip="" type="radio">
          <label class="control-label gcore-label-checkbox" for="radio711">suv taxi</label>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-text10">
    <label for="text10" class="control-label gcore-label-left required_label">
      Tel&eacute;fono:  
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-text10">
      <input name="telefono" id="telefono" required value="" placeholder="" maxlength="" size="60" class="validate['required'] form-control A" title="" style="" data-inputmask="" data-load-state="" data-tooltip="" type="text">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-datepicker2">
    <label for="datepicker2" class="control-label gcore-label-left required_label">
      Cuando* 
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-datepicker2">
      <input name="cuando" id="cuando" value="" data-gdatetimepicker-format="d-m-Y" placeholder="" size="60" class="validate['required'] form-control A" title="" style="" data-load-state="" data-tooltip="" type="date" data-gdatetimepicker="1">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-text9">
    <label for="text9" class="control-label gcore-label-left required_label">
      Hora* 
      <i class="fa fa-asterisk" style="color:#ff0000; font-size:9px; vertical-align:top;width:100%;"></i>
    </label>
    <div class="gcore-input gcore-display-table" id="fin-text9" style='width: 33%;'>
      <input name="hora" id="hora" value="" placeholder="" maxlength="" style='width: 100%!important;' size="60" class="validate['required'] form-control A" title="" style="" data-inputmask="" data-load-state="" data-tooltip="" type="time">
    </div>
  </div>
  <div class="form-group gcore-form-row" id="form-row-button8">
    <div class="gcore-input gcore-display-table" id="fin-button8">
      <input name="button8" id="button8" type="button" onclick="document.getElementById('proc').value='registrar_agenda';submit();" value="Agendar" class="btn btn-primary btn-large" style="" data-load-state="">
    </div>
  </div>
</form>