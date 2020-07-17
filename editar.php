<?

if (!isset($_GET["id"])){
$id = 0;	
} else {
$id = $_GET['id'];		
}

include("configuration.php");

//Creamos la conexión
$conexion = mysqli_connect($My_host, $My_user, $My_passwd, $My_namedb) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

mysqli_set_charset($conexion, 'utf8');

//generamos la consulta
$sql = "SELECT *, DATE_FORMAT(fecha_captura,'%d-%m-%Y') AS fe_captura FROM especies WHERE id = '".$id."'";

if(!$result = mysqli_query($conexion, $sql)) die();

$data = array(); //creamos un array

while($row = mysqli_fetch_array($result)) 
{ 
    $id=$row['id'];
    $especie=$row['especie'];
	$familia=$row['familia'];
	$nombre_comun=$row['nombre_comun'];	
    $proyecto=ucfirst(strtolower($row['proyecto']));
    $base_del_registro=$row['base_del_registro'];
	$identificador=$row['identificador'];
    $ano_identificacion=$row['ano_identificacion'];
	$departamento=ucwords(strtolower($row['departamento']));
    $municipio=ucwords(strtolower($row['municipio']));
    $localidad=strtolower($row['localidad']);	
	$latitud = $row['latitud'];
	$longitud = $row['longitud'];
	$autor = $row['autor'];
	$fecha_captura = $row['fe_captura'];
	$ecorregion = $row['ecorregion'];	
	
}
    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/scrollbar.css">
	<link rel="stylesheet" href="css/jquery.mmenu.all.css">
	<link rel="stylesheet" href="css/prettyPhoto.css">
	<link rel="stylesheet" href="css/transitions.css">
	<link rel="stylesheet" href="css/main.css">

	<link rel="stylesheet" href="css/color.css">
	<link rel="stylesheet" href="css/responsive.css">

    <style>
	div.ui-datepicker{
 	font-size:12px;
	}

	.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, 		 	.col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, 	
	.col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, 	
	.col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
	padding-right: 5px;
	padding-left: 5px;	
	}
	
	</style>
     
	<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    
    <script src="js/vendor/jquery-library.js"></script>
 
    <script src="js/vendor/bootstrap.min.js"></script>
        
	<link href="styles/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
    
	<script src="scripts/bootstrap-dialog.min.js"></script>
    
	<link rel="stylesheet" href="jquery-ui-1.9.2.custom/development-bundle/themes/blitzer/jquery.ui.all.css" />

	<script type="text/javascript" src="jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

	<script type="text/javascript" src="jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker-es.js"></script>

	<script type="text/javascript" src="jquery-ui-1.9.2.custom/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

	<script type="text/javascript" src="jquery-ui-1.9.2.custom/development-bundle/ui/jquery-ui.custom.js"></script>

    
	<script type="text/javascript" src="scripts/loadingoverlay.min.js"></script>
    
                
	<script src="scripts/jquery.validate.js"></script>

	<script type="text/javascript">

	$().ready(function() {
	// validate the comment form when it is submitted ages_title
	

	// validate signup form on keyup and submit
	
	$("#editar").validate({
		submitHandler: function (form) {
         SubmittingForm();
        },		
		rules: {
			especie: "required", 
		    familia: "required",
			nombre_comun: "required",
			proyecto: "required",
			identificador: "required",
			ano_identificacion: "required",
			departamento: "required",
			municipio: "required",
			localidad: "required",		
			latitud: "required",
			longitud: "required",
			autor: "required",			
			fecha_captura: "required",
			ecorregion: "required",
			base_del_registro: "required"
		},
		messages: {
		    especie:  "Por favor digite especie",
		    familia:  "Por favor digite familia",
	        nombre_comun:   "Por favor digite nombre_comun",
		    proyecto: "Por favor digite proyecto",		
		    identificador:  "Por favor digite identificador",
			ano_identificacion:  "Por favor digite año identificacion",
		    departamento:  "Por favor digite departamento",
	        municipio:   "Por favor digite municipio",
		    localidad: "Por favor digite localidad",			
		    latitud:  "Por favor digite latitud",
		    longitud:  "Por favor digite longitud",
	        autor:   "Por favor digite autor",
		    fecha_captura: "Por favor digite fecha captura",
	        ecorregion:   "Por favor digite ecorregion",
		    base_del_registro: "Por favor digite base del registro",

			username: {
				required: "Please enter a username",
				minlength: "Your username must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			confirm_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Please enter the same password as above"
			},
			email: "Por favor ingrese un email valido.",
			email2: "Por favor ingrese un segundo email valido.",
			repite_email: {
				required: "Por favor digite nuevamente su email.",
				equalTo: "Por favor repita el email."
			},
			
			celular: {
				required: "Por favor digite su celular."
			},
			repite_celular: {
				required: "Por favor digite nuevamente su celular.",
				equalTo: "Por favor repite el celular."
			},			

			acepto: "Por favor acepte para continuar."
		}
	});


	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var fecha_inicial = $("#fecha_inicial").val();
		var fecha_final = $("#fecha_final").val();
		if(fecha_inicial && fecha_final && !this.value) {
			this.value = fecha_inicial + "." + fecha_final;
		}
	});

	//code to hide topic selection, disable for demo
	var newsletter = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital = newsletter.is(":checked");
	var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
});

</script>


