<?php 
include('../../controllers/conexion_prueba.php');

$output= array();
$sql = "SELECT * FROM compras ";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id_compra',
	1 => 'codigo',
	2 => 'fecha',
	3 => 'monto',
	4 => 'usuario',
	5 => 'proveedor',
	6 => 'producto',
    7 => 'cantidad',

);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE codigo like '%".$search_value."%'";
	$sql .= " OR marca like '%".$search_value."%'";
	
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id_compra asc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = '<p class="text-sm font-weight-bold mb-0">'.$row['id_compra'].'</p>';
	$sub_array[] = '<p class="text-sm font-weight-bold mb-0">'.$row['codigo'].'</p>';

	$sub_array[] = '<span class="text-xs font-weight-bold">'.$row['fecha'].'</span>';
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['monto'].'</span>';
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['usuario'].'</span>';
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['proveedor'].'</span>';

	
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['producto'].'</span>';
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['cantidad'].'</span>';

	if($row['estado']==1 ){
		$sub_array[] = '<span class="badge bg-success">Activo</span>';
		$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id_producto'].'" class="btn btn-sm app-btn-secondary EDTProducto" >Editar</a>';
		$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id_producto'].'" class="btn btn-sm app-btn-secondary desactivarClienteBtn" >Desactivar</a>';

	}
	if($row['estado']==2){
		$sub_array[] = '<span class="badge bg-danger">Inactivo</span>';
		$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id_producto'].'" class="btn btn-sm app-btn-secondary EDTProducto" >Editar</a>';
		$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id_producto'].'" class="btn btn-sm app-btn-secondary activarClienteBtn" >Activar</a>';

	}
	
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
