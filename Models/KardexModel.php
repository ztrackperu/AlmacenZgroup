<?php
class KardexModel extends Query
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getInsumos()
    {
        $sql = "SELECT id,in_esta,ind_codi,in_arti,part_number,marca,in_uvta,cod_clase FROM data_insumos ";
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
        $sql = "SELECT id, ind_codi  AS text FROM data_insumos WHERE ind_codi LIKE '%" . $valor . "%' LIMIT 20";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function buscarArticulo($valor)
    {
        $sql = "SELECT id, in_arti AS text FROM data_insumos WHERE in_arti LIKE '%" . $valor . "%' LIMIT 20";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function infoT($valor)
    {
        $sql = "SELECT * FROM data_insumos WHERE id=" . $valor . "";
        $data = $this->select($sql);
        return $data;
    }
    public function infoClase($valor)
    {
        $sql = "SELECT * FROM dtable WHERE C_NUMITM=" . $valor . "";
        $data = $this->select($sql);
        return $data;
    }
    public function consultarCodigo($valor)
    {
        $sql = "SELECT in_arti,ind_codi FROM data_insumos WHERE id=" . $valor . "";
        $data = $this->select($sql);
        return $data;
    }
    public function insertarInsumo($codigoInsumo, $nombreInsumo, $partNumber, $marca, $cantidad, $condicion, $descripcion, $imgNombre,$usuario_activo)
    {

            $query = "INSERT INTO movimientos(codigo, articulo, partNumber, marca, cantidad, condicion, extra1, imagen, user_c,user_m) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $datos = array($codigoInsumo, $nombreInsumo, $partNumber, $marca, $cantidad, $condicion, $descripcion, $imgNombre,$usuario_activo,$usuario_activo) ;
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        
        return $res;
    }

}