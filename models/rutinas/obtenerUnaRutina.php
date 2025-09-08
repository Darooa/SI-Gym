<?php 
include('../../controllers/conexion_prueba.php');

$id = $_POST['id'];
$query = "SELECT *  FROM tb_rutinas WHERE id_rutina = $id";
$result = mysqli_query($con,$query);
if (!$result) {
    die('Consulta fallida');
}

$json = array();
while($row = mysqli_fetch_array($result)){
    $json[] = array(
        'id_rutina' => $row['id_rutina'], 
        'nombre' => $row['nombre'], 
        'rutina' => $row['rutina'], 
    );
};

$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>
