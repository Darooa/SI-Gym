<?php 
include('../../controllers/conexion_prueba.php');
date_default_timezone_set('America/Mexico_City');
$fechaActual =  date("Y-m-d");
$query = "SELECT tb_membresias.membresia, COUNT(tb_membresias.membresia) as cantidad, costo, fecha, hora, 
COUNT(tb_membresias.membresia) * costo as total
FROM reportes
INNER JOIN tb_membresias
ON tb_membresias.id_membresia = reportes.membresia where reportes.fecha='$fechaActual' GROUP by tb_membresias.membresia;";


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

