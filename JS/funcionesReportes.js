$(document).ready(function () {

  const fecha = new Date();
  const año = fecha.getFullYear(); // Devuelve el año
  const mes = fecha.getMonth() + 1; // Devuelve el mes (0-11)
  const dia = fecha.getDate(); // Devuelve el día del mes

  mostrarfecha.innerHTML = `Fecha: ${dia}/${mes}/${año}`

  // Initialize Flatpickr
  flatpickr("#datepicker", {
    dateFormat: "Y-m-d", // Format: YYYY-MM-DD
    mode: "range",
    locale: {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      },
      months: {
        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
        longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      },
    },
    onClose: function (selectedDates, dateStr, instance) {
      let dateSinNada = dateStr.replace(/\s/g, '');
      let nuevoDate = dateSinNada.replaceAll(/to/g, "/");
      var datos = nuevoDate.split("/")
      let fechaInicio = datos[0];
      let fechaFinal = datos[1];
      if (fechaFinal === undefined) {
        mostrarfecha.innerHTML = `Reporte del : ${fechaInicio}`
      } else {
        mostrarfecha.innerHTML = `Reporte del : ${fechaInicio} al ${fechaFinal}`
      }
      let sumTotal = 0;
      $.post('../models/reportes/obtenerReportesDate.php', { fechaInicio, fechaFinal }, function (response) {
        let reporDate = JSON.parse(response);
        console.log(reporDate)
        let template = '';
        reporDate.forEach(reporDate => {
          template += `
                <tr>
                   <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <p class="text-xs font-weight-bold mb-0">${reporDate.membresia}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">${reporDate.cantidad}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0">$${reporDate.costo}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">$${reporDate.total}</span>
                  </td> 
                  </tr>
                `
          let sum = Number(reporDate.total)
          sumTotal = sum + sumTotal
        });
        console.log(sumTotal)
        suma.innerHTML = 'Suma Total: $' + sumTotal
        $('#reportes').html(template);
      })
    }
  });


  //Función para obtener reportes
  $.ajax({

    url: '../models/reportes/obtenerReportes.php',
    type: 'GET',
    success: function (response) {
      let sumTotal = 0;
      let reportes = JSON.parse(response);
      let template = '';
      reportes.forEach(reportes => {
        template += `
                <tr>
                   <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <p class="text-xs font-weight-bold mb-0">${reportes.membresia}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">${reportes.cantidad}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0">$${reportes.costo}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">$${reportes.total}</span>
                  </td> 
                  </tr>
                `
        let sum = Number(reportes.total)
        sumTotal = sum + sumTotal
      });
      console.log(sumTotal)
      suma.innerHTML = 'Suma Total: $' + sumTotal
      $('#reportes').html(template);
    }
  })

  $(document).on('click', '.turno1', function () {
    console.log('Turno 1')
    let turno = 'Turno 1'
    let sumTotal = 0;
    $.post('../models/reportes/obtenerReportesPorTurno.php', { turno }, function (response) {
      let reportes = JSON.parse(response);
      let template = '';
      reportes.forEach(reportes => {
        template += `
                <tr>
                   <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <p class="text-xs font-weight-bold mb-0">${reportes.membresia}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">${reportes.cantidad}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0">$${reportes.costo}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">$${reportes.total}</span>
                  </td> 
                  </tr>
                `
        let sum = Number(reportes.total)
        sumTotal = sum + sumTotal
      });
      console.log(sumTotal)
      suma.innerHTML = 'Suma Total: $' + sumTotal
      $('#reportes').html(template);
    })
  })

  $(document).on('click', '.turno2', function () {
    console.log('Turno 2')
    let turno = 'Turno 2'
    let sumTotal = 0;
    $.post('../models/reportes/obtenerReportesPorTurno.php', { turno }, function (response) {
      let reportes = JSON.parse(response);
      let template = '';
      reportes.forEach(reportes => {
        template += `
                <tr>
                   <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <p class="text-xs font-weight-bold mb-0">${reportes.membresia}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">${reportes.cantidad}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0">$${reportes.costo}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">$${reportes.total}</span>
                  </td> 
                  </tr>
                `
        let sum = Number(reportes.total)
        sumTotal = sum + sumTotal
      });
      console.log(sumTotal)
      suma.innerHTML = 'Suma Total: $' + sumTotal
      $('#reportes').html(template);
    })
  })

  $(document).on('click', '.completo', function () {
    console.log('Completo')
    $.get('../models/reportes/obtenerReportes.php', function (response) {
      let reportes = JSON.parse(response);
      let sumTotal = 0;
      let template = '';
      reportes.forEach(reportes => {
        template += `
                <tr>
                   <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <p class="text-xs font-weight-bold mb-0">${reportes.membresia}</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">${reportes.cantidad}</p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0">$${reportes.costo}</p>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">$${reportes.total}</span>
                  </td> 
                  </tr>
                `
        let sum = Number(reportes.total)
        sumTotal = sum + sumTotal
      });
      console.log(sumTotal)
      suma.innerHTML = 'Suma Total: $' + sumTotal
      $('#reportes').html(template);
    })
  })

  $(document).on('click', '.generatepdf', function () {
    const options = {
      filename: document.getElementById('mostrarfecha').textContent,
      image: { type: 'pdf', quality: 0.98 },
      html2canvas: { 
        scale: 2 
      },
      jsPDF: {
        unit: 'in',
        format: 'a4',
        orientation: 'portrait',
      }
    }
    const element = document.getElementById('htmlpdf');
    html2pdf().set(options).from(element).save();
  })


   $(document).on('click','.salir',function () {
        console.log('Salir de sesion')
        $.post('../models/inicioSesion/salirSesion.php',function (res) {
        });
    })

})