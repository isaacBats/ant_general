<?php

//Conexion a mysql
$conexion= mysql_connect("localhost","generalf_admin","beranime69");



//Nombro variables con metodo POST
$Nombre = $_POST['Nombre'];


$comandosql = "INSERT INTO reportes(nombre) VALUES($Nombre)";

$Reporte = $_POST['Reporte'];

//Selecciono mi Base de Datos
mysql_select_db("generalf_choferes",$conexion);
mysql_select_db("generalf_arturoalbarado",$conexion);


//Añado la onulta
$sql="INSERT INTO reportes (`Nombre`,`Reporte`) VALUES ('$Nombre','$Reporte')";

$resultado=mysql_query($sql);


//Cierro
mysql_close($conexion);

?>