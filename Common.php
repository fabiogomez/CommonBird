<?php

//obtiene los datos del usuario logueado
include_once(dirname(__FILE__).'/libs/Class.MyUser.php');
include_once(dirname(__FILE__).'/src/model/Class.UsuariosTable.php');
include_once(dirname(__FILE__).'/conf/Class.Config.php');
		
//crea un objeto de tipo configuracion
$objConfig = new Config();		


$objMyUser = new MyUser();
if($objMyUser->getValue('nuId')=='')header('Location: index.php');;

//crea un objeto para traer los datos del usuario del post
$objUsuariosTable = new UsuariosTable();
//obtiene los datos del usuario del post
$objUsuario = $objUsuariosTable->getById($objMyUser->getValue('nuId'));
//inicializa la url de la foto
$sbUrlFotoUsuario = ($objUsuario->getValue('sbUrlFoto')!='')?$objConfig->url_app.'/web/uploads/'.$objUsuario->getValue('sbUrlFoto'):'img/Iconos_Profile-02.png';
//setea la direccion completa de la imgen de perfil del usuario
$objUsuario->setValue('sbUrlFoto',$sbUrlFotoUsuario);					

//obtiene la cantidad de commons y publicaciones del usuario
$objUsuario->getCantidadCommonAndPublicaciones();	

//obtiene la cantidad de publicaciones destacadas del usuario
$objUsuario->getCantidadPublicacionesDestacadas();	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Commonbird</title>
<link rel="shortcut icon" href="img/Icon.ico" type="image/x-icon"/>
<meta http-equiv="x-ua-compatible" content="IE=EmulateIE7" />
<meta http-equiv="x-ua-compatible" content="IE=EmulateIE8" />

<!-- CSS  ================================================== -->  
<link href="css/common_style.css" rel="stylesheet" type="text/css" />
	<link href="css/subir_img.css" rel="stylesheet" type="text/css" />
   
<!--<link rel="stylesheet" href="css/moodalbox.css" type="text/css" media="screen" />-->

<!-- END CSS  ================================================== -->
 <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
 <script src="js/File Inputs.js" type="text/javascript"> </script>
<script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script>
 <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"> </script>
 <script src="js/myjs/view/Common.js" type="text/javascript"> </script>

 <!-- script reset formulario -->
   	<script>/*jQuery.fn.reset = function () {
		$(this).each (function() { if (!$(this).is(‘:hidden’)) this.reset(); });
		
        $("#publicacion").reset();
		
		}*/
	</script>
    <!--fin reset-->
<script src="src/jquery.mousewheel.js"></script>
<script src="src/perfect-scrollbar.js"></script>

</script>
<script type="text/javascript">
</script>

<script type="text/javascript">
function ocultareldiv() {
document.getElementById("modal").style.display = "none" ; // permite ocultar el contenedor al hacer clic en alguna parte de éste mediante display:none en el elemento #modal
}</script>

<!-- SCROLL --><!-- SCROLL --><!-- SCROLL -->
<script type="text/javascript">
	$(document).ready(function ($) {
    $('#modalbox_image_mini').perfectScrollbar({
    wheelSpeed: 25,
    wheelPropagation: false
    });
    });
</script>

<script type="text/javascript">
	$(document).ready(function ($) {
    $('#modalbox_image_mini').perfectScrollbar({
    wheelSpeed: 25,
    wheelPropagation: false
    });
    });
</script>  
<!-- SCROLL --><!-- SCROLL --><!-- SCROLL -->

</head>


<!-- BACKGROUND  ================================================== -->

<body background="img/background_CommonBird.jpg" style="background-attachment: fixed">

<!-- BACKGROUND  ================================================== -->

