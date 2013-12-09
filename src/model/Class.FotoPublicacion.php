<?php
include_once(dirname(__FILE__).'/Class.Conexion.php');
include_once(dirname(__FILE__).'/../../plugins/SimpleImage/SimpleImage.class.php');


class FotoPublicacion 
{
	
	protected $nuId;
	protected $sbUrlFoto;
	protected $sbDescripcion;
	protected $dtFechaRegistro;
	protected $dtPublicacionId;
	
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
		
		$SQL = "insert into fotos_publicacion values (0,
				'".$this->sbUrlFoto."',
				'".$this->sbDescripcion."',
				now(),
				'".$this->dtPublicacionId."'
				)";
				
		echo $SQL;	
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
	
	function getUrlMin()
	{
		return 'min_'.$this->sbUrlFoto;
	}
	
	function redimencionarImagen()
	{
		
		//creamos un objeto de la clase SimpleImage
		$obj_simpleimage = new SimpleImage(); 
		
		$this->sbRutaFotos = dirname(__FILE__).'/../../web/uploads/';

		//valor del ancho
		$var_thumb_ancho = '800';
		$var_thumb_alto =  '600';	
		
		$sbExtencion = end(explode(".", $this->getValue('sbUrlFoto')));
			
		$obj_simpleimage->load($this->sbRutaFotos.$this->getValue('sbUrlFoto')); //leemos la imagen 
		
		$var_nuevo_archivo = rand(5, 15).$sbExtencion; //asignamos un nombre aleatorio al nuevo archivo, para evitar sobreescritura
		$obj_simpleimage->resizeToWidth($var_thumb_ancho); //redimensionamos la imagen, con los valores de ancho y alto que hemos especificado
		
	    //almacena el archivo con el nuevo  tamaño
		$obj_simpleimage->save($this->sbRutaFotos.'min_'.$this->getValue('sbUrlFoto')); //guardamos los cambios efectuados en la imagen
		
		echo $this->sbRutaFotos.'min_'.$this->getValue('sbUrlFoto');
		
	}//FIN DE LA FUNCION
	
	
	
}

?>