<?php 
include('../../controllers/conexion_prueba.php');

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $rutina = $_POST['rutina'];
    $nivel = $_POST['nivel'];
    
    $query = "INSERT INTO tb_rutinas (`nombre`,`rutina`,`nivel`) VALUES ('$nombre','$rutina','$nivel')";
    $result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida');
    }

    echo 'La rutina ha sido agregada';
}

?>