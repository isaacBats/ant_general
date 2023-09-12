<?php

// Creo mi conexion
						//(Servidor, usuario, contraseña)
$conexion = mysql_connect("localhost","generalf_admin","beranime69");
//Parametros por si la conexion falla
if(!$conexion){
die('La base de datos no ha podido conectarse por: '.mysql_error());
}

//Creacion de la Base de Datos
if(mysql_query("CREATE DATABASE choferes",$conexion))
{
echo "Se ha creado la base de datos";
}

else{
echo "No se ha podido crear la base de datos por el siguiente error: ". mysql_error();
}

//Preparo esta peticion
mysql_select_db("choferes",$conexion);
$sql = "CREATE TABLE reportes
(
ID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(ID),
Nombre varchar(30),

Reporte varchar(255))";

//Ejecuto la peticion
mysql_query($sql,$conexion);


//Cerrar la conexion

mysql_close($conexion);

?>