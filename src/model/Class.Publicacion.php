<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');

class Publicacion 
{
	
	protected $nuId;
	protected $sbComentarios;
	protected $nuLikes;
	protected $dtFechaRegistro;
	protected $nuUsuarioId;
	
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
		
		$SQL = "insert into publicaciones values (0,
				'".$this->sbComentarios."',
				'".$this->nuLikes."',
				now(),
				'".$this->nuUsuarioId."')";
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
	public function update()
	{
		
		//Traemos la unica instancia de la clase conexion
		$db = Conexion::singleton();
		
		$SQL = "update  publicaciones set
		      	comentarios = '".$this->sbComentarios."',
				likes = '".$this->nuLikes."',
				fecha_registro =  '".$this->dtFechaRegistro."',
				usuario_id = '".$this->nuUsuarioId."'
				where id = '".$this->nuId."' ";
		
		$consulta = $db->consultas($SQL);
		
		if($consulta==1){
			
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
	public function getEstrellas()
	{
		
		$stars = $this->nuLikes/5;
		if($stars>10)
			return 10;
		if($stars<1)
		 	return 0;	
		return (int) $stars;
		
	}
	
	
}

?>