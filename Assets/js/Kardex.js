function alertas(msg, icono) {
    Swal.fire({
        position: 'top-end',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    })
}
$('.codigo_insumo').select2({
    placeholder: 'Buscar por código ...',
    minimumInputLength: 3,
    ajax: {
        url: base_url + 'Kardex/buscarInsumo',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term               
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

$('.articulo_insumo').select2({
    placeholder: 'Buscar por articulo ...',
    minimumInputLength: 3,
    ajax: {
        url: base_url + 'Kardex/buscarArticulo',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term               
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
/*
//Detectar el evento change del select
$('.codigo_insumo').on('change', function(e) {
    //obtener el valor del atributo 'cliente' del option seleccionado
    //let idCliente = $('.codigo_insumo option:selected').attr('data');
    let idCliente =e.params.data;
    console.log(idCliente);
    //Pasar el valor obtenido al input cliente_id
    $('#cantidad').val(idCliente);
  });
*/
  $('#codigo_insumo').on('select2:select', function (e) {
    var data = e.params.data.id;
    const url = base_url + "Kardex/infoT/"+data;
    console.log(url);
    
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send();

    
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            console.log(res);
            //$('#articulo_insumo').val(res.id).text(res.in_arti);
            var newOption = new Option(res.in_arti, res.id, true, true);
            // Append it to the select
            $('#articulo_insumo').append(newOption).trigger('change');
            $('#part_number').val(res.part_number);
            $('#marca').val(res.marca);
            $('#medida').val(res.in_uvta);
            $('#familia').val(res.tipo);
            console.log("ok");
        }
    }
    

});

$('#articulo_insumo').on('select2:select', function (e) {
    var data = e.params.data.id;

    const url = base_url + "Kardex/infoT/"+data;
    console.log(url);
    
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send();

    
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            console.log(res);
            //$('#articulo_insumo').val(res.id).text(res.in_arti);
            var newOption = new Option(res.ind_codi, res.id, true, true);
            // Append it to the select
            $('#codigo_insumo').append(newOption).trigger('change');
            $('#part_number').val(res.part_number);
            $('#marca').val(res.marca);
            $('#medida').val(res.in_uvta);
            $('#familia').val(res.tipo);
            console.log("ok");
        }
    }
    

});
function deleteImg() {
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto_actual").value = '';
}

function registrarLibro(e) {
    e.preventDefault();
    const codigo = document.getElementById("codigo_insumo");
    const articulo = document.getElementById("articulo_insumo");
    const partNumber = document.getElementById("part_number");
    const marca = document.getElementById("marca");
    const cantidad = document.getElementById("cantidad");
    const descripcion = document.getElementById("descripcion");
    //console.log(codigo.option[codigo.selectedIndex]);

    if (codigo.value == '' || articulo.value == '' || cantidad.value == '') {
        alertas('Hay campos son requeridos', 'warning');
    } else {
        Swal.fire({
            title: 'Esta seguro de Guardar?',
            text: "Esta ingresando una cantidad de  : "+cantidad.value+" en el articulo con id :"+articulo.value,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("dale ok");
        
                const url = base_url + "Kardex/registrar";
                const frm = document.getElementById("frmLibro");
                const http = new XMLHttpRequest();
                http.open("POST", url, true);
                http.send(new FormData(frm));
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        //$("#nuevoLibro").modal("hide");
                        //tblLibros.ajax.reload();
                        frm.reset();
                        var newOption = new Option("", "", true, true);
                        // Append it to the select
                        $('#codigo_insumo').append(newOption).trigger('change');
                        var newOption = new Option("", "" ,true, true);
                        // Append it to the select
                        $('#articulo_insumo').append(newOption).trigger('change');
                        deleteImg();
                        alertas(res.msg, res.icono);
                        console.log(res);
                    }
                }
    
            }
        })



    }
}

function preview(e) {
    var input = document.getElementById('imagen');
    var filePath = input.value;
    var extension = /(\.png|\.jpeg|\.jpg)$/i;
    if (!extension.exec(filePath)) {
        alertas('Seleccione un archivo valido', 'warning');
        deleteImg();
        return false;
    }else{
        const url = e.target.files[0];
        const urlTmp = URL.createObjectURL(url);
        document.getElementById("img-preview").src = urlTmp;
        document.getElementById("icon-image").classList.add("d-none");
        document.getElementById("icon-cerrar").innerHTML = `
        <button class="btn btn-danger" onclick="deleteImg()"><i class="fa fa-times-circle"></i></button>
        `;
    }

}