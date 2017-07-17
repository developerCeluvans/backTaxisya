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
function ConectarCMS()
{
	if ($con=mysql_connect("localhost","root","jmnfgt116"))
	{	
		if (!$bd=mysql_select_db("appsuser_taxisya"))
			echo "Error Conectando la BD";
		return $con;
	}
	else
		echo "Error Conectando al Servidor";
}
?>
