<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/logos/icono_negro.png">
    <title>
        Trasciende GYM
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
    <!-- Jquery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.css">
</head>

<body class="g-sidenav-show   bg-gray-100">
    <div class="min-height-300 bg-success position-absolute w-100"></div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
                <img src="./assets/img/logos/icono_negro.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Trasciende GYM</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="./dashboard.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./tables.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Clientes</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./profile.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./sign-in.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Sign In</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="./sign-up.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Home</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Clientes</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Clientes</h6>
                </nav>

        </nav>
        <!-- End Navbar -->
        <!-- Contenedor -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Listado de clientes</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#registroModal">
                                <i class="icon-base bx bx-plus icon-16px me-2"></i>
                                Registrar Cliente
                            </button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="tablaClientes" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NOMBRE(S)</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">APELLIDOS</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TELÉFONO</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TIPO MEMBRESÍA</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FECHA lÍMITE MEMBRESÍA</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ESTADO</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--==============MODAL PARA EL REGISTRO DE CLIENTES============================== -->
        <div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="agregarCliente" novalidate>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Cliente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nombre(s)</label>
                                        <input class="form-control" type="text" id="nombreCliente" name="nombreCliente" maxlength="30" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,30}" title="Sólo se permiten letras y espacios (máximo 30 caracteres)" required>
                                        <div class="invalid-feedback">Por favor, ingresa el nombre del cliente.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Apellidos</label>
                                        <input class="form-control" type="text" id="apellidosCliente" name="apellidosCliente" maxlength="35" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{1,35}" title="Sólo se permiten letras y espacios (máximo 35 caracteres)"  required>
                                        <div class="invalid-feedback">Por favor, ingresa los apellidos del cliente.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Teléfono</label>
                                        <input class="form-control" type="text" required id="telefono" name="telefono" pattern="[0-9]{1,10}"
      title="Solo se permiten números (máximo 10 caracteres)">
                                        <div class="invalid-feedback">Por favor, ingresa el número de teléfono del cliente.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="Date" id="fecha_nac" name="fecha_nac" required>
                                        <div class="invalid-feedback">Por favor, ingresa la fecha de nacimiento del cliente.</div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Información de Membresía</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tipo de Membresía</label>
                                        <select class="select2 select-event-label form-select" name="tipoMembresia" id="tipoMembresia" required>
                                            <option value="">Seleccionar...</option>
                                            <?php
                                            $conect = mysqli_connect("localhost", "root", "", "bd_trasciende");
                                            $conect->set_charset("utf8");
                                            $qry_planes = "SELECT * from tb_membresias where estado=1";
                                            if ($resultado = mysqli_query($conect, $qry_planes)) {
                                                /* obtener array asociativo */
                                                while ($row = mysqli_fetch_assoc($resultado)) {
                                                    echo '<option value="' . $row["id_membresia"] . '" data-precio="' . $row["precio"] . '" data-dias="' . $row["duracion"] . '"> ' . $row["membresia"] . ': ' . $row["duracion"] . ' días' . '</option>';
                                                }
                                                /* liberar el conjunto de resultados */
                                                mysqli_free_result($resultado);
                                            }
                                            echo "<br>";
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">Por favor, ingresa la fecha de nacimiento del cliente.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Costo</label>
                                        <input class="form-control" type="Text" id="costo" name="costo" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de Inicio</label>
                                        <input class="form-control" type="Date" id="fechaInicio" name="fechaInicio" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de término</label>
                                        <input class="form-control" type="Date" id="fechaTermino" name="fechaTermino" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--==============MODAL PARA LA ACTUALIZACIÓN DE CLIENTES============================== -->
        <div class="modal fade" id="actualizarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="editarCliente">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nombre(s)</label>
                                        <input class="form-control" type="text" id="edit_nombreCliente" name="edit_nombreCliente" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Apellidos</label>
                                        <input class="form-control" type="text" id="edit_apellidosCliente" name="edit_apellidosCliente" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Teléfono</label>
                                        <input class="form-control" type="text" required id="edit_telefono" name="edit_telefono">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="Date" id="edit_fecha_nac" name="edit_fecha_nac" required>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Información de Membresía</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Tipo de Membresía</label>
                                        <select class="select2 select-event-label form-select" name="edit_tipoMembresia" id="edit_tipoMembresia" required>
                                            <option selected disabled>Seleccionar...</option>
                                            <?php
                                            $conect = mysqli_connect("localhost", "root", "", "bd_trasciende");
                                            $conect->set_charset("utf8");
                                            $qry_planes = "SELECT * from tb_membresias where estado=1";
                                            if ($resultado = mysqli_query($conect, $qry_planes)) {
                                                /* obtener array asociativo */
                                                while ($row = mysqli_fetch_assoc($resultado)) {
                                                    echo '<option value="' . $row["id_membresia"] . '" data-precio="' . $row["precio"] . '" data-dias="' . $row["duracion"] . '"> ' . $row["membresia"] . ': ' . $row["duracion"] . ' días' . '</option>';
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
                                        <input class="form-control" type="Text" id="edit_costo" name="edit_costo" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de Inicio</label>
                                        <input class="form-control" type="Date" id="edit_fechaInicio" name="edit_fechaInicio" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Fecha de término</label>
                                        <input class="form-control" type="Date" id="edit_fechaTermino" name="edit_fechaTermino" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-gradient-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
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
    <!-- Datatables -->
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!--JS -->
    <script src="../controllers/clientesControllers.js"></script>
    <script>
        /***********FECHA ACTUAL EN INPUT DATE PARA EL REGISTRO DE CLIENTE *********** */
        document.addEventListener("DOMContentLoaded", function() {
            let hoy = new Date();
            // Convierte a fecha local según la zona horaria del usuario
            let dia = ("0" + hoy.getDate()).slice(-2);
            let mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
            let año = hoy.getFullYear();
            let fechaLocal = `${año}-${mes}-${dia}`;
            document.getElementById("fechaInicio").value = fechaLocal;
        });


/*************VALIDACIÓN DE INPUTS DE REGISTRO DE CLIENTE ************** */
        (() => {
            "use strict";

            const forms = document.querySelectorAll("form");

            Array.from(forms).forEach(form => {
                form.addEventListener("submit", event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add("was-validated");
                }, false);
            });
        })();
    </script>
</body>

</html>