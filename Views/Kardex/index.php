<?php include "Views/Templates/header.php"; ?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Ingreso al inventario </h1>
    </div>
</div>
<!--<button class="btn btn-primary mb-2" onclick="frmLibros()"><i class="fa fa-plus"></i></button>!-->
<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
            <form id="frmLibro" class="row" onsubmit="registrarLibro(event)">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="titulo">Codigo *</label>
                            <input type="hidden" id="id" name="id">
                            <select id="codigo_insumo" class="form-control codigo_insumo" name="codigo_insumo" required style="width: 100%;">               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="autor">Articulo *</label><br>
                            <select id="articulo_insumo" class="form-control articulo_insumo" name="articulo_insumo" required style="width: 100%;">
                            <!--<option id="selectAutor" value="0">Seleccione</option> -->
                            </select> 


                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editorial">Part Number</label><br>
                            <input id="part_number" class="form-control" type="text" name="part_number" placeholder="Part Number ..." >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="materia">Marca</label><br>
                            <input id="marca" class="form-control" type="text" name="marca" placeholder="marca ..." >

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad">Cantidad *</label>
                            <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad..." required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editorial">Unidad de Medida</label><br>
                            <input id="medida" class="form-control" type="text" name="medida" placeholder="medida ..." >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="materia">Familia *</label><br>
                            <input id="familia" class="form-control" type="text" name="familia" placeholder="Familia ..." >

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cantidad">Serie </label>
                            <input id="serie" class="form-control" type="text" name="serie" placeholder="Serie..." >
                        </div>
                    </div>


                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="titulo">Condicion *</label>
                            <input type="hidden" id="id" name="id">
                            <select id="condicion" class="form-control condicion" name="condicion" required style="width: 100%;">
                                <option value="OPERATIVO">OPERATIVO</option>
                                <option value="INOPERATIVO">INOPERATIVO</option>
                                <option value="POR REVISAR">POR REVISAR</option>                             
                            </select>
                        </div>
                        </div>

                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="cantidad">Ubicacion :  </label>
                            <input id="ubicacion" class="form-control" type="text" name="ubicacion" placeholder="Ubicacion..." required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" rows="2" placeholder="Descripción..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
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

<div id="nuevoLibro" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="title">Registro Libro</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
         
                <form id="frmLibro" class="row" onsubmit="registrarLibro(event)">
                    <div class="col-md-8">

                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="hidden" id="id" name="id">
                            <input id="titulo" class="form-control" type="text" name="titulo" placeholder="Título del libro" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autor">Autor</label><br>
                            <select id="autor" class="form-control autor" name="autor" required style="width: 100%;">
                            <!--<option id="selectAutor" value="0">Seleccione</option> -->
                            </select> 


                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editorial">Editorial</label><br>
                            <select id="editorial" class="form-control editorial" name="editorial" required style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="materia">Materia</label><br>
                            <select id="materia" class="form-control materia" name="materia" required style="width: 100%;">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_pagina">Cantidad de página</label>
                            <input id="num_pagina" class="form-control" type="number" name="num_pagina" placeholder="Cantidad Página" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="anio_edicion">Año Edición</label>
                            <input id="anio_edicion" class="form-control" type="date" name="anio_edicion" value="<?php echo date("Y-m-d"); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" class="form-control" name="descripcion" rows="2" placeholder="Descripción"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" id="foto_actual" name="foto_actual">
                                    <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fa fa-cloud-upload"></i></label>
                                    <span id="icon-cerrar"></span>
                                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
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
<?php include "Views/Templates/footer.php"; ?>