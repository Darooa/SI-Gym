<?php
include('../../controllers/conexion_prueba.php');
// Obtener y verificar los datos del formulario
$nombre        = isset($_POST['nombreCliente']) ? $_POST['nombreCliente'] : '';
$apellidos     = isset($_POST['apellidosCliente']) ? $_POST['apellidosCliente'] : '';
$telefono      = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$fecha_n       = isset($_POST['fecha_nac']) ? $_POST['fecha_nac'] : '';
$tipoMembresia = isset($_POST['tipoMembresia']) ? $_POST['tipoMembresia'] : '';
$fechaInicio   = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : '';
$fechaFin      = isset($_POST['fechaTermino']) ? $_POST['fechaTermino'] : '';

function generarCodigoUnico($con) {
    do {
        $codigo = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        // Consulta para verificar si ya existe
        $sql = "SELECT COUNT(*) as total FROM clientes WHERE folio = '$codigo'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
    } while ($row['total'] > 0); // repetir si ya existe
    return $codigo;
}

$codigo = generarCodigoUnico($con);

$sql = "INSERT INTO clientes (`folio`,`nombre`,`apellidos` ,`telefono`,`fecha_nac`,`tipo_membresia`,`fecha_inicio`,`fecha_limite`,`estado`) VALUES('$codigo','$nombre','$apellidos','$telefono','$fecha_n','$tipoMembresia','$fechaInicio','$fechaFin',1)";
    $query = mysqli_query($con, $sql);
    if ($query == true) {
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        $error = mysqli_error($con);
        $data = array(
            'status' => 'false','error' => $error,
        );
        echo json_encode($data);
    }
?>