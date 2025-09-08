$(document).ready(function () {

    //Función para obtener membresias
    obtenerMembresias()
    let edit = false;
    var uno = document.getElementById('btnAE');

    //Evento al agregar una membresia
    $('#agregar-membresia').submit(function (e) {
        const postData = {
            nombre: $('#nombre').val(),
            duracion: $('#duracion').val(),
            precio: $('#precio').val(),
            id_membresia: $('#membresiaId').val()
        };
        let url = edit === false ? '../models/membresias/agregarMembresia.php' : '../models/membresias/editarMembresia.php';
        $.post(url, postData, function (response) {
            if (uno.innerHTML === 'Editar') {
                Swal.fire({
                    title: "Membresía Editada",
                    icon: "success",
                    draggable: true
                });
                location.reload()
            } else {
                Swal.fire({
                    title: "Membresía Guardada",
                    icon: "success",
                    draggable: true
                });
                location.reload();
            }
        });

    })

    //Función para obtener membresias
    function obtenerMembresias() {
        $.ajax({
            url: '../models/membresias/obtenerMembresias.php',
            type: 'GET',
            success: function (response) {
                let membresias = JSON.parse(response);
                let template = '';
                membresias.forEach(membresias => {
                    template += `
                <div class="d-flex flex-column"  membresiaId=${membresias.id_membresia}>
                    <h6 class="mb-3 text-sm"> 
                    <a href="#" class="membresia-item">${membresias.membresia}</a>
                    <span style="font-weight: bolder;"> 
                    + ${membresias.duracion} días</span> $${membresias.precio} </h6>
                </div>
                <div  membresiaId=${membresias.id_membresia} class="ms-auto text-end">
                    <button type="button" class=" eliminar btn btn-block btn-danger btn-default mb-3">Eliminar</button>
                </div>
                `
                });
                $('#membresias').html(template);
            }
        })
    }

    //Función para eliminar una membresia
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
                let id = $(element).attr('membresiaId');
                $.post('../models/membresias/eliminarMembresia.php', { id }, function (response) {
                    obtenerMembresias()
                })
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "La membresía ha sido eliminada",
                    icon: "success"
                });
            }
        });
    })

    //Función para editar una membresia
    $(document).on('click', '.membresia-item', function () {
        $("#modal-form").modal('show')
        let element = $(this)[0].parentElement.parentElement
        let id = $(element).attr('membresiaId');
        uno.innerHTML = 'Editar';
        $.post('../models/membresias/obtenerMembresia.php', { id }, function (response) {
            const membresia = JSON.parse(response)
            $('#nombre').val(membresia.membresia);
            $('#duracion').val(membresia.duracion);
            $('#precio').val(membresia.precio);
            $('#membresiaId').val(membresia.id_membresia)
            edit = true;
        })

    })
})