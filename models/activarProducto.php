<?php 
include('../Controllers/conexion_prueba.php');

$producto = $_POST['id'];
//$sql = "DELETE FROM personal WHERE id_per='$user_id'";
$sql = "UPDATE `productos` SET `estado` = '1' WHERE `id_producto` = '$producto'";
$delQuery =mysqli_query($con,$sql);
if($delQuery==true)
{
	 $data = array(
        'status'=>'success', 
    );
    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'failed',
    );
    echo json_encode($data);
} 

?>