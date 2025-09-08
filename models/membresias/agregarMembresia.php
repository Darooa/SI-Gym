<?php 
include('../../controllers/conexion_prueba.php');

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $duracion = $_POST['duracion'];
    $precio = $_POST['precio'];
    $query = "INSERT INTO tb_membresias (`membresia`,`duracion`,`precio`,`estado`) VALUES ('$nombre','$duracion','$precio','1')";
    $result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida');
    }

    echo 'La membresia ha sido agregada';
}

?>
