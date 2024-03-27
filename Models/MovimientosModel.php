<?php
class MovimientosModel extends Query
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
    public function getMovimientos()
    {
        // si es 1 
        if($_SESSION['id_usuario']==1){
            $sql =  "SELECT m.* , u.usuario FROM movimientos AS m INNER JOIN usuarios AS u ON m.user_c = u.id";
            $res = $this->selectAll($sql);

        }else{
            $sql = "SELECT m.* , u.usuario FROM movimientos AS m INNER JOIN usuarios AS u ON m.user_c = u.id where m.estado = 1 ";
            $res = $this->selectAll($sql);
        }

        return $res;
    }
    public function editMovimiento($id)
    {
        $sql = "SELECT id, codigo, descripcion, partNumber, serie, marca, medida, familia, condicion, cantidad, extra1, user_c, created_at, estado FROM movimientos WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarReceta($codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo)
    {
        $verificar = "SELECT * FROM receta WHERE nombre_receta = '$nombre_receta' AND estado=1";
        $existe = $this->select($verificar);
        // si no existe 
        if (empty($existe)) {
            $query = "INSERT INTO receta(codigo_receta,nombre_receta,descripcion,user_c,user_m) VALUES (?,?,?,?,?)";
            $datos = array($codigo_receta,$nombre_receta,$descripcion_receta,$usuario_activo,$usuario_activo);
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            // si existe informacion 
            $res = "existe";
        }
        return $res;
    }

    public function actualizarMovimiento($codigo,$articulo,$marca,$condicion,$cantidad,$imagen,$usuario_activo, $id)
    {
        $fecha =date("Y-m-d H:i:s");  
        $verificar = "SELECT * FROM movimientos WHERE codigo = '$codigo' AND estado=1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
        $query = "UPDATE movimientos SET articulo = ? , marca = ? ,condicion = ?, cantidad = ?,imagen = ?,updated_at = ?  ,user_m = ? WHERE id = ?";
        $datos = array($codigo,$articulo,$marca,$condicion,$cantidad,$imagen,$fecha,$usuario_activo, $id);
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

    public function estadoMovimiento($estado, $id)
    {
        // primero seleccionamos los datos 
        $tomar_datos = "SELECT * FROM movimientos WHERE id = '$id' ";
        $data_movimiento = $this->select($tomar_datos);
        $codigo =$data_movimiento['codigo'];
        $articulo =$data_movimiento['articulo'];
        $marca = $data_movimiento['marca'];
        $condicion = $data_movimiento['condicion'];
        $cantidad = $data_movimiento['cantidad'];
        $imagen = $data_movimiento['imagen'];
        $fecha =date("Y-m-d H:i:s");  
        $user = $_SESSION['id_usuario'];
        // validamos el evento con el estado
        if($estado==0){
            $evento ="ELIMINADO";
            $query = "UPDATE movimientos SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
            $datos = array($fecha,$user,$estado,$id);
            $data = $this->save($query, $datos);

        }else{
            $evento ="RESTAURADO";
            // debe haber paso previo de validacion para no restaurar duplicados 
            $validarDuplicado = "SELECT * FROM movimientos WHERE codigo = '$codigo' AND estado=1";
            $existe = $this->select($validarDuplicado);
            if (empty($existe)) {
                $query = "UPDATE movimientos SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
                $datos = array($fecha,$user,$estado,$id);
                $data = $this->save($query, $datos);
            }else{
                $data =2;
            }


        }
        // aqui actualizamos los datos en estado 0 para elimminar logicamente la receta en vista 
        /*
        // aqui guardamos el evento en el historico
        $query_h = "INSERT INTO h_receta(receta_id,codigo_receta,nombre_receta,descripcion,user,evento,estado) VALUES (?,?,?,?,?,?,?)";
        $datos_h = array($id,$codigo_receta,$nombre_receta,$descripcion,$user,$evento,$estado);
        $data_h = $this->save($query_h, $datos_h);*/

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