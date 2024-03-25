
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