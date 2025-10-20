<?php 
include('../../controllers/conexion_prueba.php');
$id     = $_POST['id'];
$sql    = "SELECT * FROM clientes WHERE id_cliente='$id' LIMIT 1";
$query  = mysqli_query($con,$sql);
$row    = mysqli_fetch_assoc($query);
          echo json_encode($row);

?>