<?php

include('../../controllers/conexion_prueba.php');

$folio = $_POST['folio'];
$query = "SELECT *  FROM clientes WHERE folio = $folio";
$result = mysqli_query($con,$query);
if($result->num_rows >0){
    $json = array();
while($row = mysqli_fetch_array($result)){
    $json[] = array(
        'id_cliente' => $row['id_cliente'], 
        'folio' => $row['folio'], 
        'nombre' => $row['nombre'], 
        'apellidos' => $row['apellidos'], 
        'telefono' => $row['telefono'], 
        'fecha_nac' => $row['fecha_nac'], 
        'tipo_membresia' => $row['tipo_membresia'], 
        'fecha_inicio' => $row['fecha_inicio'], 
        'fecha_limite' => $row['fecha_limite'], 
        'estado' => $row['estado'], 
    );
};
}else{
    $json[] = array();
}


$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>