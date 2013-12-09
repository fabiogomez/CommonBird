<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/Class.FotoPublicacion.php');
include_once(dirname(__FILE__).'/../../conf/Class.Config.php');


class FotosPublicacionTable 
{
	
	protected $db;
 
	public function __construct()
	{
		//Traemos la unica instancia de la clase conexion
		$this->db = Conexion::singleton();
		
	}
	
	public function getByPublicacion($nuPublicacionId)
	{
		
		$SQL = "select * from fotos_publicacion where publicacion_id = '".$nuPublicacionId."' ";
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			$FotosPublicacion = array();
			
			while ($Fila=mysql_fetch_array($consulta))
			{
				$FotoPublicacion = new FotoPublicacion();
				
				$FotoPublicacion->setValue('nuId',$Fila['id']);
				$FotoPublicacion->setValue('sbUrlFoto',$Fila['url_foto']);
				$FotoPublicacion->setValue('sbDescripcion',$Fila['descripcion']);
				$FotoPublicacion->setValue('dtFechaRegistro',$Fila['fecha_registro']);
				$FotoPublicacion->setValue('dtPublicacionId',$Fila['publicacion_id']);
				
				$FotosPublicacion[] = $FotoPublicacion;
			}//fin del if
			
			return $FotosPublicacion;
			
		}//fin del if
	
		return false;	
		
	}
	
	public function getByUsuario($page,$nuUsuarioId)
	{
		
		//crea un objeto de tipo configuracion
		$objConfig = new Config();
		
		//obtiene el limite de post de la configuracion
		$limit  = $objConfig->limite_post_muro;
		
		// calculate the starting position of the rows
		$start = $limit*$page - $limit;
		
		$SQL = "select
				f_p.id as id,
				f_p.url_foto as url_foto,
				f_p.descripcion as descripcion,
				f_p.fecha_registro as fecha_registro,
				f_p.publicacion_id as publicacion_id
				
				from fotos_publicacion f_p, publicaciones p where p.id = f_p.publicacion_id and p.usuario_id = '".$nuUsuarioId."' order  by f_p.fecha_registro desc  limit $start , $limit  ";
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			$FotosPublicacion = array();
			
			while ($Fila=mysql_fetch_array($consulta))
			{
				$FotoPublicacion = new FotoPublicacion();
				
				$FotoPublicacion->setValue('nuId',$Fila['id']);
				$FotoPublicacion->setValue('sbUrlFoto',$Fila['url_foto']);
				$FotoPublicacion->setValue('sbDescripcion',$Fila['descripcion']);
				$FotoPublicacion->setValue('dtFechaRegistro',$Fila['fecha_registro']);
				$FotoPublicacion->setValue('dtPublicacionId',$Fila['publicacion_id']);
				
				$FotosPublicacion[] = $FotoPublicacion;
			}//fin del if
			
			return $FotosPublicacion;
			
		}//fin del if
	
		return false;	
		
	}
	
}

?>