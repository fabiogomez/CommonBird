<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/Class.Usuario.php');
include_once(dirname(__FILE__).'/../../conf/Class.Config.php');

class UsuariosTable 
{
	
	protected $db;
 
	public function __construct()
	{
		//Traemos la unica instancia de la clase conexion
		$this->db = Conexion::singleton();
		
	}
	
	public function getById($nuId)
	{
		
		
		$SQL = "select 
				u.id as id,
				u.nombres as nombres,
				u.apellidos as apellidos,
				u.email as email,
				u.contrasenia as contrasenia,
				u.sexo as sexo,
				u.fecha_nacimiento as fecha_nacimiento,
				u.url_foto as url_foto,
				date(u.fecha_registro) as fecha_registro,
				u.paises_id as paises_id,
				p.nombre as pais_nombre
				from usuarios u,paises p where u.id = '".$nuId."' and p.id = u.paises_id ";
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $this->db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){
			
			
			
			if ($Fila=mysql_fetch_array($consulta)){
				
				$Usuario = new Usuario();
				
				$Usuario->setValue('nuId',$Fila['id']);
				$Usuario->setValue('sbNombres',$Fila['nombres']);
				$Usuario->setValue('sbApellidos',$Fila['apellidos']);
				$Usuario->setValue('sbEmail',$Fila['email']);
				$Usuario->setValue('sbContrasenia',$Fila['contrasenia']);
				$Usuario->setValue('sbSexo',$Fila['sexo']);
				$Usuario->setValue('dtFechaNacimiento',$Fila['fecha_nacimiento']);
				$Usuario->setValue('sbUrlFoto',$Fila['url_foto']);
				$Usuario->setValue('dtFechaRegistro',$Fila['fecha_registro']);
				$Usuario->setValue('nuPaisesId',$Fila['paises_id']);
				$Usuario->setValue('nuPaisesNombre',$Fila['pais_nombre']);
				
				return $Usuario;
				
				}//fin del while
			
			
			}//fin del if
	
		return false;	
		
	}
	
	
}

?>