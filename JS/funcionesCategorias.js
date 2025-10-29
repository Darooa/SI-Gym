$(document).ready(function () {

  // ==========================================================
  // FUNCIÓN PRINCIPAL PARA CARGAR LAS CATEGORÍAS
  // ==========================================================
  function cargarCategorias() {
  fetch("../models/categorias/obtenerCategorias.php")
    .then(res => res.json())
    .then(data => {
      const tabla = $("#tablaCategorias tbody");
      tabla.empty();
      const categorias = Array.isArray(data) ? data : (data.categorias || []);

      categorias.forEach(cat => {
        const estado =
          cat.estado == 1
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-secondary">Inactivo</span>';

        const btnAccion =
          cat.estado == 1
            ? `<button class="btn-icon eliminar" title="Desactivar" data-id="${cat.id_categoria}">
                <i class="fa-solid fa-ban text-danger"></i>
              </button>`
            : `<button class="btn-icon activar" title="Activar" data-id="${cat.id_categoria}">
                <i class="fa-solid fa-circle-check text-success"></i>
              </button>`;

        tabla.append(`
          <tr>
            <td>${cat.id_categoria}</td>
            <td>${cat.nombre}</td>
            <td>${estado}</td>
            <td class="text-center">
              <button class="btn-icon editar" title="Editar"
                      data-id="${cat.id_categoria}" data-nombre="${cat.nombre}">
                <i class="fa-solid fa-pen-to-square text-warning"></i>
              </button>
              ${btnAccion}
            </td>
          </tr>
        `);
      });


    })
    .catch(err => {
      console.error("Error cargando categorías:", err);
      Swal.fire("Error", "No se pudieron cargar las categorías.", "error");
    });
  }


  // Cargar categorías al iniciar
  cargarCategorias();


  // ==========================================================
  // AGREGAR NUEVA CATEGORÍA
  // ==========================================================
  $("#btnAgregarCategoria").click(function (e) {
    e.preventDefault();

    const nombre = $("#nombreCategoria").val().trim();

    if (nombre === "") {
      Swal.fire("Atención", "Escribe el nombre de la categoría.", "info");
      return;
    }

    fetch("../models/categorias/agregarCategoria.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nombre })
    })
      .then(res => res.json())
      .then(data => {
        Swal.fire({
          icon: data.status,
          title: data.status === "success" ? "Correcto" : "Error",
          text: data.message,
          timer: 2000,
          showConfirmButton: false,
          didClose: () => {
            document.body.classList.remove('swal2-shown');
            document.body.style.overflow = 'auto';
            document.body.style.paddingRight = '0';
          }
        });
        if (data.status === "success") {
          $("#nombreCategoria").val("");
          cargarCategorias();
        }
      });
  });


  // ==========================================================
  // EDITAR CATEGORÍA
  // ==========================================================
  $(document).on("click", ".editar", function () {
    const id = $(this).data("id");
    const nombreActual = $(this).data("nombre");

    Swal.fire({
      title: "Editar categoría",
      input: "text",
      inputValue: nombreActual,
      inputLabel: "Nuevo nombre",
      showCancelButton: true,
      confirmButtonText: "Guardar cambios",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      inputValidator: (value) => {
        if (!value) return "Por favor escribe un nombre válido.";
      }
    }).then(result => {
      if (result.isConfirmed) {
        const nuevoNombre = result.value.trim();

        fetch("../models/categorias/editarCategoria.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id, nombre: nuevoNombre })
        })
          .then(res => res.json())
          .then(data => {
            Swal.fire({
              icon: data.status === "success" ? "success" :
                    data.status === "warning" ? "info" : "error",
              title: data.status === "success" ? "Actualizado" : "Atención",
              text: data.message,
              confirmButtonColor: "#3085d6",
              didClose: () => {
                document.body.classList.remove('swal2-shown');
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';
              }
            });
            cargarCategorias();
          });
      }
    });
  });


  // ==========================================================
  // DESACTIVAR CATEGORÍA
  // ==========================================================
  $(document).on("click", ".eliminar", function () {
    const id = $(this).data("id");

    Swal.fire({
      title: "¿Desactivar categoría?",
      text: "Esta acción desactivará la categoría, pero podrás reactivarla más adelante.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, desactivar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6"
    }).then(result => {
      if (result.isConfirmed) {
        fetch("../models/categorias/eliminarCategoria.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id })
        })
          .then(res => res.json())
          .then(data => {
            Swal.fire({
              icon: data.status === "success" ? "success" : "error",
              title: data.status === "success" ? "Desactivada" : "Error",
              text: data.message,
              confirmButtonColor: "#3085d6",
              didClose: () => {
                document.body.classList.remove('swal2-shown');
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';
              }
            });
            cargarCategorias();
          });
      }
    });
  });


  // ==========================================================
  // REACTIVAR CATEGORÍA
  // ==========================================================
  $(document).on("click", ".activar", function () {
    const id = $(this).data("id");

    Swal.fire({
      title: "¿Reactivar categoría?",
      text: "Esta categoría volverá a estar disponible para su uso.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, reactivar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33"
    }).then(result => {
      if (result.isConfirmed) {
        fetch("../models/categorias/activarCategoria.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id })
        })
          .then(res => res.json())
          .then(data => {
            Swal.fire({
              icon: data.status === "success" ? "success" : "error",
              title: data.status === "success" ? "Activada" : "Error",
              text: data.message,
              confirmButtonColor: "#3085d6",
              didClose: () => {
                document.body.classList.remove('swal2-shown');
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';
              }
            });
            cargarCategorias();
          });
      }
    });
  });

});
