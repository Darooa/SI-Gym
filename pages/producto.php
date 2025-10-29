<!--
=========================================================
* Argon Dashboard 2 - v2.0.4
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
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
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/efectos-Dashboard.css" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/efectos-Productos.css" rel="stylesheet" />


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
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
                target="_blank">
                <img src="assets/img/logos/icono_negro.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Trasciende GYM</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a class="nav-link" href="./pages/dashboard.html">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>

                <!-- STOCK -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">STOCK</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="categorias.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67 text-success text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Categorías</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="producto.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-box-2 text-primary text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Productos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="compras.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-cart text-warning text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Compras</span>
                    </a>
                </li>

                <!-- VENTAS -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">VENTAS</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-shop text-info text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Ventas</span>
                    </a>
                </li>

                <!-- FINANZAS -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">FINANZAS</h6>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="caja.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-danger text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Caja</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="reportesC.php">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10 icon-animated"></i>
                        </div>
                        <span class="nav-link-text ms-1">Reportes</span>
                    </a>
                </li>
            </ul>
        </div>


    </aside>

    <!------------------------------------------------------------------------------>
    <!------------------------------- N A V B A R ------------------------------>
    <!------------------------------------------------------------------------------>

    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Productos</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Administración de Productos</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">Iniciar sesión</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!------------------------------------------------------------------------------>
        <!------------------------------------------------------------------------------>
        <!-------------------------------C O N T E N I D O------------------------------>
        <!------------------------------------------------------------------------------>
        <!------------------------------------------------------------------------------>

        <div class="container-fluid py-4">

            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card ">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Productos</h6>
                                <button class="btn btn-success btn-sm ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#AgregarProducto">Agregar Producto</button>
                            </div>
                        </div>

                        <!------------------------------ MODAL AGREGAR PRODUCTO ---------------------------->
                        <div class="modal fade" id="AgregarProducto" tabindex="-1" aria-labelledby="ModalProductoLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <form id="agregarProducto" novalidate>
                                    <div class="modal-content border-0 shadow-lg"
                                        style="border-radius: 20px; overflow: hidden;">
                                        <div class="modal-header bg-gradient-success text-white">
                                            <h5 class="modal-title fw-bold" id="ModalProductoLabel">
                                                <i class="fa-solid fa-box me-2"></i> Agregar Producto
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label for="TGYM_nombre" class="form-label fw-bold">Nombre</label>
                                                    <input type="text" class="form-control" id="TGYM_nombre"
                                                        name="TGYM_nombre" placeholder="Ej. Proteína Whey" required>
                                                    <div class="invalid-feedback">Por favor, ingresa el nombre del
                                                        producto.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_marca" class="form-label fw-bold">Marca</label>
                                                    <input type="text" class="form-control" id="TGYM_marca"
                                                        name="TGYM_marca" placeholder="Ej. GNC" required>
                                                    <div class="invalid-feedback">Ingresa la marca del producto.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_contenido"
                                                        class="form-label fw-bold">Contenido</label>
                                                    <input type="text" class="form-control" id="TGYM_contenido"
                                                        name="TGYM_contenido" placeholder="Ej. 1 Kg">
                                                    <div class="invalid-feedback">Especifica el contenido del producto.
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_categoria"
                                                        class="form-label fw-bold">Categoría</label>
                                                    <select class="form-select" id="TGYM_categoria"
                                                        name="TGYM_categoria" required>
                                                        <option value="">Seleccione una categoría</option>
                                                        <?php
                                                          $conect = mysqli_connect("localhost","root","","bd_trasciende");
                                                          $conect->set_charset("utf8");
                                                          $qry_planes="SELECT * FROM categorias WHERE estado='1'";
                                                          if ($resultado = mysqli_query($conect, $qry_planes)) {
                                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                              echo '<option value="'.$row["id_categoria"].'">'.$row["nombre"].'</option>';
                                                            }
                                                            mysqli_free_result($resultado);
                                                          }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Seleccione una categoría válida.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_stockinicial" class="form-label fw-bold">Stock
                                                        inicial</label>
                                                    <input type="number" class="form-control" id="TGYM_stockinicial"
                                                        name="TGYM_stockinicial" min="0" required>
                                                    <div class="invalid-feedback">Ingrese el stock inicial.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_descripcion"
                                                        class="form-label fw-bold">Descripción</label>
                                                    <input type="text" class="form-control" id="TGYM_descripcion"
                                                        name="TGYM_descripcion"
                                                        placeholder="Ej. Suplemento alimenticio">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_preciocompra" class="form-label fw-bold">Precio de
                                                        compra</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-solid fa-dollar-sign"></i></span>
                                                        <input type="number" class="form-control" id="TGYM_preciocompra"
                                                            name="TGYM_preciocompra" step="0.01" min="0" required>
                                                        <div class="invalid-feedback">Ingrese un precio de compra
                                                            válido.</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="TGYM_precioventa" class="form-label fw-bold">Precio de
                                                        venta</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-solid fa-dollar-sign"></i></span>
                                                        <input type="number" class="form-control" id="TGYM_precioventa"
                                                            name="TGYM_precioventa" step="0.01" min="0" required>
                                                        <div class="invalid-feedback">Ingrese un precio de venta válido.
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="fa-solid fa-xmark me-1"></i> Cerrar
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!------------------------------ MODAL EDITAR PRODUCTO ----------------------------->
                        <div class="modal fade" id="EDTProducto" tabindex="-1" aria-labelledby="EditarProductoLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <form id="updateProducto" novalidate>
                                    <div class="modal-content border-0 shadow-lg"
                                        style="border-radius: 20px; overflow: hidden;">
                                        <div class="modal-header bg-gradient-info text-white">
                                            <h5 class="modal-title fw-bold" id="EditarProductoLabel">
                                                <i class="fa-solid fa-pen-to-square me-2"></i> Editar Producto
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="trid" id="trid">

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label for="EDT_nombre" class="form-label fw-bold">Nombre</label>
                                                    <input type="text" class="form-control" id="EDT_nombre"
                                                        name="EDT_nombre" required>
                                                    <div class="invalid-feedback">Ingrese el nombre del producto.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_marca" class="form-label fw-bold">Marca</label>
                                                    <input type="text" class="form-control" id="EDT_marca"
                                                        name="EDT_marca" required>
                                                    <div class="invalid-feedback">Ingrese la marca del producto.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_contenido"
                                                        class="form-label fw-bold">Contenido</label>
                                                    <input type="text" class="form-control" id="EDT_contenido"
                                                        name="EDT_contenido">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_categoria"
                                                        class="form-label fw-bold">Categoría</label>
                                                    <select class="form-select" id="EDT_categoria" name="EDT_categoria"
                                                        required>
                                                        <option value="">Seleccione una categoría</option>
                                                        <?php
                                                          $conect = mysqli_connect("localhost","root","","bd_trasciende");
                                                          $conect->set_charset("utf8");
                                                          $qry_planes="SELECT * FROM categorias WHERE estado='1'";
                                                          if ($resultado = mysqli_query($conect, $qry_planes)) {
                                                            while ($row = mysqli_fetch_assoc($resultado)) {
                                                              echo '<option value="'.$row["id_categoria"].'">'.$row["nombre"].'</option>';
                                                            }
                                                            mysqli_free_result($resultado);
                                                          }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Seleccione una categoría válida.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_stock" class="form-label fw-bold">Stock
                                                        actual</label>
                                                    <input type="number" class="form-control" id="EDT_stock"
                                                        name="EDT_stock" min="0" required>
                                                    <div class="invalid-feedback">Ingrese un stock válido.</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_descripcion"
                                                        class="form-label fw-bold">Descripción</label>
                                                    <input type="text" class="form-control" id="EDT_descripcion"
                                                        name="EDT_descripcion">
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_pcompra" class="form-label fw-bold">Precio de
                                                        compra</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-solid fa-dollar-sign"></i></span>
                                                        <input type="number" class="form-control" id="EDT_pcompra"
                                                            name="EDT_pcompra" step="0.01" min="0" required>
                                                        <div class="invalid-feedback">Ingrese un precio válido.</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="EDT_pventa" class="form-label fw-bold">Precio de
                                                        venta</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-solid fa-dollar-sign"></i></span>
                                                        <input type="number" class="form-control" id="EDT_pventa"
                                                            name="EDT_pventa" step="0.01" min="0" required>
                                                        <div class="invalid-feedback">Ingrese un precio válido.</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                <i class="fa-solid fa-xmark me-1"></i> Cerrar
                                            </button>
                                            <button type="submit" class="btn btn-info text-white">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-------------------------------------- TABLA ------------------------------------->
                        <!-- <table id="Clientes" class="table app-table-hover mb-0 display nowrap text-left"
                                    cellspacing="0" width="100%" -->
                        <table id="Productos" class="table align-items-center justify-content-center" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nombre</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Marca</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Contenido</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Categoría</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Descripción</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Stock</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        P. Compra</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        P. Venta</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Agregado</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Acciones</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    </th>


                                    <th></th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                </div>

            </div>



            <!------------------------------------------------------------------------------>
            <!--------------------------------- F O O T E R -------------------------------->
            <!------------------------------------------------------------------------------>

            <footer class="footer pt-3  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                © <script>
                                document.write(new Date().getFullYear())
                                </script>,
                                Todos los derechos reservados <i class="fa fa-heart"></i>
                                <a href="" class="font-weight-bold" target="_blank">Trasciende</a>
                                for a better web.
                            </div>
                        </div>

                    </div>
                </div>
            </footer>
        </div>
    </main>


    <!------------------------------------------------------------------------------>
    <!------------------------ C O N F I G U R A C I Ó N --------------------------->
    <!------------------------------------------------------------------------------>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="ni ni-settings-gear-65"></i>
            <!-- <i class="fa fa-cog py-2"></i> -->
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Trasciende GYM</h5>
                    <p>Opciones del panel de control.</p>
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
                    <h6 class="mb-0">Colores de la Barra Lateral</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Tipo de Navegación Lateral</h6>
                    <p class="text-sm">Elija entre 2 tipos de navegación lateral diferentes.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default"
                        onclick="sidebarType(this)">Dark</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">Puede cambiar el tipo de navegación lateral solo en la vista
                    de escritorio.</p>
                <!-- Navbar Fixed -->
                <div class="d-flex my-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                            onclick="navbarFixed(this)">
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                            onclick="darkMode(this)">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="assets/js/plugins/chartjs.min.js"></script>
    <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
    </script>
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

    <!-- Funciones JS -->
    <script src="../js/funcionesProductos.js"></script>
</body>

</html>