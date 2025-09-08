<?php 
include('../../controllers/conexion_prueba.php');

$query = "SELECT * FROM tb_membresias";

$result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida'.mysqli_error($con));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array (
            'id_membresia' => $row['id_membresia'], 
            'membresia' => $row['membresia'], 
            'duracion' => $row['duracion'], 
            'precio' => $row['precio'], 
            'estado' => $row['estado']
        );
    }
    
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
