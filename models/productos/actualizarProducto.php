<?php 
include('../../controllers/conexion_prueba.php');
$EDT_nombre = $_POST['EDT_nombre'];
$EDT_descripcion = $_POST['EDT_descripcion'];
$EDT_categoria = $_POST['EDT_categoria'];
$EDT_marca = $_POST['EDT_marca'];
$EDT_contenido = $_POST['EDT_contenido'];
$EDT_stock = $_POST['EDT_stock'];
$EDT_pcompra = $_POST['EDT_pcompra'];
$EDT_pventa = $_POST['EDT_pventa'];
// $EDT_agregado = $_POST['EDT_agregado'];
// $EDT_estado = $_POST['EDT_estado'];

$id = $_POST['id'];

$sql = "UPDATE `productos` SET  `nombre_producto`='$EDT_nombre' , `descripcion`= '$EDT_descripcion', `categoria`= '$EDT_categoria', `marca`= '$EDT_marca', `contenido`= '$EDT_contenido', `stock`= '$EDT_stock', `p_compra`= '$EDT_pcompra', `p_venta`= '$EDT_pventa'  WHERE id_producto='$id' ";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
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
      
    );

    echo json_encode($data);
} 

?>