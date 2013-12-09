<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');

class Common 
{
	
	protected $nuId;
	protected $nuUsuarioId;
	protected $nuPublicacionId;
	protected $dtFechaRegistro;
	
	public function setValue($name, $value)
	{
		$this->$name = trim($value);
	}
	
	public function getValue($name)
	{
		return $this->$name;
	}
	
	public function save()
	{
		
		//Traemos la unica instancia de la clase conexion
		$db = Conexion::singleton();
		
		$SQL = "insert into commons values (0,
				'".$this->nuUsuarioId."',
				'".$this->nuPublicacionId."',
				now())";
				
			
		$consulta = $db->consultas($SQL);
		
		if($consulta==1){
			
			$SQL="select LAST_INSERT_ID();";
			$consulta = $db->consultas($SQL);
			$Fila=mysql_fetch_array($consulta);
		    $this->setValue('nuId',$Fila[0]) ; 		
			
			return  $this;
			
		//devolvemos el resultado de la consulta
		}
		return false;						
		
	}
	
	
	public function getVars() 
	{ 
		$vecVar = array();
		foreach ($this as $key => $value) 
		{ 
			$vecVar[$key] = $value; 
		} 
	   return $vecVar;
	}
	
	
}

?>