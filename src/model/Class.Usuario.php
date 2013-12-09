<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/../../plugins/SimpleImage/SimpleImage.class.php');

class Usuario 
{
	
	protected $nuId;
	protected $sbNombres;
	protected $sbApellidos;
	protected $sbEmail;
	protected $sbContrasenia;
	protected $sbSexo;
	protected $sbUrlFoto;
	protected $dtFechaNacimiento;
	protected $dtFechaRegistro;
	protected $nuPaisesId;
	protected $nuNumPublicaciones;
	protected $nuNumCommons;
	protected $nuNumPublicacionesDestacadas;
	
	public function setValue($name, $value)
	{
		$this->$name = trim($value);
	}
	
	public function getValue($name)
	{
		return $this->$name;
	}
	
	function getUrlMin()
	{
		return 'min_'.$this->sbUrlFoto;
		
	}
	
	public function update()
	{
		
		//Traemos la unica instancia de la clase conexion
		$db = Conexion::singleton();
		
		$SQL = "update  usuarios set
		      	nombres = '".$this->sbNombres."',
				apellidos = '".$this->sbApellidos."',
				email =  '".$this->sbEmail."',
				contrasenia = '".$this->sbContrasenia."',
				sexo = '".$this->sbSexo."',
				fecha_nacimiento = '".$this->dtFechaNacimiento."',
				url_foto = '".$this->sbUrlFoto."',
				paises_id = '".$this->nuPaisesId."'
				where id = '".$this->nuId."' ";
				
			
		$consulta = $db->consultas($SQL);
		
		if($consulta==1){
			
			return  $this;
			
		//devolvemos el resultado de la consulta
		}
		return false;						
		
	}
	
	public function getCantidadCommonAndPublicaciones()
	{
		//Traemos la unica instancia de la clase conexion
		$db = Conexion::singleton();
		
		$SQL = "select count(*) as num_publicaciones ,sum(likes) num_likes from publicaciones where usuario_id = ".$this->nuId;
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){		
			
			
			if ($Fila=mysql_fetch_array($consulta))
			{
				$this->nuNumPublicaciones = $Fila['num_publicaciones'];
				$this->nuNumCommons = $Fila['num_likes'];
			}//fin del while
			
			
		}//fin del if
	
		return false;			
		
	}//fin de la funcion
	
	public function getCantidadPublicacionesDestacadas()
	{
		//Traemos la unica instancia de la clase conexion
		$db = Conexion::singleton();
		
		$SQL = "select count(*) as num_publicaciones_destacadas  from publicaciones where likes > 49 and  usuario_id = ".$this->nuId;
		
		//ejcutamos el script sql utilizando el objeto db instanciado en el constructor
		$consulta = $db->consultas($SQL);
		
		if(mysql_num_rows($consulta)>0){		
			
			
			if ($Fila=mysql_fetch_array($consulta))
			{
				$this->nuNumPublicacionesDestacadas = $Fila['num_publicaciones_destacadas'];
				return $Fila['num_publicaciones_destacadas']; 
			}//fin del while
			
			
		}//fin del if
	
		return false;			
		
	}//fin de la funcion
	
	public function getEstrellas()
	{
		if($this->nuNumPublicacionesDestacadas != NULL)
		{
			
			$star = (int) $this->nuNumPublicacionesDestacadas/4;
			
		}
		else
		{
			$destacados = $this->getCantidadPublicacionesDestacadas();
			$star = (int) $destacados/4;
			
		}
		if($star>10)
			return 10;
		else 	return (int) $star;
		
	}
	
	public function getEdad()
	{
		if($this->dtFechaNacimiento != '0000-00-00')
		{
			$stamp = strtotime($this->dtFechaNacimiento);
			$c = date("Y",$stamp); 
			$b = date("m",$stamp); 
			$a = date("d",$stamp); 
			
			$anos = date("Y")-$c; 
			
			if(date("m")-$b > 0){ 
			}elseif(date("m")-$b == 0){ 
				if(date("d")-$a <= 0){ 
					$anos = $anos-1; 
				} 
			}else{ 
				$anos = $anos-1; 
			} 
			return $anos; 
		}
		return '';
		
	}
	
	
	public function getAnioRegistro()
	{
		$stamp = strtotime($this->dtFechaRegistro);
		return date("Y",$stamp); 	
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
	
	function redimencionarImagen()
	{
		
		//creamos un objeto de la clase SimpleImage
		$obj_simpleimage = new SimpleImage(); 
		
		$this->sbRutaFotos = dirname(__FILE__).'/../../web/uploads/';

		//valor del ancho
		$var_thumb_ancho = '135';
		$var_thumb_alto =  '135';	
		
		$sbExtencion = end(explode(".", $this->getValue('sbUrlFoto')));
			
		$obj_simpleimage->load($this->sbRutaFotos.$this->getValue('sbUrlFoto')); //leemos la imagen 
		
		$var_nuevo_archivo = rand(5, 15).$sbExtencion; //asignamos un nombre aleatorio al nuevo archivo, para evitar sobreescritura
		$obj_simpleimage->resizeToWidth($var_thumb_ancho); //redimensionamos la imagen, con los valores de ancho y alto que hemos especificado
		
	    //almacena el archivo con el nuevo  tamaño
		$obj_simpleimage->save($this->sbRutaFotos.'min_'.$this->getValue('sbUrlFoto')); //guardamos los cambios efectuados en la imagen
		
		
		
	}//FIN DE LA FUNCION
	
	
	
}//fin de la clase

?>