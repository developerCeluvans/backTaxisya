<?php 
function Conectar()
{
	if ($con=mysql_connect("localhost","root","jmnfgt116"))
	{	
		if (!$bd=mysql_select_db("taxisyaBD"))
			echo "Error Conectando la BD";
		return $con;
	}
	else
		echo "Error Conectando al Servidor";
}

/*
class MySQL{
  
  private $conexion; 
  
  public function MySQL(){ 
    if(!isset($this->conexion)){
      $this->conexion = (mysql_connect("localhost","root","jmnfgt116"))
        or die(mysql_error());
      mysql_select_db("taxisyaBD",$this->conexion) or die(mysql_error());
    }
  }  
}
*/
?>
