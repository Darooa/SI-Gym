<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
  $id = $_POST['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logos/icono_negro.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <title>
    TRASCIENDE GYM
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link href="../pages/assets/css/estilosDetalleCliente.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="header-banner position-absolute w-100">
    <button class="btn btn-primary btn-sm ms-auto m-3">Regresar</button>
  </div>

  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
        <img src="assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Argon Dashboard 2</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link " href="../pages/dashboard.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/tables.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tables</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <div class="main-content position-relative max-height-vh-100 h-100">
    <div class="card shadow-lg mx-4 card-profile-bottom">
    </div>
    <?php
    include("../libs/phpqrcode/qrlib.php");
    $conect = mysqli_connect("localhost", "root", "", "bd_trasciende");
    if (!$conect) {
      die("Error de conexión: " . mysqli_connect_error());
    }
    $conect->set_charset("utf8");
    $qry_planes = "SELECT * FROM detallesclientes WHERE id=$id";
    $resultado = mysqli_query($conect, $qry_planes);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
      $row = mysqli_fetch_assoc($resultado);
      $id               = $row['id'];
      $folio            = $row['folio'];
      $cliente          = $row['nombre'] . " " . $row['apellidos'];
      $nombre           = $row['nombre'];
      $apellidos        = $row['apellidos'];
      $telefono         = $row['telefono'];
      $fecha_n          = $row['fecha_n'];
      $id_membresia     = $row['id_membresia'];
      $nombreMembresia  = $row['nombre_membresia'];
      $duracion         = $row['duracion'];
      $precio           = $row['precio'];
      $fechaIni         = $row['fechaIni'];
      $fecha_lim        = $row['fecha_lim'];
      $estado           = $row['estado'];
    } else {
      echo "No disponible";
    }

    // Carpeta para guardar los QR
    $dir = "temp_qr/";
    if (!file_exists($dir)) {
      mkdir($dir);
    }
    // Generar URL del perfil
    $url = "http://localhost/SI-Gym/SI-Gym/pages/perfil.php?folio=" . $folio;
    // Generar QR y guardarlo en carpeta
    $filename = $dir . 'cliente_' . $folio . '.png';
    QRcode::png($url, $filename, QR_ECLEVEL_L, 4);
    ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
              </div>
            </div>
            <!-- **********CARD PARA ACTUALIZACIÓN DE LA INFORMACIÓN DEL CLIENTE ************-->
            <div class="card-body">
              <p class="text-uppercase text-sm">Información del Cliente</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" id="clienteId" name="clienteId" value="<?php echo $id ?>">
                    <label for="example-text-input" class="form-control-label">Nombre(s)</label>

                    <input class="form-control" type="text" value="<?php echo $nombre ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Apellidos</label>
                    <input class="form-control" type="text" value="<?php echo $apellidos ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Teléfono</label>
                    <input class="form-control" type="text" value="<?php echo $telefono ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Fecha de Nacimiento</label>
                    <input class="form-control" type="Date" value="<?php echo $fecha_n ?>">
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Información de Membresía</p>
              <div class="row">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Tipo de Membresía</label>
                      <select class="select2 select-event-label form-select" name="edit_tipoMembresia" id="edit_tipoMembresia">
                        <option  value="">Seleccionar...</option>
                        <?php
                        $conect = mysqli_connect("localhost", "root", "", "bd_trasciende");
                        $conect->set_charset("utf8");
                        $qry_planes = "SELECT * from tb_membresias where estado=1";
                                                            if ($resultado = mysqli_query($conect, $qry_planes)) {
                                                              /* obtener array asociativo */
                                                              while ($row = mysqli_fetch_assoc($resultado)) {
                                                                $selected = ($row["id_membresia"] == $id_membresia) ? "selected" : "";
                                                                echo '<option value="' . $row["id_membresia"] . '" ' . $selected .
                                                                  ' data-precio="' . $row["precio"] . '" data-dias="' . $row["duracion"] . '">' .
                                                                  $row["membresia"] . ': ' . $row["duracion"] . ' días</option>';
                                                              }
                                                              /* liberar el conjunto de resultados */
                                                              mysqli_free_result($resultado);
                                                            }
                        echo "<br>";
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Costo</label>
                      <input class="form-control" type="Text" id="edit_costo" name="edit_costo" value="<?php echo $precio ?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Fecha de Inicio</label>
                      <input class="form-control" type="Date" id="edit_fechaInicio" name="edit_fechaInicio" value="<?php echo $fechaIni ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Fecha de término</label>
                      <input class="form-control" type="Date" id="edit_fechaTermino" name="edit_fechaTermino" value="<?php echo $fecha_lim ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <button class="btn btn-primary btn-sm ms-auto ">Actualizar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- *********** CARD DERECHO DE LA INFORMACIÓN DEL CLIENTE *******************-->
        <div class="col-md-4">
          <div class="card card-profile">
            <img src="" class="card-img-top bg-dark">
            <div class="row justify-content-center">
              <div class="col-4 col-lg-4 order-lg-2">
                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                  <a href="javascript:;">
                    <img src="assets/img/pesas.jpg" class="rounded-circle img-fluid border border-2 border-white">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="cliente-info mt-3">
                <h5><?php echo $cliente ?></h5>
                <div><span> <strong>Folio:</strong> </span><?php echo $folio ?></div>
                <div><span><strong>Tipo de membresía:</strong> </span><?php echo $nombreMembresia ?></div>
                <div><span><strong>Tipo de rutina:</strong> </span>Nivel 1</div>
                <div><span><strong>Inicio de membresía:</strong> </span><?php echo $fechaIni ?></div>
                <div><span><strong>Vencimiento: </strong></span><?php echo $fecha_lim ?></div>
              </div>
              <br>
              <!-- *** IMAGEN QR ********* -->
              <div class="qr-section">
                <span>Código QR:</span>
                <img src="<?php echo $filename ?>" alt="QR Cliente" class="img-thumbnail zoomable-img" style="cursor: pointer; max-width: 150px;" data-bs-toggle="modal" data-bs-target="#zoomModal">
              </div>
              <br>
              <a href='perfil.php?folio=<?php echo $folio ?>'>Ver perfil del cliente</a>
            </div>
          </div>
        </div>
      </div>
<!-- ***********MODAL PARA VISUALIZACIÓN DEL QR EN ZOOM ******** -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl"> <!-- 🔸 tamaño grande -->
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body text-center p-0">
        <img id="zoomedImage" src="../pages/temp_qr/cliente_<?php echo $folio ?>" 
             class="img-fluid rounded" 
             style="max-width: 95vw; max-height: 95vh; object-fit: contain;"> <!-- 🔸 limita altura al 85% de pantalla -->
      </div>
    </div>
  </div>
</div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
          </div>
        </div>
      </footer>
    </div>
  </div>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Argon Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

    /**********FUNCIÓN PARA AMPLIAR IMAGEN QR *********** */
   document.querySelector('.zoomable-img').addEventListener('click', function() {
      document.getElementById('zoomedImage').src = this.src;
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  <!--JS -->
  <script src="../controllers/detalleCliente.js"></script>
</body>

</html>