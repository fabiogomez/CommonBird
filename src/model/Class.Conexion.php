<?php


class Conexion {
	
	private static $instance = null;

	public function __construct() 
	{
		
		$link = $this->ConectarseServidor();
		$conn = $this->ConectarseBaseDatos($link);
		
		
		
	}
	
	public static function singleton() 
	{
		if( self::$instance == null ) 
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	function ConectarseServidor()
	{
		if (!($link=mysql_connect("localhost","root","")))
		{
			echo "Error conectando a la base de datos.";
			exit();
		}
		
		return $link;
	}

	function ConectarseBaseDatos($link)
	{
		if (!mysql_select_db("common_bird",$link))
		{
			echo "Error seleccionando la base de datos.";
			exit();
		}
		//echo "Selecci�n con la base de datos conseguida.<br>";
	}

	function desconectarse($link)
	{
		if(!mysql_close($link))
		{
			echo "FALLO CERRANDO LA CONEXION";
			exit();
		}; //cierra la conexion
		//echo "se cerro la base de datos";
	}

	function consultas($consulta)
	{
		$respuesta=mysql_query($consulta);
		return $respuesta;
	}
	
}
?>