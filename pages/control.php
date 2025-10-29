<?php
session_start();
if(!isset($_SESSION['user']) && $_SESSION['user'] != "eli"){
    header("Location: http://localhost/trasciende/SI-Gym/pages/inicio-sesion.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/logos/logo_solido_verde_negro.png">
  <title>
    Trasciende
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

  <!-- Jquery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.css">
  <link rel="stylesheet" type="style.css" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.css">

  <link rel="stylesheet" type="style.css" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Alertas -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="" style="background-image: url(../pages/assets/img/controlELi.jpeg);">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-6 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start" style="background-color: rgba(0, 0, 0, 0);">
                  <h1 class="font-weight-bolder" style="color: white;">BIENVENIDO (a)</h1>
                </div>
                <div class="card-body">
                  <form id="control">
                    <div class="mb-3">
                      <h6 style="color: white;">Ingresa tu código</h6>
                      <input type="text" class="form-control form-control-lg" aria-label="Código" id="folio"
                        style="height: 80px; font-size: 40px; letter-spacing: 20px; background-color: rgba(255,255,255,0.1); color: white;">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>


  <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" style=" background-color: rgba(255,255,255,0);">
            <i class="ni ni-settings-gear-65" style="color: white;"></i>
        </a>
        <div class="card shadow-lg" style="background-color: rgba(23, 146, 82, 0.544);">
            <div class="card-header pb-0 pt-3 " style="background-color: rgba(255,255,255,0);">
                <div class="float-start">
                    <h5 style="color: white;" class="mt-3 mb-0">Trasciende GYM</h5>
                    <p style="color: white;">Opciones del panel de control.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto" >
              <a href="./vistaClientes.php">
                <div class="d-flex">
                      <button class="btn bg-gradient-secondary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        >Inicio</button>
                      </div>
                    </a>
                <div class="d-flex">
                    <button class="btn bg-gradient-secondary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        >Usuarios</button>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-secondary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        >Ventas</button>
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
  <script src="../js/funcionesControl.js"></script>
</body>

</html>