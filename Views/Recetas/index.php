<?php include "Views/Templates/header.php"; ?>



<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Recetas</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary mb-2" type="button" onclick="frmRecetas()"><i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary mb-2" type="button" onclick="descargarPlantillaExcel()">Descargar Plantilla</i>
            </div>
        </div>
    </div>
  
        <div class="col-md-6" style="display: flex;">

            <div class="col-md-6">
                <input type="file" id="fileInput" class="custom-file-input" accept=".csv, .xlsx" onchange="actualizarNombreArchivo(this)">
                <label for="fileInput" class="custom-file-label" id="nombreArchivoLabel">Seleccionar Archivo</label>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary mb-2" type="button" onclick="cargarArchivo()">Carga Masiva</i>
            </div>
        </div>

</div>

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
<div id="nuevoReceta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title">Registro Recetas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRecetas">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
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