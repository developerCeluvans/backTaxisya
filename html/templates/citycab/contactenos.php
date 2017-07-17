<?php
  
  $cone=mysql_connect("localhost","root","imaginamos2015");
  mysql_select_db("appsuser_taxisya_de");
  
?>

<script>
  function contactar(){
    var pais=document.getElementById('pais').value;
    var departamento=document.getElementById('departamento').value;
    var ciudad=document.getElementById('ciudad').value;
    var ciudad=document.getElementById('nombre').value;
    var ciudad=document.getElementById('mail').value;
    var ciudad=document.getElementById('message').value;
    
    if(!pais || !departamento || !ciudad || !nombre || !mail || !message){
      alert('Faltan datos por ingresar, por favor validar !');
    }else{
      alert('Se ha enviado la informacion correctamente, pronto nos comunicarmeos, gracias !');
      window.location='http://www.taxisya.co/';
    }
  }
</script>

<style>
  .campo_select{
    color: #fff;
    background: rgba(224, 119, 42, 0.7);
    border: 1px solid #FFA85F;
    border-radius: 5px;
    box-sizing: border-box;
    width:50%!important;
  }
</style>

<form id="formulario" action="http://www.taxisya.co/#sp-contactenos" method="post" name="formulario">

  <br/>

  <div style='text-align:left;'>
      <select class="campo_select" name="pais" id="pais" onchange="submit();">
        <option value="">Seleccionar Pa&iacute;s</option>
        <?php
          $cons="select id,name from cms_countries order by 2";
          $resu=mysql_query($cons);
          while($row=mysql_fetch_row($resu)){
            $id=$row[0];
            $name=utf8_encode($row[1]);
            $vali="";
            if($_REQUEST['pais']){
              if($_REQUEST['pais']==$id)
                $vali="selected";
            }
            echo "
              <option value='$id' $vali>$name</option>
            ";
          }
        ?>
      </select>
  </div>
  <div style='text-align:left;'>
      <select class="campo_select" name="departamento" id="departamento" onchange="submit();">
        <option value="">Seleccionar Departamento</option>
        <?php
          if($_REQUEST['pais'])
            $country=$_REQUEST['pais'];
          else
            $country=0;
          $cons="select id,name from cms_departments where country_id='$country' order by 2";
          $resu=mysql_query($cons);
          while($row=mysql_fetch_row($resu)){
            $id=$row[0];
            $name=utf8_encode($row[1]);
            $vali="";
            if($_REQUEST['departamento']){
              if($_REQUEST['departamento']==$id)
                $vali="selected";
            }
            echo "
              <option value='$id' $vali>$name</option>
            ";
          }
        ?>
      </select>
  </div>
  <div style='text-align:left;'>
      <select class="campo_select" name="ciudad" id="ciudad" onchange="submit();">
        <option value="">Seleccionar Ciudad</option>
        <?php
            $country=0;
            $departamento=0;
          if($_REQUEST['pais'])
            $country=$_REQUEST['pais'];
          if($_REQUEST['departamento'])
            $departamento=$_REQUEST['departamento'];
          $cons="select id,name from cms_cities where country_id='$country' and department_id='$departamento' order by 2";
          $resu=mysql_query($cons);
          while($row=mysql_fetch_row($resu)){
            $id=$row[0];
            $name=utf8_encode($row[1]);
            $vali="";
            if($_REQUEST['ciudad']){
              if($_REQUEST['ciudad']==$id)
                $vali="selected";
            }
            echo "
              <option value='$id' $vali>$name</option>
            ";
          }
        ?>
      </select>
  </div>
  
  <br/>
  
  <input id="nombre" class="nombre" name="nombre" type="text" placeholder="Digite su nombre o empresa" /> 
  </br>
  <input id="mail" class="mail" name="mail" type="text" placeholder="Digite su correo de contacto" /> 
  </br>
  <textarea id="message" class="message" name="message" placeholder="Cuéntanos"></textarea> 
  </br>
  <input id="enviar" class="enviar" type="button" value="Enviar" onclick="contactar();" />
</form>