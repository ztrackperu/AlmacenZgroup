<?php
class Hcategorias extends Controller
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
        $perm = $this->model->verificarPermisos($id_user, "Historial");
        if (!$perm && $id_user != 1) {
            // no tines permiso 
            $this->views->getView($this, "permisos");
            exit;
        }
    }
    public function index()
    {
        $this->views->getView("Historial", "categorias");
    }
    public function listar()
    {
        $data = $this->model->getCategorias();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

}