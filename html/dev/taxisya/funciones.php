<?php 
		function ConsultCedula($cedula){
			$cons = mysql_query("SELECT id FROM drivers WHERE cedula = '$cedula'");
			$cant = mysql_num_rows($cons);
			if ($cant>0)	return $cant;
		}
?>