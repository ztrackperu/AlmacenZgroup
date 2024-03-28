let tblStock;

function alertas(msg, icono) {
    Swal.fire({
        position: 'top-end',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}

document.addEventListener("DOMContentLoaded", function(){
    const language = {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }

    }
    const  buttons = [{
                //Botón para Excel
                extend: 'excel',
                footer: true,
                title: 'Archivo',
                filename: 'Export_File',

                //Aquí es donde generas el botón personalizado
                text: '<button class="btn btn-success"><i class="fa fa-file-excel-o"></i></button>'
            },
            //Botón para PDF
            {
                extend: 'pdf',
                footer: true,
                title: 'Archivo PDF',
                filename: 'reporte',
                text: '<button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></button>'
            },
            //Botón para print
            {
                extend: 'print',
                footer: true,
                title: 'Reportes',
                filename: 'Export_File_print',
                text: '<button class="btn btn-info"><i class="fa fa-print"></i></button>'
            }
        ]

    tblStock = $('#tblStock').DataTable({
        ajax: {
            url: base_url + "Stock/listar",
            dataSrc: ''
        },
        columns: [{
                'data': 'id'
            },
            {
                'data': 'codigo'
            },
            {
                'data': 'articulo'
            },
            {
                'data':'partNumber'
            },
            {
                'data':'serie'
            },
            {
                'data':'marca'
            },
            {
                'data':'medida'
            },
            {
                'data':'familia'
            },
            {
                'data':'condicion'
            },
            {
                'data':'stock'
            }
        ],
        language,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons
    });

})

function btnEditarMovimientos(id) {
    document.getElementById("title").textContent = "Actualizar Movimientos";
    document.getElementById("btnAccion").textContent = "Modificar";
    const url = base_url + "Recetas/editar/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("id").value = res.id;
            document.getElementById("codigo_receta").value = res.codigo_receta;
            document.getElementById("nombre_receta").value = res.nombre_receta;
            document.getElementById("descripcion_receta").value = res.descripcion;                

            $("#nuevoReceta").modal("show");
        }
    }
}

function btnEliminarReceta(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "La Receta no se eliminará de forma permanente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Recetas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblRecetas.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}

function registrarReceta(e) {
    e.preventDefault();
    const nombre_receta = document.getElementById("descripcion_articulo");
    if (nombre_receta.value == "") {
        alertas('El Nombre de la Articulo es requerido', 'warning');
    } else {
        const url = base_url + "Stock/registrar";
        const frm = document.getElementById("frmRecetas");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevoReceta").modal("hide");
                frm.reset();
                //tblRecetas.ajax.reload();
                alertas(res.msg, res.icono);
            }
        }
    }
}


function descargarPlantillaExcel() {
    const url = base_url + "Assets/plantilla/plantillaReceta.xlsx"; // Reemplaza esto con la ruta real de tu archivo
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.responseType = "blob";

    http.onload = function () {
        if (this.status === 200) {
            const blob = new Blob([this.response], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
            const enlaceDescarga = document.createElement("a");

            enlaceDescarga.href = window.URL.createObjectURL(blob);
            enlaceDescarga.download = "plantillaReceta.xlsx";

            document.body.appendChild(enlaceDescarga);
            enlaceDescarga.click();
            document.body.removeChild(enlaceDescarga);
        }
    };

    http.send();
}


function actualizarNombreArchivo(input) {
    const label = document.getElementById('nombreArchivoLabel'); // Obtén la etiqueta por su ID
    const nombreArchivo = input.files[0].name; // Obtén el nombre del archivo seleccionado
    label.textContent = nombreArchivo; // Actualiza el texto de la etiqueta con el nombre del archivo
}

function cargarArchivo() {
    var fileInput = document.getElementById('fileInput');

    if (fileInput.files.length > 0) {
        var archivo = fileInput.files[0];
        var lector = new FileReader();

        lector.onload = function (e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });
            var primeraHoja = workbook.SheetNames[0];
            var datos = XLSX.utils.sheet_to_json(workbook.Sheets[primeraHoja]);
            // Enviar los datos al servidor
            enviarDatosAlServidor(datos);

            console.log("enviarDatosAlServidor",enviarDatosAlServidor)

        };

        lector.readAsArrayBuffer(archivo);
    } else {
        alertas('Por Favor , selecciona un archivo Excel','warning');
       
    }
}

function enviarDatosAlServidor(datos) {
    // Convertir los datos a formato JSON
    var datosJSON = JSON.stringify(datos);
    
    // Crear una solicitud AJAX
    const url = base_url + "Recetas/registrarExcel";
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Manejar la respuesta del servidor
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Datos cargados exitosamente.');
            // Recargar los datos de la tabla
            tblRecetas.ajax.reload();
        } else {
            alert('Ocurrió un error al cargar los datos.');
        }
    };

    // Enviar los datos al servidor
    xhr.send(datosJSON);
}

function frmRecetas() {
    document.getElementById("title").textContent = "Nuevo Articulo";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmRecetas").reset();
    //document.getElementById("id").value = "";
    $("#nuevoReceta").modal("show");
}

function btnReingresarReceta(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Recetas/reingresar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    tblRecetas.ajax.reload();
                    alertas(res.msg, res.icono);
                }
            }

        }
    })
}
