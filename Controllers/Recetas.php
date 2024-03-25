
<?php
class Recetas extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo1'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        // verificacion del permiso 
        $perm = $this->model->verificarPermisos($id_user, "Recetas");
        if (!$perm && $id_user != 1) {
            // no tines permiso 
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getRecetas();

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary" type="button" onclick="btnEditarReceta(' . $data[$i]['id'] . ');"><i class="fa fa-pencil-square-o"></i></button>
                <button class="btn btn-danger" type="button" onclick="btnEliminarReceta(' . $data[$i]['id'] . ');"><i class="fa fa-trash-o"></i></button>
                <div/>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Eliminado</span>';
                $data[$i]['acciones'] = '<div>
                <button class="btn btn-success" type="button" onclick="btnReingresarReceta(' . $data[$i]['id'] . ');"><i class="fa fa-reply-all"></i></button>
                <div/>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editReceta($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $codigo_receta = strClean($_POST['codigo_receta']); 
        $nombre_receta = strClean($_POST['nombre_receta']);
        $descripcion_receta = strClean($_POST['descripcion_receta']);
        $usuario_activo = $_SESSION['id_usuario'];
        $id = strClean($_POST['id']);
        if (empty($nombre_receta)) {
            $msg = array('msg' => 'El nombre de Receta es requerido', 'icono' => 'warning');
        } else {
            if ($id == "") {
                //se guarda si id es vacio 
                $data = $this->model->insertarReceta($codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo);
                if ($data == "ok") {
                    // guardar los datos en el historico de receta
                    $evento="CREADO";
                    //consultar el id que acabamos de crear
                    $id_consulta = $this->model->IdReceta($nombre_receta);
                    $id=$id_consulta['id'];
                    // insertamos el evento en tabla historica
                    $data2 = $this->model->h_receta($id,$codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo,$evento );
                    $msg = array('msg' => 'Receta registrada', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Receta ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                // se actualiza si id tiene informacion
                $data = $this->model->actualizarReceta($codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo, $id);
                if ($data == "modificado") {
                    // guardar los datos en el historico de receta}
                    $evento="MODIFICADO";
                    $data2 = $this->model->h_receta($id,$codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo,$evento );
                    $msg = array('msg' => 'Receta modificado', 'icono' => 'success');
                } else if($data==2){
                    $msg = array('msg' => 'ya existe una receta con ese nombre', 'icono' => 'error');

                }
                
                else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    } 
    public function eliminar($id)
    {
        // primero debemos  consultar la informacion con el id que tenemos 
        //para obtenr todos los datos
        $data = $this->model->estadoReceta(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Receta dado de baja', 'icono' => 'success');
        } 
        
        else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar($id)
    {
        $data = $this->model->estadoReceta(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Receta restaurada', 'icono' => 'success');
        } 
        else if($data == 2){
            $msg = array('msg' => 'ya existe una receta con ese nombre', 'icono' => 'error');

        }  
        else {
            $msg = array('msg' => 'Error al restaurar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

        //CARGA MASIVA
        public function registrarExcel()
        {
            // Verificar si la solicitud es un POST y si contiene datos JSON
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
                // Recibir los datos JSON del cuerpo de la solicitud
                $datos_json = file_get_contents('php://input');
    
                // Decodificar los datos JSON a un arreglo asociativo
                $datos = json_decode($datos_json, true);
    
                // Verificar si se han recibido datos válidos
                if ($datos !== null) {
                    // Iterar sobre los datos y guardarlos en la base de datos
                    foreach ($datos as $fila) {
    
                        // Verificar si ya existe una receta con el mismo código o nombre
                        //$existe_codigo = $this->model->existeCodigoReceta($fila['codigo_receta']);
                        //$existe_nombre = $this->model->existeNombreReceta($fila['nombre_receta']);
    /*
                        if ($existe_codigo || $existe_nombre) {
                            $msg[] = array('msg' => 'La receta con código "' . $fila['codigo_receta'] . '" o nombre "' . $fila['nombre_receta'] . '" ya existe y no será registrada', 'icono' => 'warning');
                            continue; // Saltar a la siguiente iteración del bucle
                        }
                        */
                        // Ejemplo de inserción de datos (ajusta según tu esquema de base de datos)
                        $codigo_receta = $fila['codigo_receta'];
                        $nombre_receta = $fila['nombre_receta'];
                        $descripcion_receta = $fila['descripcion'];
                        $usuario_activo = $_SESSION['id_usuario'];
    
                        $data = $this->model->insertarRecetaExcel($codigo_receta, $nombre_receta, $descripcion_receta, $usuario_activo);
                        if ($data == "ok") {
                            // guardar los datos en el historico de receta
                            $evento = "CREADO";
                            //consultar el id que acabamos de crear
                            $id_consulta = $this->model->IdReceta($nombre_receta);
                            $id = $id_consulta['id'];
                            // insertamos el evento en tabla historica
                            $data2 = $this->model->h_receta($id, $codigo_receta, $nombre_receta, $descripcion_receta, $usuario_activo, $evento);
                            $msg = array('msg' => 'Recetas registrada', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'Las Recetas  ya existe', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                        }
                    }
                } else {
                    $msg = array('msg' => 'No se recibieron datos válidos', 'icono' => 'error');
                }
            } else {
                // Si no se recibió una solicitud POST con datos JSON, enviar una respuesta de error al cliente
                $msg = array('msg' => 'Método no permitido', 'icono' => 'error');
            }
    
            // Devolver el mensaje como una respuesta JSON
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }

}

?>