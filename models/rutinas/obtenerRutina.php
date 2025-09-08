<?php 
include('../../controllers/conexion_prueba.php');

$nivel_rutina = $_POST['nivel'];
$query = "SELECT * FROM tb_rutinas WHERE nivel = '$nivel_rutina'";

$result = mysqli_query($con,$query);

    if (!$result) {
        die('Consulta fallida'.mysqli_error($con));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array (
            'id_rutina' => $row['id_rutina'], 
            'nombre' => $row['nombre'], 
            'rutina' => $row['rutina'], 
            'nivel' => $row['nivel']
        );
    }
    
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
