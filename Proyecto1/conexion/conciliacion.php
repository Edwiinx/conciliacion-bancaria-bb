<?php
$host= "localhost";
$usuario= "d52024";
$pass= "12345";
$db= "conciliacion";

try{
    $conexion = new PDO ("mysql: host=$host; dbname=$db;", $usuario,$pass);
echo("");

}catch (PDOException $e) {
    ('Error: '.$e ->getMessage());
}

?>