<div class="header-internas">
  <div class="margen">
  
    <ul class="topnav">
<li class="m1"><a href="index.php?base&seccion=home" class="<?php if ($_GET['seccion'] == 'home'){echo 'activo-1';}?>"></a></li>
        <li class="m2"><a href="index.php?base&seccion=nosotros" class="<?php if ($_GET['seccion'] == 'nosotros'){echo 'activo-2';}?>" ></a></li>
          <li class="m4"><a href="index.php?base&seccion=servicios" class="<?php if ($_GET['seccion'] == 'servicios'){echo 'activo-2';}?>"></a></li>
           <li class="m5"><a href="index.php?base&seccion=carros" class="<?php if ($_GET['seccion'] == 'carros'){echo 'activo-2';}?>"></a></li>
           <li class="m6"><a href="index.php?base&seccion=clientes" class="<?php if ($_GET['seccion'] == 'clientes'){echo 'activo-2';}?>"></a></li>
        <li class="m3"><a href="index.php?base&seccion=reconocimiento" class="<?php if ($_GET['seccion'] == 'reconocimiento'){echo 'activo-2';}?>"></a></li>        
        <li class="m7"><a href="index.php?base&seccion=contactenos" class="<?php if ($_GET['seccion'] == 'contactenos'){echo 'activo-2';}?>"></a></li>
    </ul>
  </div>
</div>
<script type="text/javascript" >
    function soloNumeros(evt){
    //asignamos el valor de la tecla a keynum
    if(window.event){// IE
    keynum = evt.keyCode;
    }else{
    keynum = evt.which;
    }
    //comprobamos si se encuentra en el rango
    if(keynum>47 && keynum<58 || keynum==46){
    return true;
    }else{
    return false;
    }
}
</script>