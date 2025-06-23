<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloNegocio
{

    public static function mdlRegistrarNegocio($datos)
    {
       // var_dump($datos);
      
             try {

            // Inicialización de las variables que vamos a usar en bindParam
            $N_Licencia = $datos['N_Licencia'];
            $N_Trabajadores = $datos['N_Trabajadores'];
            $N_Mesas = $datos['N_Mesas'];
            $Area_negocio = $datos['Area_negocio'];
            $Tenencia_Negocio = $datos['Tenencia_Negocio'];
            $Personeria = $datos['Personeria'];
            $Tipo_personeria = $datos['Tipo_personeria'];
            $N_Camas = $datos['N_Camas'];
            $N_Cuartos = $datos['N_Cuartos'];
            $Razon_Social = $datos['Razon_Social'];
            $N_Ruc = $datos['N_Ruc'];
            $N_Bano = $datos['N_Bano']; // Usando la clave correcta en el array
            $Id_Giro_Establecimiento = $datos['Id_Giro_Establecimiento'];
            $Id_Predio = $datos['Id_Predio'];
            $T_Agua_Negocio = $datos['T_Agua_Negocio'];
            $T_Itse = $datos['T_Itse'];
            $Vencimiento_Itse = $datos['Vencimiento_Itse'];

            // Consulta SQL
            $stmt = Conexion::conectar()->prepare(
                "INSERT INTO negocio 
                            (N_Licencia, N_Trabajadores, N_Mesas, Area_negocio, Tenencia_Negocio, Personeria, 
                            Tipo_personeria, N_Camas, N_Cuartos, Razon_Social, N_Ruc, N_Bano, Id_Giro_Establecimiento, 
                            Id_Predio, T_Agua_Negocio,T_Itse,Vencimiento_Itse) 
                            VALUES 
                            (:N_Licencia, :N_Trabajadores, :N_Mesas, :Area_negocio, :Tenencia_Negocio, :Personeria, 
                            :Tipo_personeria, :N_Camas, :N_Cuartos, :Razon_Social, :N_Ruc, :N_Bano, :Id_Giro_Establecimiento, 
                            :Id_Predio, :T_Agua_Negocio, :T_Itse,:Vencimiento_Itse)"
            );

            // Vincular las variables con los parámetros de la consulta
            $stmt->bindParam(':N_Licencia', $N_Licencia, PDO::PARAM_STR);
            $stmt->bindParam(':N_Trabajadores', $N_Trabajadores, PDO::PARAM_INT);
            $stmt->bindParam(':N_Mesas', $N_Mesas, PDO::PARAM_INT);
            $stmt->bindParam(':Area_negocio', $Area_negocio, PDO::PARAM_STR);
            $stmt->bindParam(':Tenencia_Negocio', $Tenencia_Negocio, PDO::PARAM_STR);
            $stmt->bindParam(':Personeria', $Personeria, PDO::PARAM_STR);
            $stmt->bindParam(':Tipo_personeria', $Tipo_personeria, PDO::PARAM_STR); 
            $stmt->bindParam(':N_Camas', $N_Camas, PDO::PARAM_INT);
            $stmt->bindParam(':N_Cuartos', $N_Cuartos, PDO::PARAM_INT);
            $stmt->bindParam(':Razon_Social', $Razon_Social, PDO::PARAM_STR);
            $stmt->bindParam(':N_Ruc', $N_Ruc, PDO::PARAM_STR);
            $stmt->bindParam(':N_Bano', $N_Bano, PDO::PARAM_INT); // Asegúrate de que la variable sea la correcta
            $stmt->bindParam(':Id_Giro_Establecimiento', $Id_Giro_Establecimiento, PDO::PARAM_INT);
            $stmt->bindParam(':Id_Predio', $Id_Predio, PDO::PARAM_INT);
            $stmt->bindParam(':T_Agua_Negocio', $T_Agua_Negocio, PDO::PARAM_STR);
             $stmt->bindParam(':T_Itse', $T_Itse, PDO::PARAM_STR);
              $stmt->bindParam(':Vencimiento_Itse', $Vencimiento_Itse, PDO::PARAM_STR);

            

             if ($stmt->execute()) {
                return "ok";
                } else {
                return "error";
                }
                $stmt = null;

             } catch (Exception $e) {
            // Manejo de excepciones
            return "error";
        }
       
    }



    


     public static function mdlEditarNegocio($datos)
{
    try {
        $id_negocio = $datos['Id_Negocio'];

        $stmt = Conexion::conectar()->prepare("SELECT * FROM negocio n INNER JOIN giro_establecimiento g ON n.Id_Giro_Establecimiento=g.Id_Giro_Establecimiento WHERE Id_Negocio = :Id_Negocio");
        $stmt->bindParam(':Id_Negocio', $id_negocio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                return [
                    "status" => "error",
                    "message" => "No se encontraron negocios para este predio."
                ];
            }

            return [
                "status" => "ok",
                "data" => $resultados
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Error al ejecutar la consulta"
            ];
        }

    } catch (Exception $e) {
        return [
            "status" => "error",
            "message" => "Error: " . $e->getMessage()
        ];
    }
}

     //VER prediio
 public static function mdlVerNegocio($datos)
{
    try {
        $id_negocio = $datos['Id_Negocio'];

        $stmt = Conexion::conectar()->prepare("SELECT * FROM negocio n INNER JOIN giro_establecimiento g ON n.Id_Giro_Establecimiento=g.Id_Giro_Establecimiento WHERE Id_Negocio = :Id_Negocio");
        $stmt->bindParam(':Id_Negocio', $id_negocio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                return [
                    "status" => "error",
                    "message" => "No se encontraron negocios para este predio."
                ];
            }

            return [
                "status" => "ok",
                "data" => $resultados
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Error al ejecutar la consulta"
            ];
        }

    } catch (Exception $e) {
        return [
            "status" => "error",
            "message" => "Error: " . $e->getMessage()
        ];
    }
}

    //listar prediio
 public static function mdlListarNegocio($datos)
{
    try {
        $id_predio = $datos['Id_Predio'];

        $stmt = Conexion::conectar()->prepare("SELECT * FROM negocio WHERE Id_Predio = :Id_Predio");
        $stmt->bindParam(':Id_Predio', $id_predio, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                return [
                    "status" => "error",
                    "message" => "No se encontraron negocios para este predio."
                ];
            }

            return [
                "status" => "ok",
                "data" => $resultados
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Error al ejecutar la consulta"
            ];
        }

    } catch (Exception $e) {
        return [
            "status" => "error",
            "message" => "Error: " . $e->getMessage()
        ];
    }
}


 

}