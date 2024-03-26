
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
            console.log("ok");
        }
    }
    

});