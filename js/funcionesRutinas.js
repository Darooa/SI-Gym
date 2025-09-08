$(document).ready(function () {

    let nivel = '';
    let edit = false;
    var uno = document.getElementById('btnAE');
    var nombreRutina = document.getElementById('btnNombreRutina');

    //Función para obtener niveles
    $.ajax({
        url: '../models/rutinas/obtenerNiveles.php',
        type: 'GET',
        success: function (response) {
            let niveles = JSON.parse(response);
            let template = '';
            niveles.forEach(niveles => {
                template += `
                    <li nivelId=${niveles.nivel} ><a class=" nivel-item dropdown-item" href="#">${niveles.nivel}</a></li>
                `
            });
            $('#niveles').html(template);
        }
    })


    checkRutinaNueva.addEventListener('change', function () {
        let flag = $('#checkRutinaNueva').is(':checked')
        if (flag == true) {
            $('#flagInput').html(
                `
                <input class="form-control" type="text" id="rutinaNueva" placeholder="Principiante">
                `
            )
        } else if(flag==false) {
            $('#flagInput').html(
                `
                `
            )
        }
    });

    //Función para obtener las rutinas por nivel
    $(document).on('click', '.nivel-item', function () {
        let element = $(this)[0].parentElement
        nivel = $(element).attr('nivelId');
        nombreRutina.innerHTML = nivel
        uno.innerHTML = 'Agregar';
        console.log(nivel)
        $.post('../models/rutinas/obtenerRutina.php', { nivel }, function (response) {
            console.log(response)
            let rutina = JSON.parse(response);
            let template = '';
            rutina.forEach(rutina => {
                template += `
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" >
                  <div class="d-flex flex-column" rutinaId=${rutina.id_rutina}>
                    <h6 class="mb-3 text-sm">
                    <a href="#" class="rutina-item">${rutina.nombre}</a>
                    </h6>
                    <span class="mb-2 text-xs"><span class="text-dark font-weight-bold ms-sm-2">
                    ${rutina.rutina.replace(/(\r\n|\r|\n)/g, "<br>")}
                    </span></span>
                  </div>
                  <div rutinaId=${rutina.id_rutina} class="ms-auto text-end">
                    <a class=" eliminar btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                        class="far fa-trash-alt me-2"></i>Eliminar</a>
                  </div>
                </li>
                `
            });
            $('#rutinas').html(template);
        })
    })

    //Evento al agregar una rutina
    $('#agregar-rutina').submit(function (e) {
        let rutinaNueva = $('#rutinaNueva').val();
        if (rutinaNueva.trim() === "") {
            //Rutina existente
            const postData = {
                nombre: $('#nombre').val(),
                rutina: $('#rutina').val(),
                id_rutina: $('#rutinaId').val(),
                nivel: nivel
            };
            console.log(postData);
            let url = edit === false ? '../models/rutinas/agregarRutina.php' : '../models/rutinas/editarRutina.php';
            $.post(url, postData, function (response) {
                console.log(response)
                $.post('../models/rutinas/obtenerRutina.php', { nivel }, function (response) {
                    console.log(response)
                    let rutina = JSON.parse(response);
                    let template = '';
                    rutina.forEach(rutina => {
                        template += `
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" >
                  <div class="d-flex flex-column" rutinaId=${rutina.id_rutina}>
                    <h6 class="mb-3 text-sm">
                    <a href="#" class="rutina-item">${rutina.nombre}</a>
                    </h6>
                    <span class="mb-2 text-xs"><span class="text-dark font-weight-bold ms-sm-2">
                    ${rutina.rutina.replace(/(\r\n|\r|\n)/g, "<br>")}
                    </span></span>
                  </div>
                  <div rutinaId=${rutina.id_rutina} class="ms-auto text-end">
                    <a class=" eliminar btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                        class="far fa-trash-alt me-2"></i>Eliminar</a>
                  </div>
                </li>
                `
                    });
                    $('#rutinas').html(template);
                })
                if (uno.innerHTML === 'Editar') {
                    Swal.fire({
                        title: "Rutina Editada",
                        icon: "success",
                        draggable: true
                    });
                } else {
                    Swal.fire({
                        title: "Rutina Guardada",
                        icon: "success",
                        draggable: true
                    });
                }
                $('#agregar-rutina').trigger('reset')
            });
        } else {
            //Rutina nueva
            const postData = {
                nombre: $('#nombre').val(),
                rutina: $('#rutina').val(),
                id_rutina: $('#rutinaId').val(),
                nivel: rutinaNueva
            };
            console.log(postData);
            let url = edit === false ? '../models/rutinas/agregarRutina.php' : '../models/rutinas/editarRutina.php';
            $.post(url, postData, function (response) {
                console.log(response)
                $.post('../models/rutinas/obtenerRutina.php', { nivel }, function (response) {
                    console.log(response)
                    let rutina = JSON.parse(response);
                    let template = '';
                    rutina.forEach(rutina => {
                        template += `
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" >
                  <div class="d-flex flex-column" rutinaId=${rutina.id_rutina}>
                    <h6 class="mb-3 text-sm">
                    <a href="#" class="rutina-item">${rutina.nombre}</a>
                    </h6>
                    <span class="mb-2 text-xs"><span class="text-dark font-weight-bold ms-sm-2">
                    ${rutina.rutina.replace(/(\r\n|\r|\n)/g, "<br>")}
                    </span></span>
                  </div>
                  <div rutinaId=${rutina.id_rutina} class="ms-auto text-end">
                    <a class=" eliminar btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                        class="far fa-trash-alt me-2"></i>Eliminar</a>
                  </div>
                </li>
                `
                    });
                    $('#rutinas').html(template);
                })
                if (uno.innerHTML === 'Editar') {
                    Swal.fire({
                        title: "Rutina Editada",
                        icon: "success",
                        draggable: true
                    });
                } else {
                    Swal.fire({
                        title: "Rutina Guardada",
                        icon: "success",
                        draggable: true
                    });
                }
                $('#agregar-rutina').trigger('reset')
            });
        }
    })

    //Función para eliminar una rutina
    $(document).on('click', '.eliminar', function () {
        Swal.fire({
            title: "¿Estás seguro que deseas eliminar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "¡Si, eliminar!"
        }).then((result) => {
            if (result.isConfirmed) {
                let element = $(this)[0].parentElement;
                let id = $(element).attr('rutinaId');
                $.post('../models/rutinas/eliminarRutina.php', { id }, function (response) {
                    $.post('../models/rutinas/obtenerRutina.php', { nivel }, function (response) {
                        console.log(response)
                        let rutina = JSON.parse(response);
                        let template = '';
                        rutina.forEach(rutina => {
                            template += `
                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg" >
                  <div class="d-flex flex-column" rutinaId=${rutina.id_rutina}>
                    <h6 class="mb-3 text-sm">
                    <a href="#" class="rutina-item">${rutina.nombre}</a>
                    </h6>
                    <span class="mb-2 text-xs"><span class="text-dark font-weight-bold ms-sm-2">
                    ${rutina.rutina.replace(/(\r\n|\r|\n)/g, "<br>")}
                    </span></span>
                  </div>
                  <div rutinaId=${rutina.id_rutina} class="ms-auto text-end">
                    <a class=" eliminar btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                        class="far fa-trash-alt me-2"></i>Eliminar</a>
                  </div>
                </li>
                `
                        });
                        $('#rutinas').html(template);
                    })
                })
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "La rutina ha sido eliminada",
                    icon: "success"
                });
            }
        });
    })

    //Función para editar una rutina
    $(document).on('click', '.rutina-item', function () {
        let element = $(this)[0].parentElement.parentElement
        let id = $(element).attr('rutinaId');
        console.log(id)
        uno.innerHTML = 'Editar';
        $.post('../models/rutinas/obtenerUnaRutina.php', { id }, function (response) {
            const rutina = JSON.parse(response)
            console.log(rutina)
            $('#nombre').val(rutina.nombre);
            $('#rutina').val(rutina.rutina);
            $('#rutinaId').val(rutina.id_rutina)
            edit = true;
        })

    })

})