<header>

    <div id="header">

	<!-- GREEN BAR	================================================== -->
    
    			<!-- NAV	================================================== -->
     			<div id="Nav_div" align="right">
                </div>
                <!-- END NAV	================================================== -->
                
                <!-- BUTTONS LOGO NAV	================================================== -->
    			<div id="Head_nav" align="center">
					<div class="Common"><a href="Common.php" id="a_button">Common</a></div>
                    <div class="Profile"><a href="profile.php?id=<?php echo $objUsuario->getValue('nuId') ?>" id="a_button">Perfil</a></div>
                     <div ><a href="php/Salir.php" id="">Salir</a></div>
				
				</div>
                <div id="Logo" align="center">
				<a href="Common.php"><img src="img/png/LOGO_COMMONBIRD_CS5-03.png" align="center" width="165px" height="27px" vspace="4" hspace="0" /></a>
                </div>
                <!-- END BUTTONS LOG	O NAV	================================================== -->
                
		</div>
    <!-- END GREEN BAR	================================================== -->
     
</header>
	
    <!-- CONTAINER MAIN	================================================== -->
    <div id="Container_Main"> 
    
    	<!-- CONTAINER LEFT	================================================== -->
        <div id="Container_left">

            <!-- PHOTO	================================================== -->
            <div id="Container_Photo">
            	<img src="<?php echo $objUsuario->getValue('sbUrlFoto') ?>" width="100%" height="100%"/></a>
			</div>
            <!-- END PHOTO	================================================== -->

           	<!-- NAME	================================================== -->
            <div id="name">
              <a href="profile.php?id=<?php echo $objUsuario->getValue('nuId') ?>" class="a_name"><?php echo $objMyUser->getValue('sbNombres').' '.$objMyUser->getValue('sbApellidos'); ?></a>
            </div>

           	<!-- END NAME	================================================== -->
            <!-- STARS	================================================== -->
            <div id="container_stars" title="Member Rate">
            	<img src="img/stars_<?php echo $objUsuario->getEstrellas() ;?>.png" />
               
           	</div>
            
            <div id="data">
            	<div id="publicaciones_data" title="# Publicaciones">
                		<p class="numbers"><?php echo $objUsuario->getValue('nuNumPublicaciones'); ?></p>
                    	<p class="text">PUBLICACIONES</p>
                </div>
                <div id="publicaciones_data" title="# Common">
                		<p class="numbers"><?php echo $objUsuario->getValue('nuNumCommons'); ?></p>
                    	<p class="text">COMMON</p>
                </div>
                <div id="publicaciones_data_right" title="Destacados">
                		<p class="numbers"><?php echo $objUsuario->getValue('nuNumPublicacionesDestacadas'); ?></p>
                    	<p class="text">DESTACADOS</p>
                </div>
            </div>
            <!-- END STARS	================================================== -->

        </div>
        <!-- END CONTAINER LEFT	================================================== -->
        
        <!-- CONTAINER POST	================================================== -->
        <div id="Container_post" >
        	
            <table>
	            <form class=""  method="post"  id="publicacion">
        	  <tr>
              <td><textarea name="publicacion" id="txtPublicacion" cols="20" rows="5" placeholder="Pajarea con nosotros" title="Pajarea con nosotros" role="textbox" type="text"  aria-label="Pajarea con nosotros" style="overflow-y: visible"   ></textarea>
              </td>
              </tr>
  
          	<tr>
            <!--boton imagenes -->
           
            <td id="td_publicar">	
            	<div>
  					<div id="fotoUpload">Fotos</div>                       
				
                 <input type="hidden" id="nuIdPost" value="null">
                   
                </div>
            </td>
            </tr>
            <tr>
           
            <td>
            <input  type="button" value="" id="enviar" align="right" />
            
            </td>
            
            </tr>
            </form>
            </table>
        </div>
        <!-- END CONTAINER POST	================================================== -->
        
        
        <!-- CONTAINER RIGHT	================================================== -->
        	<div id="container_right">
            

<!-- POST 					***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************** -->


                <div id="post_users">
                       
                </div>
                <a href="javascript: void(0)" id="cmdVerMasPublicaciones">Ver mas...</a>
                <div id="page" style="visibility:hidden">1</div>

        
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        
 			<div  id="modalDetallePost" role="dialog" class="modal hide fade" >
            	
            </div>
        
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        <!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX --><!-- MODALBOX -->
        

<!-- END POST 					***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************** -->


        </div>   
        <!-- END CONTAINER RIGHT	================================================== -->

	</div> 
    <!-- END CONTAINER MAIN	================================================== -->
    
    
</body>
</html>