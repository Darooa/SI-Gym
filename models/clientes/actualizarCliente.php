<?php 
include('../../controllers/conexion_prueba.php');

   $edit_nombreCliente     =$_POST["edit_nombreCliente"]; 
   $edit_apellidosCliente  =$_POST["edit_apellidosCliente"];
   $edit_telefono          =$_POST["edit_telefono"];
   $edit_fecha_nac         =$_POST["edit_fecha_nac"];
   $edit_tipoMembresia     =$_POST["edit_tipoMembresia"];
   $edit_fechaInicio       =$_POST["edit_fechaInicio"];
   $edit_fechaTermino      =$_POST["edit_fechaTermino"];
   $id                     =$_POST["id"];


$sql = "UPDATE `clientes` SET  `nombre`='$edit_nombreCliente' , `apellidos`= '$edit_apellidosCliente', `telefono`= '$edit_telefono', `fecha_nac`= '$edit_fechaInicio', `tipo_membresia`= '$edit_tipoMembresia', `fecha_inicio`= '$edit_fechaInicio', `fecha_limite`= '$edit_fechaTermino'  WHERE id_cliente='$id' ";
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