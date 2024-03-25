<?php include "Views/Templates/header.php"; ?>
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Historial de Insumos</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-light mt-4" id="tblHinsumos"> 
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Almacen</th>
                                <th>Part Number 1</th>
                                <th>Part Number 2</th>
                                <th>Part Number 3</th>
                                <th>Part Number 4</th>
                                <th>Rack</th>
                                <th>Anaquel</th>
                                <th>Piso</th>
                                <th>Sector</th>
                                <th>Fecha</th>                               
                                <th>Usuario</th>
                                <th>Evento</th>
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
<?php include "Views/Templates/footer.php"; ?>