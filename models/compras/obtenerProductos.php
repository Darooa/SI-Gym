<?php include('../../controllers/conexion_prueba.php');

$output= array();
$sql = "SELECT * FROM productos ";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id_producto',
	1 => 'nombre_producto',
	2 => 'marca',
	3 => 'descripcion',
	4 => 'contenido',
	5 => 'p_compra',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE nombre_producto like '%".$search_value."%'";
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
	$sql .= " ORDER BY id_producto asc";
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
	$sub_array[] = '<p class="text-sm font-weight-bold mb-0">'.$row['id_producto'].'</p>';
	$sub_array[] = '<p class="text-sm font-weight-bold mb-0">'.$row['nombre_producto'].'</p>';

	$sub_array[] = '<span class="text-xs font-weight-bold">'.$row['marca'].'</span>';
    // $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['descripcion'].'</span>';
    $sub_array[] = '<span class="text-xs font-weight-bold">'.$row['contenido'].'</span>';
	$sub_array[] = '<span class="text-xs font-weight-bold">'.$row['p_compra'].'</span>';
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['id_producto'].'" class="AddProducto"><i class="ni ni-fat-add text-warning text-sm opacity-10"></i></a>';
	
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
