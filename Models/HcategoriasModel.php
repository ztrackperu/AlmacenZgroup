<?php
class HcategoriasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verificarPermisos($id_user, $permiso)
    {
        $tiene = false;
        $sql = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
        $existe = $this->select($sql);
        if ($existe != null || $existe != "") {
            $tiene = true;
        }
        return $tiene;
    }
    public function getCategorias()
    {
        // si es 1 
            $sql = "SELECT h.* , u.nombre FROM h_categoria h INNER JOIN usuarios u ON h.user = u.id";
            $res = $this->selectAll($sql);       

        return $res;
    }

}