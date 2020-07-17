<?php 

include("configuration.php");

//Creamos la conexión
$conexion = mysqli_connect($My_host, $My_user, $My_passwd, $My_namedb) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

mysqli_set_charset($conexion, 'utf8');

//generamos la consulta
$sql = "SELECT *, DATE_FORMAT(fecha_captura,'%d-%m-%Y') AS fe_captura FROM especies";

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
	
    $data[] = array('id'=> $id, 'especie'=> $especie, 'familia'=> $familia, 'nombre_comun'=> $nombre_comun, 'proyecto'=> $proyecto, 'base_del_registro'=> $base_del_registro, 'identificador'=> $identificador, 'ano_identificacion'=> $ano_identificacion, 'departamento'=> $departamento, 'municipio'=> $municipio, 'localidad'=> $localidad, 'latitud'=> $latitud, 'longitud'=> $longitud, 'autor'=> $autor, 'fecha_captura'=> $fecha_captura, 'ecorregion'=> $ecorregion);

}
    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  

//Creamos el JSON
$json_string = json_encode($data);

?>