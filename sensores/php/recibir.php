<?php

require_once ('conexion.php');

$dispositivo=$_GET['dispositivo'];
$temp=$_GET['temp'];
$humedad=$_GET['humedad'];
$servo=$_GET['servo'];
$led=$_GET['led'];

$conn= new conexion(); //creamos un objeto de la clase conexion

//Acomodamos la consulta, la escribimos
$queryINSERT="INSERT INTO `historico` (`dispositivo`, `temperatura`, `humedad`, `servo`, `led`, `fechaRegistro`) VALUES ('$dispositivo', '$temp', '$humedad', '$servo', '$led', NOW());";
$insert= mysqli_query($conn->conectardb(),$queryINSERT);

$queryUPDATE="UPDATE `estado` SET `temperatura` = '$temp', `humedad` = '$humedad' WHERE `estado`.`dispositivo` = '$dispositivo';";
$update= mysqli_query($conn->conectardb(),$queryUPDATE);




echo "Datos Recibidos <br>";

echo "Dispositivo:" .$dispositivo ."temperatura: " .$temp ."humedad: ".$humedad ."servo: ".$servo;


?>