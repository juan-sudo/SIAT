<?php
namespace Modelos;
use Conect\Conexion;
use PDO;

class ModeloFormulaimpuesto {

    // MOSTRAR USUARIOS
    public static function mdlMostrarFormulaimpuesto($tabla, $item, $valor) {
        
        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
    
            $stmt->execute();
            return $stmt->fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by Id_Anio");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();
        }
    
        $stmt = null;
    }

     public static function mdlMostrarData($tabla) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            //$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
            $stmt->execute();
            return $stmt->fetchall();

     
        $stmt = null;
    }

    // REGISTRO DE USUARIOS
    public static function mdlNuevoFormulaimpuesto($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(Codigo_Calculo,Anio,UIT,Base_imponible,Base,FormulaBase,PorcBase,Autovaluo) VALUES (:codigo,:anio,:uit, :baseimponible,:base,:formulabase,:porcentaje,:autovaluo)");
        $stmt->bindParam(":codigo", $datos['codigo']);
        $stmt->bindParam(":anio", $datos['anio']);
        $stmt->bindParam(":uit", $datos['uit']);
        $stmt->bindParam(":baseimponible", $datos['baseimponible']);
        $stmt->bindParam(":base", $datos['base']);
        $stmt->bindParam(":formulabase", $datos['formulabase']);
        $stmt->bindParam(":porcentaje", $datos['porcentaje']);
        $stmt->bindParam(":autovaluo", $datos['autovaluo']);
        if($stmt->execute()){

            return "ok";

        }else{

            return "error";
        }
      
        $stmt = null;
    }
    //EDITAR USUARIOS
    public static function mdlEditarFormulaimpuesto($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET Codigo_Calculo=:codigo,Anio=:anio, UIT=:uit,Base_imponible=:baseimponible,Base=:base,FormulaBase=:formulabase,PorcBase=:porcentaje,Autovaluo=:autovaluo  WHERE Id_Formula_Impuesto= :id");
        $stmt->bindParam(":codigo", $datos['codigo']); 
        $stmt->bindParam(":anio", $datos['anio'],PDO::PARAM_STR);
        $stmt->bindParam(":uit", $datos['uit']);
        $stmt->bindParam(":baseimponible", $datos['baseimponible']);
        $stmt->bindParam(":base", $datos['base'],PDO::PARAM_STR);
        $stmt->bindParam(":formulabase", $datos['formulabase']);
        $stmt->bindParam(":porcentaje", $datos['porcentaje']);
        $stmt->bindParam(":autovaluo", $datos['autovaluo']);
        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        if($stmt->execute()){

            return 'ok';
        }else{
            return 'error';
        }
     
        $stmt = null;
    }

    // ACTUALIZAR USUARIO ESTADO
    public static function mdlActualizarEstadoEspecievalorada($tabla, $item1, $valor1, $item2, $valor2){
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
    public static function mdlBorrarFormulaimpuesto($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla  WHERE Id_Formula_Impuesto=:id");
        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt->execute()){
            return 'ok';
        }else{
            return 'error';
        }
       
        $stmt = null;
    }

     public static function ejecutar_consulta_simple($consulta){
        $sql=Conexion::conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
        }  
}