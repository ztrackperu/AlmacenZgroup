<?php
class Kardex extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo1'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $id_user = $_SESSION['id_usuario'];
        $perm = $this->model->verificarPermisos($id_user, "Kardex");
        if (!$perm && $id_user != 1) {
            $this->views->getView($this, "permisos");
            exit;
        }

        
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function buscarInsumo()
    {
        if (isset($_GET['q'])) {
            $valor = $_GET['q'];
            $data = $this->model->buscarInsumo($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function buscarArticulo()
    {
        if (isset($_GET['q'])) {
            $valor = $_GET['q'];
            $data = $this->model->buscarArticulo($valor);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function registrar()
    {
        $codigoInsumo = strClean($_POST['codigoInsumo']);
        $nombreInsumo = strClean($_POST['nombreInsumo']);
        $categoria = strClean($_POST['categoria']);
        $marcaInsumo = strClean($_POST['marcaInsumo']);
        $almacen = strClean($_POST['almacen']);
        $descripcionInsumo = strClean($_POST['descripcionInsumo']);

        $partNumber1 = strClean($_POST['partNumber1']);
        $partNumber2 = strClean($_POST['partNumber2']);
        $partNumber3 = strClean($_POST['partNumber3']);
        $partNumber4 = strClean($_POST['partNumber4']);

        $rack = strClean($_POST['rack']);
        $anaquel = strClean($_POST['anaquel']);
        $piso = strClean($_POST['piso']);
        $sector = strClean($_POST['sector']);

        //identificacion de usuario que crea o modifica el insumo
        $usuario_activo = $_SESSION['id_usuario'];

        $id = strClean($_POST['id']);
        // temas de la imagen 
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $fecha = date("YmdHis");
        $tmpName = $img['tmp_name'];
        if (empty($codigoInsumo) || empty($nombreInsumo) || empty($categoria) || empty($almacen) ) {
            $msg = array('msg' => 'Todo los campos * son requeridos', 'icono' => 'warning');
        } else {
            if (!empty($name)) {
                //$extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    // creamos un nombre y l edamos la estension jpg
                    $imgNombre = $fecha . ".jpg";
                    // creamos la ruta de destino
                    $destino = "Assets/img/insumos/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "logo.png";
            }
            if ($id == "") {
                $data = $this->model->insertarInsumos($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo);
                if ($data == "ok") {
                    if (!empty($name)) {
                        //registrar la imagen 
                        move_uploaded_file($tmpName, $destino);
                    }
                    // guardar los datos en el historico de insumo
                    $evento="CREADO";
                    //consultar el id que acabamos de crear
                    $id_consulta = $this->model->IdInsumo($nombreInsumo);
                    $id=$id_consulta['id'];
                    // insertamos el evento en tabla historica
                    $data2 = $this->model->h_insumo($id,$codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$evento );
                    $msg = array('msg' => 'Insumo registrado', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Codigo o nombre de insumo  ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $imgDelete = $this->model->editInsumo($id);
                if ($imgDelete['imagen_insumo'] != 'logo.png') {
                    // verificamos si existe si existe el archivo de la imagen 
                    if (file_exists("Assets/img/insumos/" . $imgDelete['imagen_insumo'])) {
                        unlink("Assets/img/insumos/" . $imgDelete['imagen_insumo']);
                    }
                }
                //pedir datos para evitar duplicidad 
                $duplicidad = $this->model->analizarInsumo($codigoInsumo,$nombreInsumo);
                if($id!=$duplicidad['id']){
                    $msg = array('msg' => 'Insumo Duplicado , verifique los datos', 'icono' => 'warning');
                }else{
                    $data = $this->model->actualizarInsumos($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$id);
                    if ($data == "modificado") {
                        if (!empty($name)) {
                            move_uploaded_file($tmpName, $destino);
                        }
                        $evento="MODIFICADO";
                        $data2 = $this->model->h_insumo($id,$codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$evento );
                        $msg = array('msg' => 'Insumo modificado', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                    }

                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

}