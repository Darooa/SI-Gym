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