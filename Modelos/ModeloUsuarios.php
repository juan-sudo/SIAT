<?php
namespace Modelos;
use Conect\Conexion;
use PDO;

class ModeloUsuarios {

    // MOSTRAR USUARIOS
    public static function mdlMostrarUsuarios($tabla, $item, $valor) {
        
        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT  u.*,a.Nombre_Area as area FROM $tabla  u 
            INNER JOIN area a on a.Id_Area=u.Id_Area WHERE $item = :$item")  ;
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
    
            $stmt->execute();
            return $stmt->fetch();

        }else{
            $stmt = Conexion::conectar()->prepare("SELECT u.*,a.Nombre_Area as area FROM $tabla u INNER JOIN area a on a.Id_Area=u.Id_Area ");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();

        }
       
        $stmt = null;
    }
     // MOSTRAR USUARIOS
     public static function mdlMostrarUsuarios_seleccionado($idusuario) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios  u INNER JOIN area a on a.Id_Area=u.Id_Area WHERE id=$idusuario");
            $stmt->execute();
            return $stmt->fetch();
            $stmt = null;
    }

    // REGISTRO DE USUARIOS
    public static function mdlNuevoUsuario($tabla, $datos){

        $datos['nombre'] = strtoupper($datos['nombre']);
        $datos['usuario'] = strtoupper($datos['usuario']);
        $datos['email'] = strtoupper($datos['email']);
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, dni, email, foto, id_empresa,Id_Area) 
                                               VALUES (:nombre, :usuario, :password, :perfil, :dni, :email, :foto, :id_empresa,:id_area)");
        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos['dni'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos['id_sucursal'], PDO::PARAM_INT);
        $stmt->bindParam(":id_area", $datos['id_area'], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt = null;
    }
    //EDITAR USUARIOS
    public static function mdlEditarUsuario($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, 
        password = :password, perfil= :perfil, dni = :dni, email = :email, foto = :foto, id_empresa = :id_empresa, id_area = :id_area  
        WHERE usuario = :usuario");

        $stmt->bindParam(":nombre", $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos['password'], PDO::PARAM_STR);
        $stmt->bindParam(":perfil", $datos['perfil'], PDO::PARAM_STR);
        $stmt->bindParam(":dni", $datos['dni'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos['email'], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos['foto'], PDO::PARAM_STR);
        $stmt->bindParam(":id_empresa", $datos['id_sucursal'], PDO::PARAM_INT);
        $stmt->bindParam(":usuario", $datos['usuario'], PDO::PARAM_STR);
        $stmt->bindParam(":id_area", $datos['id_area_e'], PDO::PARAM_INT);

        if($stmt->execute()){

            return 'ok';
        }else{
            return 'error';
        }
        $stmt = null;
    }

    // ACTUALIZAR USUARIO ESTADO
    public static function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt = null;
    }

    // BORRAR USUARIO
    public static function mdlBorrarUsuario($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE id=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
        $stmt = null;
    }

     // Mostrar Menu
     public static function mdlMostrar_menu($iduser){

        $stmt = Conexion::conectar()->prepare("SELECT                  s.Id_Subpagina as id_subpagina,
        s.Nombre_Subpagina as nombre_subpagina,
        s.Ruta_SubPagina as ruta_subpagina,
        p.Id_Pagina as id_pagina,
        p.Nombre_Pagina as nombre_pagina,
        p.Ruta_Pagina as ruta_pagina
    FROM
        usuario_subpagina up
    LEFT JOIN subpagina s ON up.Id_SubPagina = s.Id_SubPagina
    LEFT JOIN pagina p ON s.Id_Pagina = p.Id_Pagina
   
    WHERE
        up.id_usuario =$iduser;");
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
    // Mostrar subMenu
    public static function mdlMostrar_submenu($iduser){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM usuario_subpagina us
        JOIN subpagina s ON us.Id_Subpagina = s.Id_Subpagina
        WHERE us.Id_Usuario = $iduser");
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
     // Mostrar subMenu lista
     public static function mdlMostrar_submenu_lista($idmenu){
        $stmt = Conexion::conectar()->prepare("SELECT Nombre_SubPagina, Ruta_SubPagina FROM subpagina WHERE Id_Pagina =$idmenu");
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
     // Mostrar paginas para dar permiso
     public static function mdlMostrar_Pagina($datos){
        $idusuario=$datos['idusuario'];
        $stmt = Conexion::conectar()->prepare("SELECT 
                                                p.Id_Pagina, 
                                                p.Nombre_Pagina, 
                                                p.Ruta_Pagina, 
                                                s.Id_SubPagina, 
                                                s.Nombre_SubPagina, 
                                                s.Ruta_SubPagina, 
                                                IF(COUNT(us.Id_Usuario_SubPagina) > 0, 1, 0) AS TienePermiso 
                                            FROM 
                                                pagina p 
                                            LEFT JOIN 
                                                subpagina s ON p.Id_Pagina = s.Id_Pagina 
                                            LEFT JOIN 
                                                usuario_subpagina us ON s.Id_SubPagina = us.Id_SubPagina AND us.Id_Usuario = $idusuario
                                            GROUP BY
                                                p.Id_Pagina, 
                                                s.Id_SubPagina; ");
        $stmt->execute();
        return $stmt->fetchall();
        $stmt = null;
    }
    // Mostrar paginas para dar permiso
    public static function mdlPermiso_Pagina($datos){
        $idpaginaArray = json_decode($datos['idpagina'], true);
        $idsubpaginaArray = json_decode($datos['idsubpagina'], true);
        $idusuario = $datos['idusuario'];
        $stmtExistencia = Conexion::conectar()->prepare("DELETE FROM usuario_pagina 
                                                       WHERE Id_Usuario = :idusuario");
                $stmtExistencia->bindParam(":idusuario", $idusuario);

        // Verificar si $idpaginaArray es un array
        if (is_array($idpaginaArray) and $stmtExistencia->execute()) {
            // Bucle para insertar cada valor del array
            $stmtExistencia = Conexion::conectar()->prepare("DELETE FROM usuario_subpagina 
                                                       WHERE Id_Usuario = :idusuario");
            $stmtExistencia->bindParam(":idusuario", $idusuario);
            $stmtExistencia->execute();
            foreach ($idpaginaArray as $idpagina) {
                // Verificar si la entrada ya existe antes de inserta
                    // Insertar solo si no existe la entrada
                    $stmtInsertar = Conexion::conectar()->prepare("INSERT INTO usuario_pagina (Id_Usuario, Id_Pagina) VALUES (:idusuario, :idpagina)");
                    $stmtInsertar->bindParam(":idusuario", $idusuario);
                    $stmtInsertar->bindParam(":idpagina", $idpagina);
                    $stmtInsertar->execute();   
            }
            foreach ($idsubpaginaArray as $idsubpagina) {
                // Verificar si la entrada ya existe antes de inserta
                    // Insertar solo si no existe la entrada
                    $stmtInsertar = Conexion::conectar()->prepare("INSERT INTO usuario_subpagina (Id_Usuario, Id_SubPagina) 
                                                                   VALUES (:idusuario, :idsubpagina)");
                    $stmtInsertar->bindParam(":idusuario", $idusuario);
                    $stmtInsertar->bindParam(":idsubpagina", $idsubpagina);
                    $stmtInsertar->execute();   
            }

            return "ok";
        } else {
            return "Error: idpagina no es un array, Comunicarce con el administrador del sistema";
        }

        
    }
    // Mostrar al usuario para darle permiso
    public static function mdlUsuario_Permiso($datos){
        $idusuario=$datos['idusuario'];
        $stmt = Conexion::conectar()->prepare("SELECT 
                                               * from usuarios where id=$idusuario;");
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }
     // Mostrar el perfil del usuario
     public static function mdlPerfil_Usuario($idusuario){
        $stmt = Conexion::conectar()->prepare("SELECT 
                                               perfil from usuarios where id=$idusuario;");
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }
}