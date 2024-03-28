<?php
class StockModel extends Query
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
    public function getStock()
    {
        // si es 1 
        if($_SESSION['id_usuario']==1){
            $sql = "SELECT id, codigo, articulo, partNumber, serie, marca, medida, familia, condicion, stock, estado FROM stock";
            $res = $this->selectAll($sql);

        }else{
            $sql = "SELECT * FROM stock WHERE estado = 1 ";
            $res = $this->selectAll($sql);
        }

        return $res;
    }
    public function editReceta($id)
    {
        $sql = "SELECT * FROM receta WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function ultimoCodigo()
    {
        $sql = "SELECT id  FROM data_insumos order by id desc limit 1";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarArticulo($codigo,$descripcion_articulo,$usuario_activo){
        // pedir ultimo 

            $query = "INSERT INTO data_insumos(ind_codi ,in_arti,IN_OPER,cod_clase) VALUES (?,?,?,?)";
            $datos = array($codigo,$descripcion_articulo,$usuario_activo,"009");
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        
        return $res;
    }

    public function actualizarReceta($codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo, $id)
    {
        $fecha =date("Y-m-d H:i:s");  
        $verificar = "SELECT * FROM receta WHERE nombre_receta = '$nombre_receta' AND estado=1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
        $query = "UPDATE receta SET codigo_receta = ? , nombre_receta = ? ,descripcion = ?, updated_at = ?  ,user_m = ? WHERE id = ?";
        $datos = array($codigo_receta,$nombre_receta,$descripcion_receta,$fecha,$usuario_activo, $id);
        $data = $this->save($query, $datos);
        }else{
            $data=2;
        }
        if ($data == 1) {
            $res = "modificado";
        } else if($data == 2){
            $res =2 ;
        }
        
        else {
            $res = "error";
        }
        return $res;
    }
    // guardar en el historial 

    public function h_receta($id,$codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo,$evento)
    {
        $query = "INSERT INTO h_receta(receta_id,codigo_receta,nombre_receta,descripcion,user,evento) VALUES (?,?,?,?,?,?)";
        $datos = array($id,$codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo,$evento);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function estadoReceta($estado, $id)
    {
        // primero seleccionamos los datos 
        $tomar_datos = "SELECT * FROM receta WHERE id = '$id' ";
        $data_receta = $this->select($tomar_datos);
        $codigo_receta =$data_receta['codigo_receta'];
        $nombre_receta =$data_receta['nombre_receta'];
        $descripcion =$data_receta['descripcion'];
        $fecha =date("Y-m-d H:i:s");  
        $user = $_SESSION['id_usuario'];
        // validamos el evento con el estado
        if($estado==0){
            $evento ="ELIMINADO";
            $query = "UPDATE receta SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
            $datos = array($fecha,$user,$estado,$id);
            $data = $this->save($query, $datos);

        }else{
            $evento ="RESTAURADO";
            // debe haber paso previo de validacion para no restaurar duplicados 
            $validarDuplicado = "SELECT * FROM receta WHERE nombre_receta = '$nombre_receta' AND estado=1";
            $existe = $this->select($validarDuplicado);
            if (empty($existe)) {
                $query = "UPDATE receta SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
                $datos = array($fecha,$user,$estado,$id);
                $data = $this->save($query, $datos);
            }else{
                $data =2;
            }


        }
        // aqui actualizamos los datos en estado 0 para elimminar logicamente la receta en vista 

        // aqui guardamos el evento en el historico
        $query_h = "INSERT INTO h_receta(receta_id,codigo_receta,nombre_receta,descripcion,user,evento,estado) VALUES (?,?,?,?,?,?,?)";
        $datos_h = array($id,$codigo_receta,$nombre_receta,$descripcion,$user,$evento,$estado);
        $data_h = $this->save($query_h, $datos_h);

        return $data;
    }

    public function IdReceta($nombre_receta)
    {
        $sql = "SELECT id FROM receta WHERE nombre_receta = '$nombre_receta' AND estado=1";
        $res = $this->select($sql);
        return $res;
    }
    public function insertarRecetaExcel($codigo_receta, $nombre_receta, $descripcion_receta, $usuario_activo)
    {
        // Verificar si ya existe una receta con el mismo nombre y código
        //$existe = $this->verificarRecetaExistente($codigo_receta, $nombre_receta);
        // Si no existe una receta con los mismos detalles, proceder con la inserción
        $existe=false;
        if (!$existe) {
            $insertQuery = "INSERT INTO receta (codigo_receta, nombre_receta, descripcion, user_c, user_m) VALUES (?, ?, ?, ?, ?)";
            $datos = array($codigo_receta, $nombre_receta, $descripcion_receta, $usuario_activo, $usuario_activo);
            $insertResult = $this->save($insertQuery, $datos);
            return "ok";
    
        } else {
            // Si la receta ya existe, devolver algún tipo de indicador
            return "existe";
        }
    }
    public function verificarRecetaExistente($codigo_receta, $nombre_receta)
    {
        // Verificar si ya existe una receta con el mismo nombre y código
        $query = "SELECT COUNT(*) AS count FROM receta WHERE nombre_receta = ? AND codigo_receta = ?";
        $result = $this->select($query, array($nombre_receta, $codigo_receta));
        return $result['count'] > 0;
    }

}

?>