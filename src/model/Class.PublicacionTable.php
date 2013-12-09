<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/Class.Publicacion.php');
include_once(dirname(__FILE__).'/../../conf/Class.Config.php');

class PublicacionTable 
{
	
	protected $db;
 
	public function __construct()
	{
		//Traemos la unica instancia de la clase conexion
		$this->db = Conexion::singleton();
		
	}
	
	public function listarByUsuario($page,$nuUsuarioId,$blFiltroDestacados)
	{
		
		return $this->listar($page,array('nuUsuarioId'=>$nuUsuarioId,'blFiltroDestacados'=>$blFiltroDestacados));
		
	}//fin del if
	
	public function listar($page,$vecPropiedades)
	{
		if(isset($vecPropiedades['nuUsuarioId']))
		{
			$nuUsuarioId = $vecPropiedades['nuUsuarioId'];
		}
		else $nuUsuarioId = '';
		
		if(isset($vecPropiedades['blFiltroDestacados']))
		{
			$blFiltroDestacados = $vecPropiedades['blFiltroDestacados'];
		}
		else $blFiltroDestacados = '';
		
		$dinamicWhere = '';
		
		if ($nuUsuarioId!='')
		{
			$dinamicWhere .= " and usuario_id ='".$nuUsuarioId."'";
		}//fin del if
		if ($blFiltroDestacados!='false' && $blFiltroDestacados!='')
		{
			$dinamicWhere .= " and likes >=50";
		}//fin del if
		
		//crea un objeto de tipo configuracion
		$objConfig = new Config();
		
		//obtiene el limite de post de la configuracion
		$limit  = $objConfig->limite_post_muro;
		
		// calculate the starting position of the rows
		$start = $limit*$page - $limit;
		
		$SQL = "select * from publicaciones where 1=1 $dinamicWhere order by fecha_registro desc  limit $start , $limit  ";
		
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			$Publicaciones = array();
			
			while ($Fila=mysql_fetch_array($consulta)){
				
				$objPublicacion = new Publicacion();
				
				$objPublicacion->setValue('nuId',$Fila['id']);
				$objPublicacion->setValue('sbComentarios',$Fila['comentarios']);
				$objPublicacion->setValue('nuLikes',$Fila['likes']);
				$objPublicacion->setValue('dtFechaRegistro',$Fila['fecha_registro']);
				$objPublicacion->setValue('nuUsuarioId',$Fila['usuario_id']);
				
				$Publicaciones[] = $objPublicacion;
				
				}//fin del while
			
			return $Publicaciones;
			
			}//fin del if
	
		return false;	
		
	}
	
	function getById($nuId)
	{
		
		
		$SQL = "select * from publicaciones where id = '".$nuId."' ";
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			
			if ($Fila=mysql_fetch_array($consulta)){
				
				$objPublicacion = new Publicacion();
				
				$objPublicacion->setValue('nuId',$Fila['id']);
				$objPublicacion->setValue('sbComentarios',$Fila['comentarios']);
				$objPublicacion->setValue('nuLikes',$Fila['likes']);
				$objPublicacion->setValue('dtFechaRegistro',$Fila['fecha_registro']);
				$objPublicacion->setValue('nuUsuarioId',$Fila['usuario_id']);
				
				return $objPublicacion;
				
				}//fin del while
			
			
			}//fin del if
	
		return false;	
		
	}
	
}

?>