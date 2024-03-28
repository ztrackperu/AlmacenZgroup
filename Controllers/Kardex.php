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
    public function infoT($param)
    {
        $data =explode(',', $param);
        //var_dump($data);
        //echo $data[0];

        $consulta = $this->model->infoT($data[0]);
        $cod_clase =$consulta['cod_clase'];
        $consulta1 = $this->model->infoClase($cod_clase);
        $consulta['tipo'] = $consulta1['C_DESITM'];
        echo json_encode($consulta, JSON_UNESCAPED_UNICODE);
        die();

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
        $id = "";
        $codigoInsumo1 = strClean($_POST['codigo_insumo']);
        $data1 = $this->model->consultarCodigo($codigoInsumo1);
        $codigoInsumo = $data1['ind_codi'];
        $nombreInsumo = $data1['in_arti'];
        $partNumber = strClean($_POST['part_number']);
        $marca = strClean($_POST['marca']);
        $cantidad = strClean($_POST['cantidad']);
        $condicion = strClean($_POST['condicion']);
        $descripcion = strClean($_POST['descripcion']);
        $medida = strClean($_POST['medida']);
        $familia = strClean($_POST['familia']);
        $serie = strClean($_POST['serie']);
        $ubicacion = strClean($_POST['ubicacion']);

        //$imagen = strClean($_POST['imagen']);
        $img = $_FILES['imagen'];
        $imagen = $img['name'];
        $usuario_activo = $_SESSION['id_usuario'];
        $fecha = date("YmdHis");
        $tmpName = $img['tmp_name'];

       // $mes =  $codigoInsumo." , ".$nombreInsumo." , ".$partNumber." , ".$marca.",".$cantidad." ,". $condicion." , ".$descripcion.",".$imagen;
        if (empty($codigoInsumo) || empty($nombreInsumo) || empty($cantidad)  ) {
            $msg = array('msg' => 'Todos los campos con * son requeridos', 'icono' => 'warning');
        } else {
            if (!empty($imagen)) {
                //$extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                $extension = pathinfo($imagen, PATHINFO_EXTENSION);
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
                $data = $this->model->insertarInsumo($codigoInsumo, $nombreInsumo, $partNumber, $marca, $cantidad, $condicion, $descripcion, $imgNombre,$usuario_activo,$medida,$familia,$serie,$ubicacion);
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpName, $destino);
                    }
                    // insertar a stock 
                    //funcion de coincidencia 
                    $idS = 0;
                    $stockA = 0;
                    $data1 = $this->model->buscarConcidencia($codigoInsumo,$condicion);
                    if($data1) {
                        //actualizar campo ztock
                        $idS = $data1['id'];
                        $stockA = $data1['stock']+$cantidad;
                        $data2 = $this->model->ActualizarStock($idS,$stockA);
                    }else{
                        // crear nuevo fila en stock
                        $stockA =$cantidad;
                        $data2 = $this->model->insertarStock($codigoInsumo, $nombreInsumo, $partNumber, $marca, $cantidad, $condicion,$usuario_activo,$medida,$familia,$serie);
                    }

                    $msg = array('msg' => 'Movimiento registrado'.' y el stock actual es : '.$stockA, 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Movimiento ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } 
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();

    }

}