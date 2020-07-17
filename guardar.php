<?
setlocale(LC_TIME, 'es_CO.UTF-8');
header('Content-Type: text/html; charset=UTF-8');

ini_set('date.timezone','America/Bogota');

    $id=$_POST['id'];
    $especie=$_POST['especie'];
	$familia=$_POST['familia'];
	$nombre_comun=$_POST['nombre_comun'];
    $proyecto=$_POST['proyecto'];
    $base_del_registro=$_POST['base_del_registro'];
	$identificador=$_POST['identificador'];
    $ano_identificacion=$_POST['ano_identificacion'];
	$departamento=$_POST['departamento'];;
    $municipio=$_POST['municipio'];
    $localidad=$_POST['localidad'];	
	$latitud=$_POST['latitud'];
	$longitud=$_POST['longitud'];
	$autor=$_POST['autor'];
	$fecha_captura=$_POST['fecha_captura'];
	$ecorregion=$_POST['ecorregion'];	
	
	$ano = substr($fecha_captura, 6, 4);
	$mes = substr($fecha_captura, 3, 2);
	$dia = substr($fecha_captura, 0, 2);
	$fecha_captura = $ano."-".$mes."-".$dia;	
	

include("configuration.php");
	
//Creamos la conexión
$conexion = mysqli_connect($My_host, $My_user, $My_passwd, $My_namedb) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

mysqli_set_charset($conexion, 'utf8');	
 

if ($id == 0){
		  
$query = "INSERT INTO especies (especie, familia, nombre_comun, proyecto, base_del_registro, identificador, ano_identificacion, departamento, municipio, localidad, latitud, longitud, autor, fecha_captura, ecorregion) VALUES ( '$especie', '$familia', '$nombre_comun', '$proyecto', '$base_del_registro', '$identificador', '$ano_identificacion', '$departamento', '$municipio', '$localidad', '$latitud', '$longitud', '$autor', '$fecha_captura', '$ecorregion')";

        if (mysqli_query($conexion, $query)) {
               //echo "Registro ingresado correctamente";
        } else {
               echo "Error: " . $query . "" . mysqli_error($conexion);
        }
 
 
} else {
	
 $query = "UPDATE especies SET especie = '$especie', familia = '$familia', nombre_comun = '$nombre_comun', proyecto = '$proyecto', base_del_registro = '$base_del_registro', identificador = '$identificador', ano_identificacion = '$ano_identificacion', departamento = '$departamento', municipio = '$municipio', localidad = '$localidad', latitud = '$latitud', longitud = '$longitud', autor = '$autor', fecha_captura = '$fecha_captura', ecorregion = '$ecorregion' WHERE id = '".$id."'";
 
        if (mysqli_query($conexion, $query)) {
               //echo "Registro actualizado correctamente";
        } else {
               echo "Error: " . $query . "" . mysqli_error($conexion);
        } 
 
}	
 
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>

<script type="text/javascript">

setTimeout('window.parent.location.href = "index.php?s=ok"', 200);

</script>