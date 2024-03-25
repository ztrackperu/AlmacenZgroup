<?php include "Views/Templates/header.php"; ?>

<div class="app-title">
    <div> 
        <h1><i class="fa fa-dashboard"></i> Insumos</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary mb-2" type="button" onclick="frmInsumos()"><i class="fa fa-plus"></i>
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
                    <table class="table table-light mt-4" id="tblInsumos">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Código</th>
                                <th>Insumo</th>
                                <th>Categoria</th>
                                <th>Almacen</th>
                                <th>Estado</th>
                                <th></th>
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

<div id="nuevoInsumo" class="modal fade" role="dialog"   aria-labelledby="my-modal-title" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Insumo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
         
                <form id="frmInsumo" class="row" onsubmit="registrarInsumo(event)"> 
                    <div class="col-md-4">

                        <div class="form-group">
                            <label for="codigoInsumo">Código *</label>
                            <input type="hidden" id="id" name="id">
                            <input id="codigoInsumo" class="form-control" type="text" name="codigoInsumo" placeholder="Código del Insumo" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nombreInsumo">Nombre *</label><br>
                            <input id="nombreInsumo" class="form-control" type="text" name="nombreInsumo" placeholder="Nombre del Insumo" required>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="categoria">Categoria* </label><br>
                            <select id="categoria" class="form-control categoria" name="categoria" required style="width: 100%;">                            
                            </select>
                        </div>

                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary mb-2" id ="btnCategoria" ><i class="fa fa-plus"></i></button>
                  
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marcaInsumo">Marca</label><br>
                            <input id="marcaInsumo" class="form-control" type="text" name="marcaInsumo" placeholder="Marca del Insumo" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="almacen">Almacén*</label><br>
                            <select id="almacen" class="form-control almacen" name="almacen" required style="width: 100%;">                            
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcionInsumo">Descripción</label><br>
                            <textarea id="descripcionInsumo" class="form-control" name="descripcionInsumo" rows="2" placeholder="Descripción ..."></textarea>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="partNumber1">Part Number 1</label>
                            <input id="partNumber1" class="form-control" type="text" name="partNumber1" placeholder="Part Number 1" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="partNumber2">Part Number 2</label>
                            <input id="partNumber2" class="form-control" type="text" name="partNumber2" placeholder="Part Number 2" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="partNumber3">Part Number 3</label>
                            <input id="partNumber3" class="form-control" type="text" name="partNumber3" placeholder="Part Number 3" >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="partNumber4">Part Number 4</label>
                            <input id="partNumber4" class="form-control" type="text" name="partNumber4" placeholder="Part Number 4" >
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rack">Rack</label>
                            <input id="rack" class="form-control" type="text" name="rack" placeholder="Ingrese rack ..." >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="anaquel">Anaquel</label>
                            <input id="anaquel" class="form-control" type="text" name="anaquel" placeholder="Ingrese anaquel ..." >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="piso">Piso</label>
                            <input id="piso" class="form-control" type="text" name="piso" placeholder="Ingrese piso ..." >
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sector">Sector</label>
                            <input id="sector" class="form-control" type="text" name="sector" placeholder="Ingrese sector ..." >
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Imagen</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="previewI(event)">
                                    <img class="img-thumbnail" id="img-preview" src="" width="150">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                            <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="nuevoCategoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="title1">Registro Recetas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmCategorias">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <input type="hidden" id="id1" name="id1">

                                <label for="nombre">Nombre</label>
                                <input id="nombre_categoria" class="form-control" type="text" name="nombre_categoria" required placeholder="Nombre de Categoria">
                                <label for="descripcion">Descripción</label>
                                <input id="descripcion_categoria" class="form-control" type="text" name="descripcion_categoria"  placeholder="Descripcion de Categoria">


                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnAccion1" name="btnAccion1">Registrar</button>
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