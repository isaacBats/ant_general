<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reportes</title>
   <link rel="stylesheet" href="styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="script.js"></script>
<script>setTimeout('document.location.reload()',15000); </script>
<script type="text/javascript" src="ajax.js"></script>

<style type="text/css">

@font-face {
    font-family: '8pin_matrixregular';
    src: url('8-pm____-webfont.eot');
    src: url('8-pm____-webfont.eot?#iefix') format('embedded-opentype'),
         url('8-pm____-webfont.woff2') format('woff2'),
         url('8-pm____-webfont.woff') format('woff'),
         url('8-pm____-webfont.ttf') format('truetype'),
         url('8-pm____-webfont.svg#8pin_matrixregular') format('svg');
    font-weight: normal;
    font-style: normal;

}

/* Datagrid */
	body {
  font-family: '8pin_matrixregular', Arial, sans-serif;
  color: yellow;
font-weight: bold;
  background: linear-gradient( 0deg, #000   , #000);}
table {
  border-collapse: collapse;
  max-width: 100%;
width: 100%;
height: auto;
  font-size: 22px;
font-weight: bold;
}
th, td {
  padding: 0.25rem;
  border: 2px solid #000;

}

td {
  padding: 0.25rem;
  border: 3px solid #000;
background: #121212;
}
tbody tr:nth-child(odd) {
  background: #003b55;
}


a{
	color: #FFF;
	font-size: 14px;
	text-decoration: none;
font-family: Arial, sans-serif;
}

a:hover {
	color:#F60;
	font-size: 13px;
font-family: Arial, sans-serif;
}

#cuadro{
	width: 100%;
	background: #000;
	padding: 0px;
	margin: 0px auto;
	border: 2px solid #000;
}
#titulo{
	width: 100%;
	background: #000;
	color:white;
    font-size: 20px;
font-weight: bold;
}
	</style>
</head>

<body >
<div  id="cuadro">
<div id="contenido">
<table>
<tbody>

<?php include('paginador.php')?>
</tbody>
</table>
</div>
</div>

</body>
</html>
