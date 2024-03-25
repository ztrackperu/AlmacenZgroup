<?php
class InsumosModel extends Query
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function getInsumos()
    {
        // hay 2 versiones 
       if($_SESSION['id_usuario']==1){
        $sql = "SELECT i.*, c.nombre_categoria, a.nombre_almacen FROM insumo i INNER JOIN categoria c ON i.categoria_id = c.id INNER JOIN almacen a ON i.almacen_id = a.id ";
        $res = $this->selectAll($sql);
        }else{
            $sql = "SELECT i.*, c.nombre_categoria, a.nombre_almacen FROM insumo i INNER JOIN categoria c ON i.categoria_id = c.id INNER JOIN almacen a ON i.almacen_id = a.id WHERE i.estado=1";
            $res = $this->selectAll($sql);
        }
        return $res;
    }
    public function insertarInsumos($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre, $usuario_activo)
    { 
        $verificar = "SELECT * FROM insumo WHERE codigo_insumo = '$codigoInsumo' OR nombre_insumo = '$nombreInsumo' ";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $query = "INSERT INTO insumo(codigo_insumo, nombre_insumo, categoria_id, marca, almacen_id, descripcion, part_number_1, part_number_2, part_number_3,part_number_4,rack, anaquel, piso,sector, imagen_insumo,user_c) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $datos = array($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo);
            $data = $this->save($query, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }
    public function editInsumo($id)
    {
        //$sql = "SELECT l.* , a.autor AS textAutor , e.editorial  AS textEditorial , m.materia AS textMateria FROM libro l INNER JOIN autor a  ON l.id_autor = a.id  INNER JOIN editorial e ON l.id_editorial = e.id INNER JOIN materia m ON l.id_materia = m.id WHERE l.id = $id";
        $sql = "SELECT i.*, c.nombre_categoria AS textCategoria, a.nombre_almacen AS textAlmacen FROM insumo i INNER JOIN categoria c ON i.categoria_id = c.id INNER JOIN almacen a ON i.almacen_id = a.id WHERE i.id = $id";
        $res = $this->select($sql);
        return $res;
    }
    public function analizarInsumo($codigoInsumo,$nombreInsumo)
    {
        $sql = "SELECT id from insumo WHERE (codigo_insumo='$codigoInsumo' OR nombre_insumo='$nombreInsumo' ) AND estado=1" ; 
        $res = $this->select($sql);
        return $res;
        //return 1;
    }
    /*
    public function analizarInsumoC($codigoInsumo)
    {
        $sql = "SELECT id from insumo WHERE codigo_insumo='$codigoInsumo' AND estado=1" ; 
        $res = $this->select($sql);
        return $res;
        //return 1;
    }
    public function analizarInsumoN($nombreInsumo)
    {
        $sql = "SELECT id from insumo WHERE  nombre_insumo='$nombreInsumo' AND estado=1" ; 
        $res = $this->select($sql);
        return $res;
        //return 1;
    }
 */

    public function actualizarInsumos($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$id)
    {
        $fecha =date("Y-m-d H:i:s");  
        $query = "UPDATE insumo SET codigo_insumo = ?, nombre_insumo=?, categoria_id=?,marca=?,  almacen_id=? ,descripcion=?, part_number_1=?, part_number_2=?, part_number_3=?, part_number_4=? , rack=? , anaquel=?, piso=?, sector=?, imagen_insumo=?,user_m=? ,updated_at=? WHERE id = ?";
        $datos = array($codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$fecha,$id);
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function estadoInsumo($estado, $id)
    {
        // primero seleccionamos los datos 
        $tomar_datos = "SELECT * FROM insumo WHERE id = '$id' ";
        $data_insumo = $this->select($tomar_datos);
        $codigo_insumo =$data_insumo['codigo_insumo'];
        $nombre_insumo =$data_insumo['nombre_insumo'];
        $categoria_id =$data_insumo['categoria_id'];
        $descripcion =$data_insumo['descripcion'];
        $part_number_1 =$data_insumo['part_number_1'];
        $part_number_2 =$data_insumo['part_number_2'];
        $part_number_3 =$data_insumo['part_number_3'];
        $part_number_4 =$data_insumo['part_number_4'];
        $marca =$data_insumo['marca'];
        $almacen_id =$data_insumo['almacen_id'];
        $rack =$data_insumo['descripcion'];
        $anaquel =$data_insumo['descripcion'];
        $piso =$data_insumo['descripcion'];
        $sector =$data_insumo['descripcion'];
        $imagen_insumo =$data_insumo['imagen_insumo'];

        $fecha =date("Y-m-d H:i:s");  
        $user = $_SESSION['id_usuario'];
        // validamos el evento con el estado
        if($estado==0){
            $evento ="ELIMINADO";
            $query = "UPDATE insumo SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
            $datos = array($fecha,$user,$estado,$id);
            $data = $this->save($query, $datos);
        }else{
            $evento ="RESTAURADO";
            // debe haber paso previo de validacion para no restaurar duplicados 
            $validarDuplicado = "SELECT * FROM insumo WHERE (nombre_insumo = '$nombre_insumo' OR codigo_insumo='$codigo_insumo' ) AND estado=1";
            $existe = $this->select($validarDuplicado);
            if (empty($existe)) {
                $query = "UPDATE insumo SET  updated_at = ?  ,user_m = ? ,estado = ? WHERE id = ?";
                $datos = array($fecha,$user,$estado,$id);
                $data = $this->save($query, $datos);
            }else{
                $data =2;
            }  
        }
        // aqui actualizamos los datos en estado 0 para elimminar logicamente la receta en vista 
        // aqui guardamos el evento en el historico
        $query_h = "INSERT INTO h_insumo(insumo_id,codigo_insumo, nombre_insumo, categoria_id, marca, almacen_id, descripcion, part_number_1, part_number_2, part_number_3,part_number_4,rack, anaquel, piso,sector, imagen_insumo,user,evento,estado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $datos_h = array($id,$codigo_insumo, $nombre_insumo, $categoria_id, $marca, $almacen_id, $descripcion,$part_number_1,$part_number_2,$part_number_3,$part_number_4, $rack, $anaquel, $piso, $sector , $imagen_insumo,$user,$evento,$estado );
        $data_h = $this->save($query_h, $datos_h);       
        return $data;
    }
    public function buscarLibro($valor)
    {
        $sql = "SELECT id, titulo AS text FROM libro WHERE titulo LIKE '%" . $valor . "%' AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
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
    public function buscarCategoria($valor)
    {
        $sql = "SELECT id, nombre_categoria AS text FROM categoria WHERE nombre_categoria LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function buscaAlmacen($valor)
    {
        $sql = "SELECT id, nombre_almacen AS text FROM almacen WHERE nombre_almacen LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function buscaInsumo($valor)
    {
        $sql = "SELECT id, nombre_insumo AS text FROM insumo WHERE nombre_insumo LIKE '%" . $valor . "%'  AND estado = 1 LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function IdInsumo($nombreInsumo)
    {
        $sql = "SELECT id FROM insumo WHERE nombre_insumo = '$nombreInsumo' AND estado=1";
        $res = $this->select($sql);
        return $res;
    }
    public function h_insumo($id,$codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$evento )
    {
        $query = "INSERT INTO h_insumo(insumo_id,codigo_insumo, nombre_insumo, categoria_id, marca, almacen_id, descripcion, part_number_1, part_number_2, part_number_3,part_number_4,rack, anaquel, piso,sector, imagen_insumo,user,evento) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $datos = array($id,$codigoInsumo, $nombreInsumo, $categoria, $marcaInsumo, $almacen, $descripcionInsumo,$partNumber1,$partNumber2,$partNumber3,$partNumber4, $rack, $anaquel, $piso, $sector , $imgNombre,$usuario_activo,$evento );
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function insertarRecetaExcel($codigo_insumo, $nombre_insumo, $descripcion_receta, $usuario_activo)
    {
        // Verificar si ya existe una receta con el mismo nombre y código
        //$existe = $this->verificarRecetaExistente($codigo_receta, $nombre_receta);
        // Si no existe una receta con los mismos detalles, proceder con la inserción
        $existe=false;
        if (!$existe) {
            $imagen_insumo="logo.png";
            $insertQuery = "INSERT INTO insumo (codigo_insumo, nombre_insumo, descripcion,imagen_insumo, user_c, user_m) VALUES (?,?, ?, ?, ?, ?)";
            $datos = array($codigo_insumo, $nombre_insumo, $descripcion_receta,$imagen_insumo, $usuario_activo, $usuario_activo);
            $insertResult = $this->save($insertQuery, $datos);
            return "ok";
    
        } else {
            // Si la receta ya existe, devolver algún tipo de indicador
            return "existe";
        }
    }

    public function h_insumo1($id,$codigoInsumo, $nombreInsumo, $descripcion_receta, $usuario_activo,$evento )
    {
        $imagen_insumo="logo.png";
        $query = "INSERT INTO h_insumo(insumo_id,codigo_insumo, nombre_insumo,descripcion, imagen_insumo,user,evento) VALUES (?,?,?,?,?,?,?)";
        $datos = array($id,$codigoInsumo, $nombreInsumo, $descripcion_receta, $imagen_insumo,$usuario_activo,$evento );
        $data = $this->save($query, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
}
