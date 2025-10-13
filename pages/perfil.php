<?php
include("../controllers/conection.php");

$folio = $_GET['folio'] ?? '';

$qry_planes = "SELECT * FROM detallesclientes WHERE folio=$folio";
    $resultado = mysqli_query($con, $qry_planes);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Argon Dashboard 2 by Creative Tim
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-success position-absolute w-100"></div>
    <!-- <span class="mask bg-primary opacity-6"></span> -->
    </div>
    <div class="main-content position-relative max-height-vh-100 h-100">
  <style>
    /* Estilos estéticos */
    .modal-content {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }
    .modal-header {
      background-color: #f8f9fa;
      border-bottom: none;
    }
    .modal-body {
      padding: 0;
    }
    video {
      width: 100%;
      height: auto;
      border-radius: 10px;
      display: block;
    }
  </style>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;"> <!-- Modal más pequeño -->
    <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="videoModalLabel">🎬 Bienvenido(a)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center" style="padding: 15px;">
        <video id="videoBienvenida" controls style="width: 100%; max-width: 500px; border-radius: 10px;">
          <source src="../pages/assets/videos/videogym.MOV" type="video/mp4">
          Tu navegador no soporta este formato de video.
        </video>
      </div>
    </div>
  </div>
</div>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-profile">
                        <img src="assets/img/logos/log_blanco_verde.png" alt="Image placeholder" class="card-img-top bg-dark">
                        <div class="row justify-content-center">
                            <div class="col-4 col-lg-4 order-lg-2">
                                <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                    <a href="javascript:;">
                                        <img src="assets/img/image.png" class="rounded-circle img-fluid border border-2 border-white">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            <div class="d-flex justify-content-between">
                                <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                                <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i class="ni ni-email-83"></i></a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <!-- <div class="d-flex justify-content-center">
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">22</span>
                      <span class="text-sm opacity-8">Friends</span>
                    </div>
                    <div class="d-grid text-center mx-4">
                      <span class="text-lg font-weight-bolder">10</span>
                      <span class="text-sm opacity-8">Photos</span>
                    </div>
                    <div class="d-grid text-center">
                      <span class="text-lg font-weight-bolder">89</span>
                      <span class="text-sm opacity-8">Comments</span>
                    </div>
                  </div> -->
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <h5>
                                    <?php echo$cliente?> <span class="font-weight-light"></span>
                                </h5>
                                <div class="h6 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>Folio: <?php echo$folio?>
                                </div>
                                <div class="h6 mt-4">
                                    Tipo de membresía: <?php echo$nombreMembresia?>
                                </div>
                                <div>
                                    Fecha de Inicio: <?php echo$fechaIni?>
                                </div>
                                <div>
                                    Fecha de Vencimiento: <?php echo$fecha_lim?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0"></p>
                                <!-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">RUTINA</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nivel de rutina:</label>
                                        <input class="form-control bg-light" type="text" value="">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Descripción de la Rutina</p>

                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2 col-12">
                                    <div class="form-group mb-2">
                                        <label for="nombre1" class="form-control-label">Nombre:</label>
                                        <input id="nombre1" class="form-control bg-light" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control bg-light" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group mb-2">
                                        <label for="nombre2" class="form-control-label">Nombre:</label>
                                        <input id="nombre2" class="form-control bg-light" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control bg-light" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group mb-2">
                                        <label for="nombre3" class="form-control-label">Nombre:</label>
                                        <input id="nombre3" class="form-control bg-light" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control bg-light" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group mb-2">
                                        <label for="nombre4" class="form-control-label">Nombre:</label>
                                        <input id="nombre4" class="form-control bg-light" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control bg-light" rows="10"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-2 col-12">
                                    <div class="form-group mb-2">
                                        <label for="nombre5" class="form-control-label">Nombre:</label>
                                        <input id="nombre5" class="form-control bg-light" type="text" value="">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control bg-light" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                        </div>
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
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
    // Verificamos si el video ya se mostró antes
    const yaMostrado = localStorage.getItem("videoBienvenidaVisto");

    if (!yaMostrado) {
      const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
      videoModal.show();

      // Guardamos que ya se mostró una vez
      localStorage.setItem("videoBienvenidaVisto", "true");
    }
  });
  </script>
</body>

</html>