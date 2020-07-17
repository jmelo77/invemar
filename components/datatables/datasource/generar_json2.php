<?php 

$server = "localhost";
$user = "root";
$pass = "";
$bd = "tripland";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
$sql = "SELECT cod_rsv AS rsv, producto.cod_producto AS codigo_producto, producto.nombre_producto2 AS nombre_producto,  DATE_FORMAT(detalle_reserva.fecha_entrada,'%d-%m-%Y') AS check_in, DATE_FORMAT(detalle_reserva.fecha_salida,'%d-%m-%Y') AS check_out,CONCAT(TRIM(cliente.nombres),' ',TRIM(cliente.apellidos)) AS nombre_cliente, cliente.email AS email, reserva.estado AS estado FROM cliente,reserva,detalle_reserva,producto WHERE reserva.id_cliente = cliente.id AND reserva.id = detalle_reserva.id_reserva AND detalle_reserva.id_producto = producto.id";
mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($conexion, $sql)) die();

$data = array(); //creamos un array

while($row = mysqli_fetch_array($result)) 
{ 
    $rsv=$row['rsv'];
	$codigo_producto=$row['codigo_producto'];
    $nombre_producto=$row['nombre_producto'];
    $check_in=$row['check_in'];
    $check_out=$row['check_out'];
    $nombre_cliente=$row['nombre_cliente'];
    $email=$row['email'];
    $estado=$row['estado'];

    $data[] = array('rsv'=> $rsv, 'codigo_producto'=> $codigo_producto, 'nombre_producto'=> $nombre_producto, 'check_in'=> $check_in, 'check_out'=> $check_out, 'nombre_cliente'=> $nombre_cliente, 'email'=> $email, 'estado'=> $estado);

}
    
//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  

//Creamos el JSON
$json_string = json_encode($data);
//echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:

//$file = 'clientes.json';
//file_put_contents($file, $json_string);

    

?>