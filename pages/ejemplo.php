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








                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><strong>Nombre del cliente: </strong> <?php echo $cliente ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><strong>Fecha de Inicio: </strong> <?php echo $fechaIni ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><strong>Tipo de membresía: </strong> <?php echo $nombreMembresia ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><strong>Fecha de término: </strong> <?php echo $fecha_lim ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><strong>Folio: </strong> <?php echo $folio ?></span>
                                    </div>
                                </div>
                            </div>


















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
             
              <div class="row">
                <button class="btn btn-primary btn-sm ms-auto ">Actualizar</button>
              </div>
            </div>
          </div>
        </div>





         <div class="row">
                                <div class="col-md-1"></div>
                                <?php
                                // Iterar los 5 ejercicios disponibles
                                for ($i = 0; $i < 5; $i++) {
                                    $nombre = $ejercicios[$i]['nombre'] ?? '';
                                    $descripcion = $ejercicios[$i]['rutina'] ?? '';
                                ?>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group mb-2">
                                            <label class="form-control-label">Nombre:</label>
                                            <input class="form-control bg-light" type="text" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            
                                            <textarea class="form-control bg-light" rows="10" readonly><?php echo htmlspecialchars($descripcion); ?></textarea>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>