<?php 

$host = "localhost";
$port = 3306;
$user = "root";
$pass = "";
$banco_de_dados = "biblioteca";

$conn = new mysqli($host, $user, $pass, $banco_de_dados, $port);
if ($conn->connect_error) {
    die("". $conn->connect_error);
} 

?>