<?php
require('conexion.php');
$RegistrosAMostrar=20;

//estos valores los recibo por GET
if(isset($_GET['pag'])){
	$RegistrosAEmpezar=($_GET['pag']-1)*$RegistrosAMostrar;
	$PagAct=$_GET['pag'];
//caso contrario los iniciamos
}else{
	$RegistrosAEmpezar=0;
	$PagAct=1;
	
}
$Resultado=mysql_query("SELECT * FROM reportes ORDER BY ID DESC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar",$con);
echo "<table border='1px'>";
 
echo "<tr>";   
echo "<th>ID</th>";   
echo "<th>Nombre</th>";   
echo "<th background-color:#F5D0A9;>Hora</th>";
echo "<th>Reporte</th>";   
echo "</tr>";   
while($MostrarFila=mysql_fetch_array($Resultado)){
	echo "<tr>";
    echo "<td>".$MostrarFila['ID']."</td>";
    echo "<td>".$MostrarFila['Nombre']."</td>";
    echo "<td>".$MostrarFila['Hora']."</td>";
    
	echo "<td>".$MostrarFila['Reporte']."</td>";
	
	echo "</tr>";
}
echo "</table>";
//******--------determinar las páginas---------******//
$NroRegistros=mysql_num_rows(mysql_query("SELECT * FROM reportes",$con));

$PagAnt=$PagAct-1;
$PagSig=$PagAct+1;
$PagUlt=$NroRegistros/$RegistrosAMostrar;

//verificamos residuo para ver si llevará decimales
$Res=$NroRegistros%$RegistrosAMostrar;
// si hay residuo usamos funcion floor para que me
// devuelva la parte entera, SIN REDONDEAR, y le sumamos
// una unidad para obtener la ultima pagina
if($Res>0) $PagUlt=floor($PagUlt)+1;

//desplazamiento
echo "<a onclick=\"Pagina('1')\">PRIMERO</a> ";
if($PagAct>1) echo "<a onclick=\"Pagina('$PagAnt')\">ANTERIOR</a> ";
echo "<strong>Pagina ".$PagAct."/".$PagUlt."</strong>";
if($PagAct<$PagUlt)  echo " <a onclick=\"Pagina('$PagSig')\">SIGUIENTE</a> ";
echo "<a onclick=\"Pagina('$PagUlt')\">ULTIMO</a>";
?>
