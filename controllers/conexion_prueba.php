<?php
$db_username 	= 'root';
$db_password 	= '';
$db_name 	= 'bd_trasciende';
$db_host 	= 'localhost';
$con  = mysqli_connect('localhost','root','','bd_trasciende');

if(mysqli_connect_errno())
{
    echo 'Database Connection Error';
}

function conectar(){
    $host="localhost";
    $user="root";
    $pass="";

    $bd="bd_trasciende";
    $conexion=mysqli_connect($host,$user,$pass);
    mysqli_select_db($conexion,$bd);
    return $conexion;
}
?>