<?
setlocale(LC_TIME, 'es_CO.UTF-8');
header('Content-Type: text/html; charset=UTF-8');

ini_set('date.timezone','America/Bogota');

$id=$_GET['id'];

include("configuration.php");
	
//Creamos la conexión
$conexion = mysqli_connect($My_host, $My_user, $My_passwd, $My_namedb) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

mysqli_set_charset($conexion, 'utf8');	
 
	
 $query = "DELETE FROM especies WHERE id = '".$id."'";
 
        if (mysqli_query($conexion, $query)) {
               //echo "Registro Borrado";
        } else {
               echo "Error: " . $query . "" . mysqli_error($conexion);
        } 	
 
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>

<script type="text/javascript">

setTimeout('window.parent.location.href = "index.php?b=ok"', 200);

</script>