<?php
// ======================================================
// 🏛️ Reporte Institucional de Cortes de Caja - Trasciende GYM
// ======================================================
require('../../controllers/conexion_prueba.php');
require('../../vendor/autoload.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// 📥 Capturar filtros
$inicio  = $_GET['inicio'] ?? '';
$fin     = $_GET['fin'] ?? '';
$usuarioFiltro = $_GET['usuario'] ?? '';

// 👤 Usuario que genera el reporte (en el futuro, desde sesión)
$usuarioGenera = "Administrador del Sistema";

// 🧭 Consulta SQL dinámica
$sql = "
  SELECT c.id_corte, c.fecha, c.total_ingresos, c.total_egresos, c.saldo_final,
         u.nombre AS usuario
  FROM caja_cortes c
  LEFT JOIN usuarios u ON c.id_usuario = u.id_usuario
  WHERE 1
";
$params = [];
$types  = '';

if ($inicio && $fin) {
  $sql .= " AND DATE(c.fecha) BETWEEN ? AND ?";
  $params[] = $inicio;
  $params[] = $fin;
  $types .= "ss";
}

if ($usuarioFiltro !== '') {
  $sql .= " AND c.id_usuario = ?";
  $params[] = $usuarioFiltro;
  $types .= "i";
}

$sql .= " ORDER BY c.fecha DESC";
$stmt = $con->prepare($sql);
if (!empty($params)) $stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();

// 📅 Datos del reporte
$fechaGeneracion = date('d/m/Y H:i:s');
$rango = ($inicio && $fin)
  ? "Del <b>" . date('d/m/Y', strtotime($inicio)) . "</b> al <b>" . date('d/m/Y', strtotime($fin)) . "</b>"
  : "Todos los registros";

// 🖼️ LOGO (100% compatible con Dompdf usando Base64)
$logoPathLocal = realpath(__DIR__ . '../../assets/img/logos/logo_negro_verde.png');
$logoBase64 = '';

if ($logoPathLocal && file_exists($logoPathLocal)) {
    $type = pathinfo($logoPathLocal, PATHINFO_EXTENSION);
    $data = file_get_contents($logoPathLocal);
    $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
} else {
    $logoBase64 = ''; // Evita error si no existe el archivo
}




// ======================================================
// 🎨 Estilos y diseño visual
// ======================================================
$html = "
<style>
  /* Margen superior aumentado para que no se encime */
  @page { margin: 130px 40px 70px 40px; }

  body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }

  /* ===== Encabezado ===== */
  .header {
    position: fixed;
    top: -100px;
    left: 0;
    right: 0;
    height: 100px;
  }

  .header-table {
    width: 100%;
    border-collapse: collapse;
  }

  .header-table td {
    vertical-align: middle;
  }

  .header-left {
    width: 90px;
    text-align: center;
  }

  .header-left img {
    width: 75px;
    height: auto;
    display: block;
  }

  .header-right {
    text-align: left;
    padding-left: 15px;
  }

  .header-right h2 {
    margin: 0;
    font-size: 18px;
    color: #1a1a1a;
  }

  .header-right h4 {
    margin: 2px 0;
    font-size: 14px;
    color: #555;
  }

  .header-right p {
    font-size: 12px;
    margin: 2px 0;
  }

  /* ===== Tabla ===== */
  table { width: 100%; border-collapse: collapse; margin-top: 15px; }
  th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: center; }
  th { background-color: #f2f2f2; }
  tr:nth-child(even) { background-color: #fafafa; }
  .text-success { color: #198754; }
  .text-danger { color: #dc3545; }
  .text-primary { color: #0d6efd; }

  /* ===== Pie de página ===== */
  .footer {
    position: fixed;
    bottom: -50px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 11px;
    color: #555;
  }

  hr { border: 0; border-top: 1px solid #aaa; margin: 5px 0; }
</style>

<div class='header'>
  <table class='header-table'>
    <tr>
      <td class='header-left'>
        <img src='$logoBase64' alt='Logo Institucional'>

        
      </td>
      <td class='header-right'>
        <h2>Reporte </h2>
        <p><b>Sistema Trasciende GYM</b></p>
        <p>$rango</p>
      </td>
    </tr>
  </table>
  <hr>
</div>

<div class='footer'>
  <hr>
  <p>Generado por: <b>$usuarioGenera</b> — Fecha: $fechaGeneracion</p>
</div>

<main>
  <table>
    <thead>
      <tr>
        <th>ID Corte</th>
        <th>Fecha</th>
        <th>Total Ingresos</th>
        <th>Total Egresos</th>
        <th>Saldo Final</th>
        <th>Usuario</th>
      </tr>
    </thead>
    <tbody>
";

$totalIngresos = 0;
$totalEgresos  = 0;
$totalSaldo    = 0;

while ($r = $res->fetch_assoc()) {
  $ing = (float)$r['total_ingresos'];
  $egr = (float)$r['total_egresos'];
  $sal = (float)$r['saldo_final'];

  $html .= "
    <tr>
      <td>{$r['id_corte']}</td>
      <td>" . date('d/m/Y', strtotime($r['fecha'])) . "</td>
      <td class='text-success'>$" . number_format($ing, 2) . "</td>
      <td class='text-danger'>$" . number_format($egr, 2) . "</td>
      <td class='text-primary fw-bold'>$" . number_format($sal, 2) . "</td>
      <td>{$r['usuario']}</td>
    </tr>
  ";

  $totalIngresos += $ing;
  $totalEgresos  += $egr;
  $totalSaldo    += $sal;
}

if ($res->num_rows === 0) {
  $html .= "<tr><td colspan='6'><i>No se encontraron registros en el rango seleccionado.</i></td></tr>";
}

$html .= "
    </tbody>
    <tfoot>
      <tr style='background:#e9ecef;font-weight:bold;'>
        <td colspan='2'>Totales</td>
        <td class='text-success'>$" . number_format($totalIngresos, 2) . "</td>
        <td class='text-danger'>$" . number_format($totalEgresos, 2) . "</td>
        <td class='text-primary'>$" . number_format($totalSaldo, 2) . "</td>
        <td></td>
      </tr>
    </tfoot>
  </table>
</main>
";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_cortes_institucional.pdf", ["Attachment" => false]);
