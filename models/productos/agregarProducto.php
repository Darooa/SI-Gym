<?php 
include('../../controllers/conexion_prueba.php');

date_default_timezone_set('America/Mexico_City');

$producto_nombre       = $_POST['TGYM_nombre'];
$producto_marca        = $_POST['TGYM_marca'];
$producto_contenido    = $_POST['TGYM_contenido'];
$producto_categoria    = $_POST['TGYM_categoria'];
$producto_stockinicial = $_POST['TGYM_stockinicial'];
$producto_descripcion  = $_POST['TGYM_descripcion'];
$producto_preciocompra = $_POST['TGYM_preciocompra'];
$producto_precioventa  = $_POST['TGYM_precioventa'];
$producto_fecha        = date("Y-m-d");
$producto_estado       = '1';


$sql= "INSERT INTO productos (`nombre_producto`, `descripcion`, `categoria`, `marca`, `contenido`, `stock`, `p_compra`, `p_venta`, `agregado`, `estado`)
    VALUES('$producto_nombre','$producto_descripcion','$producto_categoria','$producto_marca','$producto_contenido','$producto_stockinicial','$producto_preciocompra','$producto_precioventa','$producto_fecha','$producto_estado') ";	
    $query= mysqli_query($con,$sql);
    $lastId = mysqli_insert_id($con);


if($query == true)
{
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
}
else
{
    $data = array(
        'status'=>'false',
        'error'=> mysqli_error($con) 
    );
    echo json_encode($data);
} 

?>