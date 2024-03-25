<?php
class KardexModel extends Query
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getInsumos()
    {
        $sql = "SELECT id,in_esta,ind_codi,in_arti,part_number,marca FROM data_insumos ";
        $res = $this->selectAll($sql);
        return $res;

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
    public function buscarInsumo($valor)
    {
        $sql = "SELECT id, ind_codi AS text FROM data_insumos WHERE ind_codi LIKE '%" . $valor . "%' LIMIT 20";
        $data = $this->selectAll($sql);
        return $data;
    }

}