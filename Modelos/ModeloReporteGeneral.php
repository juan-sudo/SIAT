<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;

class ModeloReporteGeneral
{
	

 public static function mdlMostrar_reporte_estadistico_licencia()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("

            
            SELECT Estado_progreso, COUNT(Id_Contribuyente) as totalC FROM contribuyente GROUP BY Estado_progreso
           



            ");

            
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        

            return $resultado;
        }
    

         //ULTIMA LICENCIA
        public static function mdlMostrar_reporte_ultima_licencia()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT MAX(CAST(SUBSTRING_INDEX(Numero_Licencia, '-', -1) AS UNSIGNED)) AS Ultimo_Licencia FROM licencia_agua;");
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);
            return $resultado;
        }

    //ULTIMA CARPETA
        public static function mdlMostrar_reporte_ultima_carpeta()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT MAX(CAST(SUBSTRING_INDEX(Codigo_Carpeta, '-', -1) AS UNSIGNED)) AS Ultimo_Numero FROM carpeta;");
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);
            return $resultado;
        }

         //ULTIMA CONTRIBUYENTE
        public static function mdlMostrar_reporte_ultima_contribuyente()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT MAX(CAST(SUBSTRING_INDEX(Id_Contribuyente, '-', -1) AS UNSIGNED)) AS Ultimo_contribuyente FROM contribuyente;");
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);
            return $resultado;
        }

           //TOTAL FALLECIDAS
        public static function mdlMostrar_reporte_total_fallecidas()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS Total_Fallecidos FROM  contribuyente  WHERE  Fallecida = 1;  ");
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);
            return $resultado;
        }
        
        

        public static function mdlMostrar_reporte_general()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("
            SELECT Estado_progreso, COUNT(Codigo_Carpeta) as total FROM carpeta GROUP BY Estado_progreso
            ");

            
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        

            return $resultado;
        }

        public static function mdlMostrar_reporte_carpeta_total()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("
            SELECT COUNT(*) AS total_carpetas FROM carpeta;

            ");

            
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        

            return $resultado;
        }

        public static function mdlMostrar_reporte_contribuyente_total()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("
            SELECT COUNT(*) AS total_contribuyente FROM contribuyente;

            ");

            
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        

            return $resultado;
        }


        //TOTAL PREDIOS
        public static function mdlMostrar_reporte_predio_total()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS total_predios_2025
            FROM predio
            WHERE Id_Anio = 22;
                ");

            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

            return $resultado;
        }

         //TOTAL PREDIOS URBANOS
        public static function mdlMostrar_reporte_predio_total_u()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS total_predios_2025
            FROM predio
            WHERE Id_Anio = 22  and predio_UR='U';
                ");

            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

            return $resultado;
        }

            //TOTAL PREDIOS RUSTICO
        public static function mdlMostrar_reporte_predio_total_r()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS total_predios_2025
            FROM predio
            WHERE Id_Anio = 22  and predio_UR='R';
                ");

            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

            return $resultado;
        }



        public static function mdlMostrar_reporte_licencia_total()
        {
            // Fecha simple, sin horas, porque es tipo DATE
            $stmt = Conexion::conectar()->prepare("
            SELECT COUNT(*) AS total_licencia FROM licencia_agua;
                ");

            
            $stmt->execute();

            $resultado = $stmt->fetchAll(PDO::FETCH_NUM);

        

            return $resultado;
        }













     
}
