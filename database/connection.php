<?php
$usuario = 'root';
$senha = '';
$database = 'techworld';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->connect_error) {
    die("Failed to connect to the database: " . $mysqli->connect_error);
}
?>