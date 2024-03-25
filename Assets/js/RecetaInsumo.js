console.log('dentro de recetas relacionada con insumos');

function frmRecetaInsumo() {
    document.getElementById("title").textContent = "Nuevo Asignación";
    document.getElementById("btnAccion").textContent = "Registrar";
    document.getElementById("frmRecetaInsumo").reset();
    document.getElementById("id").value = "";
    $("#nuevoRecetaInsumo").modal("show");

}

$(document).ready(function() {


$('.js-example-basic-multiple').select2({
    placeholder: 'Buscar Insumo',
    minimumInputLength: 2,
    closeOnSelect: false,
    ajax: {
        url: base_url + 'Insumos/buscarInsumo',
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

});

function registrarListaInsumo(e) {
    e.preventDefault();
        const url = base_url + "Recetas/registrar";
        const frm = document.getElementById("frmAsignarInsumo");
        console.log(frm);
        /*
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                $("#nuevoReceta").modal("hide");
                frm.reset();
                tblRecetas.ajax.reload();
                alertas(res.msg, res.icono);
            }
        }
        */

}