<script language="JavaScript">
function onsubmitform()
{
	     if(document.pressed == 'Guardar') {
	     document.editar.action = 'guardar.php';
		 } 
}
</script>


<script language="JavaScript">
function acceptNum(e){
var charCode
if (navigator.appName == "Netscape") // Veo si es Netscape o Explorer (mas adelante lo explicamos)
charCode = e.which // leo la tecla que ingreso
else
charCode = e.keyCode // leo la tecla que ingreso
status = charCode
if (charCode > 31 && (charCode < 48 || charCode > 57)) { // Chequeamos que sea un numero comparandolo con los valores ASCII
// alert("Esto no es un Numero !!")
return false
}
return true
} 
</SCRIPT>

                        
</head>

<body>
					
                    <form name="editar" id="editar" method="post" onsubmit="return onsubmitform();">
                    
                    <input type="hidden" name="id" value="<?=$id;?>" />
                    
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        
												<div class="tg-box" style="padding: 20px;padding: 20px;">
													<div class="tg-heading text-center">
														<h3>Datos de la Especie</h3>
													</div>

													<div class="clearfix"></div> 
                        
													<div class="row">
                                                    
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Especie <sup>*</sup></label>
																<input type="text" name="especie" id="especie" value="<?=$especie;?>" class="form-control" placeholder="">
															</div>
														</div>
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Familia <sup>*</sup></label>
																<input type="text" name="familia" id="familia" value="<?=$familia;?>" class="form-control" placeholder="">
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Nombre Com&uacute;n <sup>*</sup></label>
																<input type="text" name="nombre_comun" id="nombre_comun" value="<?=$nombre_comun;?>" class="form-control" placeholder="">
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Proyecto <sup>*</sup></label>
																<input type="text" name="proyecto" id="proyecto" value="<?=$proyecto;?>" class="form-control" placeholder="">
															</div>
														</div>                                                                 
                                                                                              
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Identificador <sup>*</sup></label>
																<input type="text" name="identificador" id="identificador" value="<?=$identificador;?>" class="form-control" placeholder="">
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>A&ntilde;o Identificaci&oacute;n <sup>*</sup></label>
															
                                                                <select name="ano_identificacion" id="ano_identificacion" class="form-control">
                                                                <? for ($i = 1940; $i <= date("Y"); $i++) { 
																
																if ($i == $ano_identificacion) {
																$sel = "selected";	
																} else {
																$sel = "";	
																}
																
																?>

                                                                <option value="<?=$i;?>" <?=$sel;?>><?=$i;?></option>
                                                                
                                                                <? } ?>

																</select>     
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Departamento <sup>*</sup></label>
																<input type="text" name="departamento" id="departamento" value="<?=$departamento;?>" class="form-control" placeholder="">
															</div>
														</div> 
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Municipio <sup>*</sup></label>
																<input type="text" name="municipio" id="municipio" value="<?=$municipio;?>" class="form-control" placeholder="">
															</div>
														</div>                                                                                                               
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
															 <label>Localidad <sup>*</sup></label>
 															 <input type="text" name="localidad" id="localidad" value="<?=$localidad;?>" class="form-control" placeholder="">
															</div>
														</div>
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Latitud <sup>*</sup></label>
																<input type="text" name="latitud" id="latitud" value="<?=$latitud;?>" class="form-control" placeholder="">
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Longitud <sup>*</sup></label>
																<input type="text" name="longitud" id="longitud" value="<?=$longitud;?>" class="form-control" placeholder="">
															</div>
														</div>
                                                        
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Autor <sup>*</sup></label>
																<input type="text" name="autor" id="autor" value="<?=$autor;?>" class="form-control" placeholder="" style="background-color:#FFF;">
															</div>
														</div>
                                                                                                                
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Fecha Captura <sup>*</sup></label>
																<input type="text" name="fecha_captura" id="fecha_captura" value="<?=$fecha_captura;?>" class="form-control" placeholder="">
															</div>
														</div>
														<div class="col-xs-6 col-sm-4 col-md-6 col-lg-4">
															<div class="form-group">
																<label>Ecorregion <sup>*</sup></label>
																<input type="text" name="ecorregion" id="ecorregion" value="<?=$ecorregion;?>" class="form-control" placeholder="" style="background-color:#FFF;">
															</div>
														</div>
                                                        
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
															<div class="form-group">
																<label>Base del Registro <sup>*</sup></label>
																	<textarea name="base_del_registro" placeholder="" style="height:60px;border-bottom: 0px solid #dbdbdb;"><?=$base_del_registro;?></textarea>                                                       
															</div>
														</div>                                                        
         
                                                                                                                                              
													</div>   
                                              </div>        
									    </div>


                                        <center>
                                                                                                               
										<fieldset style="border: 0px solid #c0c0c0;">
                                           <input type="submit" name="enviar" id="enviar" value="Guardar" class="btn btn-info" onclick="document.pressed=this.value" style="height:35px; font:12px/0px 'Poppins', Arial, Helvetica, sans-serif; font-weight:bold;">
                                   
										</fieldset> 
                                                                                       
                                        </center>                         
     
                       </form>
                                                    
    <script type="text/javascript">
	$(function() {
		$( "#fecha_captura" ).datepicker({ 		
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
        changeYear: true,		
		numberOfMonths: 1 });
		});
	</script>           

    
</body>

</html>