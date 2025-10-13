<?php 
include('../../controllers/conexion_prueba.php');
date_default_timezone_set('America/Mexico_City');
$turno = $_POST['turno'];
$fechaActual =  date("Y-m-d");

if ($turno === 'Turno 1') {
    $query = "SELECT tb_membresias.membresia, COUNT(tb_membresias.membresia) as cantidad, costo, fecha, hora, 
    COUNT(tb_membresias.membresia) * costo as total
    FROM reportes
    INNER JOIN tb_membresias
    ON tb_membresias.id_membresia = reportes.membresia 
    where reportes.hora>='05:00:00' and reportes.hora<'14:00:00' and reportes.fecha='$fechaActual' 
    GROUP by tb_membresias.membresia;";
}elseif($turno === 'Turno 2') {
    $query = "SELECT tb_membresias.membresia, COUNT(tb_membresias.membresia) as cantidad, costo, fecha, hora, 
    COUNT(tb_membresias.membresia) * costo as total
    FROM reportes
    INNER JOIN tb_membresias
    ON tb_membresias.id_membresia = reportes.membresia 
    where reportes.hora>='14:00:00' and reportes.hora<='24:00:00' and reportes.fecha='$fechaActual' 
    GROUP by tb_membresias.membresia;";
}

$result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida'.mysqli_error($con));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array (
            'membresia' => $row['membresia'], 
            'cantidad' => $row['cantidad'], 
            'costo' => $row['costo'], 
            'fecha' => $row['fecha'], 
            'hora' => $row['hora'], 
            'total' => $row['total'], 
        );
    }
    
    $jsonstring = json_encode($json);
    echo $jsonstring;

?>

