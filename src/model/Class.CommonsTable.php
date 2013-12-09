<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/Class.Common.php');
class CommonTable 
{
	
	protected $db;
 
	public function __construct()
	{
		//Traemos la unica instancia de la clase conexion
		$this->db = Conexion::singleton();
		
	}
	
	public function getByPublicacionYUsuario($nuUsuarioId,$nuPublicacionId)
	{
		
		$SQL = "select * from commons where usuario_id = '".$nuUsuarioId."' and publicacion_id = '".$nuPublicacionId."' ";
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			
			if ($Fila=mysql_fetch_array($consulta))
			{
				
				return true;
				
			}//fin del if
			
			
			
		}//fin del if
	
		return false;	
		
	}
	
}

?>