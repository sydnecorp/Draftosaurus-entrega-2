<?php

// datos para conectarse a MySQL en XAMPP
$host = "localhost"; 
$user = "root";      // usuario por defecto en XAMPP
$pass = "";          // contraseña vacía por defecto
$db   = "draftosaurus"; // nombre de la base de datos

// crear la conexión
$conn = new mysqli($host, $user, $pass, $db);

// si falla, cortar ejecución y mostrar error
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// usar UTF-8 para evitar problemas con acentos y ñ
$conn->set_charset("utf8");
?>

