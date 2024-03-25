<?php
class CategoriasModel extends Query
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
        if($_SESSION['id_usuario']==1){
            $sql = "SELECT * FROM categoria ";
            $res = $this->selectAll($sql);

        }else{
            $sql = "SELECT * FROM categoria WHERE estado = 1 ";
            $res = $this->selectAll($sql);
        }

        return $res;
    }
    public function editCategoria($id)
    {
        $sql = "SELECT * FROM categoria WHERE id = $id";
        $res = $this->select($sql);
        return $res;
    }

    public function insertarCategoria($nombre_categoria,$descripcion_categoria,$usuario_activo)
    {
        $verificar = "SELECT * FROM categoria WHERE nombre_categoria = '$nombre_categoria' AND estado=1";
        $existe = $this->select($verificar);
        // si no existe 
        if (empty($existe)) {
            $query = "INSERT INTO categoria(nombre_categoria,descripcion,user_c,user_m) VALUES (?,?,?,?)";
            $datos = array($nombre_categoria,$descripcion_categoria,$usuario_activo,$usuario_activo);
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

    public function actualizarCategoria($nombre_categoria,$descripcion_categoria,$usuario_activo, $id)
    {
        $fecha =date("Y-m-d H:i:s");  
        $verificar = "SELECT * FROM categoria WHERE nombre_categoria = '$nombre_categoria' AND estado=1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
        $query = "UPDATE categoria SET  nombre_categoria = ? ,descripcion = ?, updated_at = ?  ,user_m = ? WHERE id = ?";
        $datos = array($nombre_categoria,$descripcion_categoria,$fecha,$usuario_activo, $id);
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

    public function h_categoria($id,$nombre_categoria,$descripcion_categoria,$usuario_activo,$evento)
    {
        $query = "INSERT INTO h_categoria(categoria_id,nombre_categoria,descripcion,user,evento )VALUES (?,?,?,?,?)";
        $datos = array($id,$nombre_categoria,$descripcion_categoria,$usuario_activo,$evento);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function estadoCategoria($estado, $id)
    {
        // primero seleccionamos los datos 
        $tomar_datos = "SELECT * FROM categoria WHERE id = '$id' ";
        $data_categoria = $this->select($tomar_datos);
        $nombre_categoria =$data_categoria['nombre_categoria'];
        $descripcion =$data_categoria['descripcion'];
        $fecha =date("Y-m-d H:i:s");  
        $user = $_SESSION['id_usuario'];
        // validamos el evento con el estado
        if($estado==0){
            $evento ="ELIMINADO";
            $query = "UPDATE categoria SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
            $datos = array($fecha,$user,$estado,$id);
            $data = $this->save($query, $datos);

        }else{
            $evento ="RESTAURADO";
            // debe haber paso previo de validacion para no restaurar duplicados 
            $validarDuplicado = "SELECT * FROM categoria WHERE nombre_categoria = '$nombre_categoria' AND estado=1";
            $existe = $this->select($validarDuplicado);
            if (empty($existe)) {
                $query = "UPDATE categoria SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
                $datos = array($fecha,$user,$estado,$id);
                $data = $this->save($query, $datos);
            }else{
                $data =2;
            }


        }
        // aqui actualizamos los datos en estado 0 para elimminar logicamente la receta en vista 

        // aqui guardamos el evento en el historico
        $query_h = "INSERT INTO h_categoria(categoria_id,nombre_categoria,descripcion,user,evento,estado) VALUES (?,?,?,?,?,?)";
        $datos_h = array($id,$nombre_categoria,$descripcion,$user,$evento,$estado);
        $data_h = $this->save($query_h, $datos_h);

        return $data;
    }

    public function IdCategoria($nombre_categoria)
    {
        $sql = "SELECT id FROM categoria WHERE nombre_categoria = '$nombre_categoria' AND estado=1";
        $res = $this->select($sql);
        return $res;
    }

}

?>