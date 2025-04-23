<?php

namespace Modelos;
use Conect\Conexion;
use Exception;
use PDO;

class ModeloReporte
{
	public static function mdlMostrar_ingresos_tributosagua($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT nombres, 
                                                            Tipo_Tributo,
                                                            contribuyente,
                                                            Anio,
                                                            Periodo,
                                                            Numeracion_caja,
                                                            Importe,
                                                            Gasto_Emision,
                                                            Total,
                                                            Descuento,
                                                            TIM,
                                                            Total_Pagar,
                                                            CASE resultados.Estado
                                                                WHEN 'P' THEN 'Pagado'
                                                                WHEN 'E' THEN 'Extornado'
                                                                ELSE resultados.Estado
                                                            END AS Estado
                                                        FROM (
                                                            SELECT Nombres AS nombres, 
                                                                Tipo_Tributo,
                                                                Id_Contribuyente AS contribuyente,
                                                                Anio,
                                                                Periodo,
                                                                Numeracion_caja,
                                                                Importe,
                                                                Gasto_Emision,
                                                                Total,
                                                                Descuento,
                                                                '0.00' AS TIM,
                                                                Total_Pagar,
                                                                Estado
                                                            FROM ingresos_agua ia
                                                            WHERE DATE(ia.Fecha_Pago) = '${fecha}'
                                                            GROUP BY ia.Id_Ingresos_Tributos, Tipo_Tributo
                                                        
                                                            UNION ALL
                                                        
                                                            SELECT CONCAT_WS(', ',
                                                                    GROUP_CONCAT(
                                                                        DISTINCT CONCAT(c.Nombres, ' ', c.Apellido_Paterno, ' ', c.Apellido_Materno)
                                                                        ORDER BY c.Id_Contribuyente
                                                                    )
                                                                ) AS nombres,
                                                                it.Tipo_Tributo,
                                                                it.Concatenado_idc AS contribuyente,
                                                                Anio,
                                                                Periodo,
                                                                Numeracion_caja,
                                                                Importe,
                                                                Gasto_Emision,
                                                                Total,
                                                                Descuento,
                                                                TIM,
                                                                Total_Pagar,
                                                                it.Estado -- Aquí es donde se corrige la ambigüedad
                                                            FROM ingresos_tributos it
                                                            LEFT JOIN contribuyente c ON FIND_IN_SET(c.Id_Contribuyente, REPLACE(it.Concatenado_idc, '-', ','))
                                                            WHERE DATE(it.Fecha_Pago) = '${fecha}'
                                                            GROUP BY it.Id_Ingresos_Tributos, it.Tipo_Tributo
                                                        ) AS resultados;");
		//$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

    public static function mdlMostrar_lista_extorno($fecha)
	{   
        //lista extorno
		$stmt = Conexion::conectar()->prepare("SELECT 
                                                Fecha_Pago,
                                                Numeracion_caja,
                                                SUM(Total_Pagar) AS Total_Pagar,
                                                CASE resultados.Estado
                                                    WHEN 'P' THEN 'Pagado'
                                                    WHEN 'E' THEN 'Extornado'
                                                    ELSE resultados.Estado
                                                END AS Estado,
                                                Fecha_Anula
                                            FROM (
                                                SELECT 
                                                    Numeracion_caja,
                                                    Total_Pagar,
                                                    Fecha_Pago,
                                                    Estado,
                                                    Fecha_Anula
                                                FROM ingresos_agua ia
                                                WHERE DATE(ia.Fecha_Pago) = '${fecha}'
                                                
                                                UNION ALL
                                                
                                                SELECT 
                                                    Numeracion_caja,
                                                    Total_Pagar,
                                                    Fecha_Pago,
                                                    Estado,
                                                    Fecha_Anula
                                                FROM ingresos_tributos it
                                                WHERE DATE(it.Fecha_Pago) = '${fecha}'

                                                 UNION ALL
                                                
                                                SELECT 
                                                    Numero_caja as Numeracion_caja,
                                                    Valor_Total as Total_Pagar,
                                                    Fecha_Pago,
                                                    Estado,
                                                    Fecha_Anula
                                                FROM ingresos_especies_valoradas ie
                                                WHERE DATE(ie.Fecha_Pago) = '${fecha}'
                                            ) AS resultados
                                            GROUP BY 
                                                Numeracion_caja,
                                                Fecha_Pago,
                                                Estado,
                                                Fecha_Anula order by Numeracion_caja desc;");
		//$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);    
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

    public static function mdlMostrar_ingresos_especie($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT       a.Nombre_Area as Nombre_Area, 
                                                            e.Nombre_Especie as Nombre_Especie,
                                                            i.Nombres as Nombres,
                                                            i.Numero_Caja as Numero_Caja,
                                                            i.Cantidad as Cantidad,
                                                            e.Monto as Monto,
                                                            i.Valor_Total as Valor_Total,
                                                            CASE i.Estado
                                                                WHEN 'P' THEN 'Pagado'
                                                                WHEN 'E' THEN 'Extornado'
                                                                ELSE i.Estado
                                                            END AS Estado

                                                      FROM   ingresos_especies_valoradas i
                                                      INNER JOIN area a ON a.Id_Area=i.Id_Area
                                                      INNER JOIN especie_valorada e ON e.Id_Especie_Valorada =i.Id_Especie_Valorada 
                                                      WHERE date(i.Fecha_Pago)='${fecha}'");
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}


    public static function mdlMostrar_ingresos_tributosagua_total($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT 
                                                SUM(Importe) AS Suma_Importe,
                                                SUM(Gasto_Emision) AS Suma_Gasto_Emision,
                                                SUM(Total) AS Suma_Total,
                                                SUM(Descuento) AS Suma_Descuento,
                                                SUM(TIM) AS Suma_TIM,
                                                SUM(Total_Pagar) AS Suma_Total_Pagar
                                            FROM
                                                (
                                                    SELECT 
                                                        Importe,
                                                        Gasto_Emision,
                                                        Total,
                                                        Descuento,
                                                        NULL AS TIM,
                                                        Total_Pagar
                                                    FROM
                                                        ingresos_agua ia
                                                    WHERE
                                                        DATE(ia.Fecha_Pago) = '${fecha}' AND ia.Estado = 'P'
                                                    UNION ALL
                                                    SELECT 
                                                        Importe,  
                                                        Gasto_Emision,
                                                        Total,
                                                        Descuento,
                                                        TIM,
                                                        Total_Pagar
                                                    FROM
                                                        ingresos_tributos it
                                                    WHERE
                                                        DATE(it.Fecha_Pago) = '${fecha}' AND it.Estado = 'P'
                                                ) AS Subconsulta;");  
		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}

    public static function mdlMostrar_ingresos_especie_total($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT    SUM(Valor_Total)  as Total 
                                        FROM   ingresos_especies_valoradas i
                                        WHERE date(i.Fecha_Pago)='${fecha}' and Estado='P'");  
		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}

    public static function mdlMostrar_ingresos_tributosagua_report($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT 
                                                    Codigo,
                                                    Descripcion,
                                                    COUNT(Id_Ingresos_Tributos) as registros,
                                                    SUM(Importe) AS Suma_Importe,
                                                    SUM(Gasto_Emision) AS Suma_Gasto_Emision,
                                                    SUM(Total) AS Suma_Total,
                                                    SUM(Descuento) AS Suma_Descuento,
                                                    SUM(TIM) AS Suma_TIM,
                                                    SUM(Total_Pagar) AS Suma_Total_Pagar
                                                FROM
                                                    (
                                                        SELECT 
                                                            Codigo,
                                                            Descripcion,
                                                            Id_Ingresos_Tributos,
                                                            Importe,
                                                            Gasto_Emision,
                                                            Total,
                                                            Descuento,
                                                            NULL AS TIM,
                                                            Total_Pagar
                                                        FROM
                                                            ingresos_agua ia INNER JOIN presupuesto p ON ia.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(ia.Fecha_Pago) = '${fecha}' AND ia.Estado = 'P'
                                                    
                                                        UNION ALL
                                                        SELECT
                                                            Codigo,
                                                            Descripcion, 
                                                            Id_Ingresos_Tributos, 
                                                            Importe,  
                                                            Gasto_Emision,
                                                            Total,
                                                            Descuento,
                                                            TIM,
                                                            Total_Pagar
                                                        FROM
                                                            ingresos_tributos it INNER JOIN presupuesto p ON it.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(it.Fecha_Pago) = '${fecha}' AND it.Estado = 'P'
                                                    
                                                    ) AS Subconsulta   GROUP BY Codigo;");  
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

    public static function mdlMostrar_ingresos_especie_report($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT p.Codigo as Codigo,
                                                        e.Nombre_Especie as Nombre_Especie,
                                                        COUNT(p.Codigo) as item,
                                                        e.Monto as Monto,
                                                        SUM(Valor_Total) as Total
                                                FROM ingresos_especies_valoradas i 
                                                INNER JOIN especie_valorada e  ON e.Id_Especie_Valorada=i.Id_Especie_Valorada
                                                INNER JOIN presupuesto p ON p.Id_Presupuesto=e.Id_Presupuesto
                                                WHERE Date(i.Fecha_pago)='${fecha}'
                                                GROUP BY p.Codigo;");  
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}


    public static function mdlMostrar_ingresos_tributosagua_presu($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT 
                                                    Codigo,
                                                    Descripcion,
                                                    COUNT(Id_Ingresos_Tributos) as registros,
                                                    SUM(Total_Pagar) AS Suma_Total_Pagar
                                                FROM
                                                    (
                                                        SELECT
                                                            Codigo, 
                                                            Descripcion,
                                                            Id_Ingresos_Tributos,
                                                            (Total_Pagar-Gasto_Emision) as Total_Pagar
                                                        FROM
                                                            ingresos_agua ia INNER JOIN presupuesto p ON ia.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(ia.Fecha_Pago) = '${fecha}' AND ia.Estado = 'P'
                                                    
                                                        UNION ALL
                                                        SELECT
                                                            Codigo,
                                                            Descripcion, 
                                                            Id_Ingresos_Tributos,
                                                            (Total_Pagar-Gasto_Emision) as Total_Pagar
                                                        FROM
                                                            ingresos_tributos it INNER JOIN presupuesto p ON it.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(it.Fecha_Pago) = '${fecha}' AND it.Estado = 'P'
                                                    
                                                    ) AS Subconsulta   
                                                GROUP BY Descripcion
                                                
                                                UNION ALL
                                                
                                                SELECT 
                                                    '133929' AS Codigo,
                                                    'OTROS SERVICIOS (MECANIZADOS)' AS Descripcion,
                                                    COUNT(CASE WHEN Gasto_Emision > 0 THEN Codigo END) AS registros,
                                                    SUM(Gasto_Emision) AS Suma_Total_Pagar
                                                FROM
                                                    (
                                                        SELECT
                                                            Codigo,
                                                            Gasto_Emision
                                                        FROM
                                                            ingresos_agua ia INNER JOIN presupuesto p ON ia.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(ia.Fecha_Pago) = '${fecha}' AND ia.Estado = 'P'
                                                    
                                                        UNION ALL
                                                        SELECT
                                                            Codigo,
                                                            Gasto_Emision
                                                        FROM
                                                            ingresos_tributos it INNER JOIN presupuesto p ON it.Id_Presupuesto=p.Id_Presupuesto
                                                        WHERE
                                                            DATE(it.Fecha_Pago) = '${fecha}' AND it.Estado = 'P'
                                                    ) AS Subconsulta_Gasto_Emision
                                                HAVING SUM(Gasto_Emision) IS NOT NULL;");  
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}

    public static function mdlMostrar_ingresos_especie_area($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT   a.Nombre_Area as Nombre_Area,
                                                        COUNT(i.Id_Area) as item,
                                                        SUM(Valor_Total) as Total
                                                FROM ingresos_especies_valoradas i 
                                                INNER JOIN area a  ON a.Id_Area=i.Id_Area
                                                WHERE Date(i.Fecha_pago)='${fecha}'
                                                GROUP BY i.Id_Area;");  
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}
	//cierre caja consolidado
    public static function mdlCierre_Ingresos($fecha)
	{   $pdo  = Conexion::conectar();
        $pdo->exec("LOCK TABLES reporte_financiamiento WRITE");
        $pdo->beginTransaction();
        $stm1=$pdo ->prepare("INSERT INTO cierre_fecha (Fecha,Estado) VALUES (:fecha,:estado)");
        $stm1->bindParam(":fecha", $fecha);
        $stm1->bindValue(":estado",1);
        $stm1->execute();
        $id_ultimo = $pdo->lastInsertId();
		$stmt = $pdo->prepare("INSERT INTO reporte_financiamiento (Id_Cierre_Fecha,Id_Presupuesto, Id_Area, Subtotal, Id_Financia,Fecha_Cierre)
                                SELECT      $id_ultimo,
                                            Id_Presupuesto,
                                            Id_Area,
                                            SUM(Total_Pagar) AS Total_Pagar,
                                            Id_Financiamiento,
                                            :Fecha_Cierre
                                        FROM
                                            (
                                                SELECT 
                                                    Id_Presupuesto,
                                                    ia.Id_Area as Id_Area,
                                                    Total_Pagar,
                                                    Id_Financiamiento 
                                                FROM
                                                    ingresos_agua ia 
                                                WHERE
                                                    DATE(ia.Fecha_Pago) = '${fecha}' AND ia.Estado = 'P' AND ia.Cierre=0
                                                UNION ALL
                                                SELECT
                                                    Id_Presupuesto,
                                                    it.Id_Area as Id_Area,
                                                    Total_Pagar,
                                                    Id_financiamiento  as Id_Financiamiento
                                                FROM
                                                    ingresos_tributos it 
                                                WHERE
                                                    DATE(it.Fecha_Pago) = '${fecha}' AND it.Estado = 'P' AND it.Cierre=0
                                                UNION ALL
                                                SELECT
                                                    p.Id_Presupuesto as Id_Presupuesto,
                                                    ie.Id_Area as Id_Area,
                                                    Valor_Total,
                                                    p.Id_financiamiento as Id_Financiamiento
                                                FROM
                                                    ingresos_especies_valoradas ie INNER JOIN especie_valorada ev ON ie.Id_Especie_Valorada=ev.Id_Especie_Valorada
                                                    INNER JOIN presupuesto p ON ev.Id_Presupuesto=p.Id_Presupuesto
                                                WHERE
                                                    DATE(ie.Fecha_Pago) = '${fecha}' AND ie.Estado = 'P'  AND ie.Cierre=0  
                                            ) AS Subconsulta   
                                            GROUP BY Id_Presupuesto,Id_Area,Id_Financiamiento;");  
        $stmt->bindParam(":Fecha_Cierre", $fecha);                                    
		$stmt->execute();

        $tablas = array("ingresos_agua", "ingresos_tributos", "ingresos_especies_valoradas");
                foreach ($tablas as $tabla) {
                    $stm = $pdo->prepare("UPDATE $tabla SET Cierre=1 WHERE Date(Fecha_Pago)='$fecha'");
                    $stm->execute();
                }
        $pdo->exec("UNLOCK TABLES");
        $pdo->commit();
        return 'ok';
		//return $row->fetchall();
		$stmt = null;
	}

    public static function mdlMostrar_Report_Finan($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT  p.Codigo as codigo,
                                                p.Descripcion as descripcion,
                                                Subtotal as subtotal,
                                                f.Financia as financia
                                                FROM reporte_financiamiento r
                                                INNER JOIN presupuesto p  ON p.Id_Presupuesto=r.Id_Presupuesto
                                                INNER JOIN financiamiento f ON f.Id_financiamiento =r.Id_Financia 
                                                WHERE r.Fecha_Cierre='${fecha}'");
		$stmt->execute();
		return $stmt->fetchall();
		$stmt = null;
	}
    public static function mdlMostrar_Report_Finan_total($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT 
                                                SUM(Subtotal) AS total
                                            FROM reporte_financiamiento WHERE Fecha_Cierre='${fecha}' ");  
		$stmt->execute();
		return $stmt->fetch();
		$stmt = null;
	}

    public static function mdlMostrar_Ingreso_Diarios($fecha)
	{
		$stmt = Conexion::conectar()->prepare("SELECT p.Codigo, p.Descripcion, rf.Subtotal, f.Financia FROM reporte_financiamiento rf 
        INNER JOIN presupuesto p ON rf.Id_Presupuesto= p.Id_Presupuesto 
        INNER JOIN financiamiento f ON rf.Id_Financia = f.Id_financiamiento INNER JOIN area a ON rf.Id_Area = a.Id_Area 
        INNER JOIN cierre_fecha c ON rf.Id_Cierre_Fecha = c.Id_Cierre_Fecha WHERE rf.Fecha_Cierre=:Fecha_Cierre");  
        $stmt->bindParam(":Fecha_Cierre", $fecha);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;
        return $result;
	}
}
