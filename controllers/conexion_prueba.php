<?php
$db_username 	= 'root';
$db_password 	= '';
$db_name 	= 'bd_trasciendeprueba';
$db_host 	= 'localhost';


$con  = mysqli_connect('localhost','root','','bd_trasciendeprueba');
if(mysqli_connect_errno())
{
    echo 'Database Connection Error';
}

function conectar(){
    $host="localhost";
    $user="root";
    $pass="";

    $bd="bd_trasciendeprueba";
    $conexion=mysqli_connect($host,$user,$pass);
    mysqli_select_db($conexion,$bd);
    return $conexion;
}
?>