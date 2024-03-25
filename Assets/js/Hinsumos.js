let tblHinsumos;
console.log('en historial insumos');
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

        tblHinsumos = $('#tblHinsumos').DataTable({
        ajax: {
            url: base_url + "Hinsumos/listar",
            dataSrc: ''
        },
        columns: [{
                'data': 'insumo_id'
            },
            {
                'data': 'codigo_insumo'
            },
            {
                'data': 'nombre_insumo'
            },
            {
                'data': 'marca'
            },
            {
                'data': 'categoria_id'
            },
            {
                'data': 'almacen_id'
            },
            {
                'data': 'part_number_1'
            },
            {
                'data': 'part_number_2'
            },
            {
                'data': 'part_number_3'
            },
            {
                'data': 'part_number_4'
            },
            {
                'data': 'rack'
            },
            {
                'data': 'anaquel'
            },
            {
                'data': 'piso'
            },
            {
                'data': 'sector'
            },
            {
                'data': 'fecha'
            },
            {
                'data': 'user'
            },          
            {
                'data': 'evento'
            }
        ],
        language,
        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons
    });

})