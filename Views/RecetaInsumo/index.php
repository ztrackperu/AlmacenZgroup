<?php include "Views/Templates/header.php"; ?>



<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Recetas</h1>
    </div>
</div>
<button class="btn btn-primary mb-2" type="button" onclick="frmRecetaInsumo()"><i class="fa fa-plus"></i></button>

<form id="frmAsignarInsumo" class="row" >

<div class="col-md-4">

<div class="form-group">
    <h2><label for="codigoInsumo">Receta * </label></h2>
</div>
</div>
<div class="col-md-8">
<div class="form-group">
    <select id="recetasA" class="js-example-basic-multiple" name="recetasA[]" multiple="multiple" required style="width: 100%;">                            
     </select>

</div>
</div>

<div class="col-md-12">
    <div class="form-group">
            <button class="btn btn-primary " type="submit" onclick="registrarListaInsumo(event)" id="btnAccion">Agregar</button>
    </div>
</div>

</form>

<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblRecetas">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="nuevoRecetaInsumo" class="modal fade"  role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Recetas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRecetaInsumo">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
                            <div class="form-group">
                            <label for="recetas1">Insumo* </label><br>
                            <select id="recetas1" class="form-control recetas1" name="recetas1" required style="width: 100%;">                            
                            </select>
                        </div>
                                <label for="codigo">Código</label>
                                <input type="hidden" id="id" name="id">

                                <input id="codigo_receta" class="form-control" type="text" name="codigo_receta" required placeholder="Código de Receta">
                                <label for="nombre">Nombre</label>
                                <input id="nombre_receta" class="form-control" type="text" name="nombre_receta" required placeholder="Nombre de Receta">
                                <label for="descripcion">Descripción</label>
                                <input id="descripcion_receta" class="form-control" type="text" name="descripcion_receta" required placeholder="Descripcion de Receta">


                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" onclick="registrarReceta(event)" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>