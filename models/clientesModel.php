<?php 
include('../controllers/conection.php');

$output= array();
$sql = "SELECT * FROM clientes ";
$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'id_cliente',
	1 => 'nombre',
	2 => 'apellidos',
	3 => 'telefono',
	4 => 'tipo_membresia',
	5 => 'fecha_limite',
	6 => 'estado',
);

$searchSql = "";
if(isset($_POST['search']['value']) && $_POST['search']['value'] != ''){
  	$search_value = mysqli_real_escape_string($con, $_POST['search']['value']);
  	$searchSql .= " WHERE nombre LIKE '%".$search_value."%' OR apellidos LIKE '%".$search_value."%'";
}

$orderSql = " ORDER BY id_cliente DESC ";
if(isset($_POST['order'])){
 	$column_name = $_POST['order'][0]['column'];
 	$order = $_POST['order'][0]['dir'];
 	$orderSql = " ORDER BY ".$columns[$column_name]." ".$order."";
}

// Contar registros filtrados (SIN LIMIT)
$filterQuery = mysqli_query($con, $sql.$searchSql);
$total_filtered_rows = mysqli_num_rows($filterQuery);

// Paginación
$limitSql = "";
if($_POST['length'] != -1){
 	$start = $_POST['start'];
 	$length = $_POST['length'];
 	$limitSql = " LIMIT ".$start.", ".$length;
}

$query = mysqli_query($con, $sql.$searchSql.$orderSql.$limitSql);
$data = array();

while($row = mysqli_fetch_assoc($query)){
	$sub_array = array();
    $sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['id_cliente'].'</span>';
	$sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['nombre'].'</span>';
    $sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['apellidos'].'</span>';
	$sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['telefono'].'</span>';
	$sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['tipo_membresia'].'</span>';
    $sub_array[] = '<span class="text-secondary text-xs font-weight-bold">'.$row['fecha_limite'].'</span>';

	if($row['estado']==1){
		$sub_array[] = '<span class="badge bg-gradient-success">Activo</span>';
		$sub_array[] = '<a href="javascript:void(0);" data-id="'.$row['id_cliente'].'" class="text-secondary font-weight-bold text-xs btnEditarCliente">Editar</a>';
		$sub_array[] = '<a href="javascript:void(0);" data-id="'.$row['id_cliente'].'" class="text-secondary font-weight-bold text-xs btnDesactivarCliente">Baja</a>';
	}
	else {
		$sub_array[] = '<span class="badge bg-gradient-secondary">Inactivo</span>';
		$sub_array[] = '<a href="javascript:void(0);" data-id="'.$row['id_cliente'].'" class="text-secondary font-weight-bold text-xs btnEditarCliente" disabled>Editar</a>';
		$sub_array[] = '<a href="javascript:void(0);" data-id="'.$row['id_cliente'].'" class="text-secondary font-weight-bold text-xs btnActivarCliente">Activar</a>';
	}	

	$data[] = $sub_array;
}

$output = array(
	'draw'            => intval($_POST['draw']),
	'recordsTotal'    => $total_all_rows,
	'recordsFiltered' => $total_filtered_rows,
	'data'            => $data,
);

echo json_encode($output);
