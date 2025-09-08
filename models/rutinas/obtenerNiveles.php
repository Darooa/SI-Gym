<?php 
include('../../controllers/conexion_prueba.php');

$query = "SELECT nivel FROM tb_rutinas GROUP BY nivel";

$result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida'.mysqli_error($con));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array (
            'nivel' => $row['nivel']
        );
    }
    
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
