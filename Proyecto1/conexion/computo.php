<?php
$host= "localhost";
$usuario= "d52024";
$pass= "12345";
$db= "computo";

try{
    $conexion = new PDO ("mysql: host=$host; dbname:$db;", $usuario,$pass);
echo("se conecto a la db de computo");
}catch (PDOException $e) {
    ('Error: '.$e ->getMessage());
}

?>