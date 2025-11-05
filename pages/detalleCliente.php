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
<!-- Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="header-banner position-absolute w-100">
  </div>
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
        <!-- *********** CARD DE LA INFORMACIÓN Y ACTUALIZACIÓN DEL CLIENTE *******************-->
        <div class="col-md-10 mx-auto">
          <div class="card border-0 shadow-lg rounded-4 p-4">
            <div class="row align-items-center">
              <!-- columna de información del cliente -->
              <div class="col-md-5 text-center">
                <div class="position-relative">
                  <img src="assets/img/banner_4.jpg" class="card-img-top bg-dark rounded-4" style="height: 80px; object-fit: cover; width: 100%;">

                  <!-- Imagen circular -->
                  <div class="profile-image mt-n5">
                    <img src="assets/img/pesas.jpg"
                      class="rounded-circle border border-3 border-white shadow-sm"
                      style="width: 150px; height: 150px; object-fit: cover;">
                  </div>
                </div>
                <!-- Datos del cliente -->
                <div class="cliente-info mt-4 text-start ps-md-4">
                  <h5 class="fw-bold mb-1"><?php echo $cliente ?></h5>
                  <p class="text-muted small mb-2"><strong>Folio:</strong> <?php echo $folio ?></p>
                  <p class="text-muted small mb-2"><strong>Membresía:</strong> <?php echo $nombreMembresia ?></p>
                  <!-- <p class="text-muted small mb-2"><strong>Tipo de rutina:</strong> Nivel 1</p> -->
                  <p class="text-muted small mb-2"><strong>Inicio:</strong> <?php echo $fechaIni ?></p>
                  <p class="text-muted small mb-3"><strong>Vencimiento:</strong> <?php echo $fecha_lim ?></p>

                  <!-- QR -->
                  <div class="qr-section mt-3 text-center">
                    <span class="d-block mb-2 fw-semibold">Código QR:</span>
                    <img src="<?php echo $filename ?>" alt="QR Cliente"
                      class="img-thumbnail zoomable-img shadow-sm"
                      style="cursor: pointer; max-width: 120px;"
                      data-bs-toggle="modal" data-bs-target="#zoomModal">
                  </div>
                  <div class="mt-3 text-center">
                    <a href='perfil.php?folio=<?php echo $folio ?>' class="text-decoration-none text-success fw-semibold">
                      <i class="fas fa-user me-1"></i> Ver perfil del cliente
                    </a>
                  </div>
                </div>
              </div>

              <!-- inputs de actualización -->
              <div class="col-md-7 border-start ps-4 mt-4 mt-md-0">
                <div class="text-end">
                  <a href="vistaClientes.php" class="btn btn-text-primary">
                    <i class="bx bx-left-arrow-alt me-2"></i> Regresar
                  </a>
                </div>
                <h6 class="text-uppercase text-success mb-3">Actualizar información</h6>
                <form id="actualizarClientes">
                  <div class="mb-3">
                    <input type="hidden" id="clienteId" name="clienteId" value="<?php echo $id ?>">
                    <label for="example-text-input" class="form-control-label">Nombre(s)</label>
                    <input class="form-control" type="text" id="nombreCliente" name="nombreCliente" value="<?php echo $nombre ?>">
                  </div>
                  <div class="mb-3">
                    <label for="example-text-input" class="form-control-label">Apellidos</label>
                    <input class="form-control" type="text" id="apellidosCliente" name="apellidosCliente" value="<?php echo $apellidos ?>">
                  </div>

                  <div class="mb-3">
                    <label for="example-text-input" class="form-control-label">Teléfono</label>
                    <input class="form-control" type="text" id="telefonoCliente" name="telefonoCliente" value="<?php echo $telefono ?>">
                  </div>
                  <div class="mb-3">
                    <label for="example-text-input" class="form-control-label">Fecha de Nacimiento</label>
                    <input class="form-control" type="date" id="fechaCliente" name="fechaCliente" value="<?php echo date('Y-m-d', strtotime($fecha_n)); ?>">
                  </div>
                  <button type="submit" class="btn btn-success w-100">Actualizar</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
      <!-- ***********MODAL PARA VISUALIZACIÓN DEL QR EN ZOOM ******** -->
      <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl"> <!--tamaño grande -->
          <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body text-center p-0">
              <img id="zoomedImage" src="" alt="Zoom QR" class="img-fluid rounded" style="max-width: 95vw; max-height: 95vh; object-fit: contain;"> <!-- 🔸 limita altura al 85% de pantalla -->
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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