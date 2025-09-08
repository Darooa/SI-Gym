<?php 
include('../../controllers/conexion_prueba.php');

$id = $_POST['id'];
$query = "SELECT *  FROM tb_membresias WHERE id_membresia = $id";
$result = mysqli_query($con,$query);
if (!$result) {
    die('Consulta fallida');
}

$json = array();
while($row = mysqli_fetch_array($result)){
    $json[] = array(
        'id_membresia' => $row['id_membresia'], 
        'membresia' => $row['membresia'], 
        'duracion' => $row['duracion'], 
        'precio' => $row['precio'], 
        'estado' => $row['estado']
    );
};

$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>
