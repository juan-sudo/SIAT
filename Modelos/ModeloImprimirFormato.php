<?php

namespace Modelos;

use Conect\Conexion;
use Exception;
use PDO;

class ModeloImprimirFormato
{
public static function mdlListarPredio_HR($propietario,$anio)
	{
        $valor = explode(',', $propietario);
		$pdo =  Conexion::conectar();
		if (count($valor) === 1) {
			// Cuando $valor tiene un solo valor
			$stmt = $pdo->prepare("SELECT 
			p.predio_UR as tipo_ru, 
			p.Direccion_completo as direccion_completo,
			IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
			p.Area_Terreno as a_terreno,
			p.Area_Construccion as a_construccion,
			p.Valor_Inaf_Exo as inafecto,
			p.Valor_Predio as v_predio,
			p.Valor_Predio_Aplicar as v_predio_aplicar
		   FROM 
			predio p  
			 LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
             LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
			INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
			INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
					WHERE 
						pro.Id_Contribuyente =:id AND an.NomAnio =$anio 
						AND p.ID_Predio NOT IN 
						     (SELECT ID_Predio FROM Propietario 
							  WHERE ID_Contribuyente <>:id AND baja='1') and pro.Baja='1'");
						$stmt->bindParam(":id", $valor[0]);
						$stmt->execute();
		} else {
            //$ids = implode("-", $propietario);//CONVIERTE EN UN STRING
			// Cuando $valor tiene más de un valor
			$ids = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
			$stmt = $pdo->prepare("SELECT 
			                       p.predio_UR as tipo_ru, 
								   IF(p.predio_UR = 'U', ca.Codigo_Catastral, car.Codigo_Catastral) as catastro,
									p.Direccion_completo as direccion_completo,
									p.Area_Terreno as a_terreno,
									p.Area_Construccion as a_construccion,
									p.Valor_Inaf_Exo as inafecto,
									p.Valor_Predio as v_predio,
									p.Valor_Predio_Aplicar as v_predio_aplicar
								FROM 
									predio p  
									LEFT JOIN catastro ca ON p.predio_UR = 'U' AND ca.Id_Catastro = p.Id_Catastro 
                                    LEFT JOIN catastro_rural car ON p.predio_UR = 'R' AND car.Id_Catastro_Rural = p.Id_Catastro_Rural 
									INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
									INNER JOIN anio an ON an.Id_Anio = p.Id_Anio  
								   WHERE pro.Id_Contribuyente IN ($propietario) and pro.baja='1'
								   and an.NomAnio=$anio  
								   GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor)
								    );
			$stmt->execute();
		}
		$campos = $stmt->fetchall();
		return $campos;
	}
	public static function mdlListarPredio_DJ($propietario,$anio,$id_predio,$tipopredio)
	{
        $valor = explode(',', $propietario);
		$pdo =  Conexion::conectar();
		if (count($valor) === 1) {
			// Cuando $valor tiene un solo valor
			if($tipopredio==='U'){
                $stmt = $pdo->prepare("SELECT 
				p.predio_UR as tipo_ru, 
				p.Direccion_completo as direccion_completo,
				p.Area_Terreno as a_terreno,
				p.Valor_Construccion as valor_construccion,
				p.Valor_Terreno as valor_terreno,
				p.Valor_Predio as valor_predio,
				p.Area_Construccion as a_construccion,
				p.Valor_Inaf_Exo as inafecto,
				p.Valor_Predio as v_predio		
			FROM 
				predio p  
				INNER JOIN catastro ca ON ca.Id_Catastro = p.Id_Catastro 
				INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
				INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
				
			WHERE 
				pro.Id_Contribuyente =:id AND an.NomAnio =$anio AND p.Id_Predio=:id_predio
				AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario WHERE ID_Contribuyente <>:id AND Baja='1')");
						 $stmt->bindParam(":id", $valor[0]);
						 $stmt->bindParam(":id_predio", $id_predio);
						 $stmt->execute();
			}
			
			else{
				$stmt = $pdo->prepare("SELECT 
				p.predio_UR as tipo_ru, 
				p.Area_Terreno as a_terreno,
				p.Area_Construccion as a_construccion,
				p.Valor_Inaf_Exo as inafecto,
				p.Valor_Predio v_predio,
				p.Direccion_completo as direccion_completo,
				p.Valor_Construccion as valor_construccion,
				p.Valor_Terreno as valor_terreno,
				p.Valor_Predio as valor_predio,
				t.Tipo_Terreno as tipo_terreno,
				u.Uso_Terreno as uso_terreno,
				c_a.Categoria_Calidad_Agricola as categoria_calidad,
				c_a.Nombre_Grupo_Tierra as nombre_tierra,
				cd.Colindante_Sur_Nombre as colindante_sur_nombre,
				cd.Colindante_Norte_Nombre as colindante_norte_nombre,
				cd.Colindante_este_Nombre as colindante_este_nombre,
				cd.Colindante_oeste_Nombre as colindante_oeste_nombre,
				cd.Colindante_Sur_Denominacion as colindante_sur_denominacion,
				cd.Colindante_Norte_Denominacion as colindante_norte_denominacion,
				cd.Colindante_Este_Denominacion as colindante_este_denominacion,
				cd.Colindante_Oeste_Denominacion as colindante_oeste_denominacion
			 FROM 
				 predio p 
				 INNER JOIN catastro_rural ca ON ca.Id_Catastro_Rural = p.Id_Catastro_Rural 
				 INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
				 INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
				 INNER JOIN contribuyente c ON c.Id_Contribuyente = pro.Id_Contribuyente 
				 INNER JOIN valores_categoria_x_hectarea h ON h.Id_valores_categoria_x_hectarea = ca.Id_valores_categoria_x_hectarea 
				 INNER JOIN tipo_terreno t on t.Id_Tipo_Terreno=p.Id_Tipo_Terreno
				 INNER JOIN uso_terreno u on u.Id_Uso_Terreno=p.Id_Uso_Terreno 
				 INNER JOIN calidad_agricola c_a on c_a.Id_Calidad_Agricola=h.Id_Calidad_Agricola
				 LEFT JOIN colindante_denominacion cd  on cd.Id_Colindante_Denominacion=p.Id_Colindante_Denominacion
			 WHERE 
				 pro.Id_Contribuyente =:id AND an.NomAnio =$anio AND p.Id_Predio=:id_predio
				 AND p.ID_Predio NOT IN (SELECT ID_Predio FROM Propietario WHERE ID_Contribuyente <>:id AND baja='1');");
				 //NOT IN (SELECT ID_Predio FROM Propietario WHERE ID_Contribuyente <> :id)
				 $stmt->bindParam(":id", $valor[0]);
				 $stmt->bindParam(":id_predio", $id_predio);
				 $stmt->execute();
			}

		} else {
			
            //$ids = implode("-", $propietario);//CONVIERTE EN UN STRING
			// Cuando $valor tiene más de un valor
			$ids = implode(",", $valor); // Convierte el array en una cadena de IDs separados por comas
			if($tipopredio==='U'){
			
			$stmt = $pdo->prepare("SELECT 
									p.predio_UR as tipo_ru, 
									p.Direccion_completo as direccion_completo,
									p.Area_Terreno as a_terreno,
									p.Valor_Construccion as valor_construccion,
									p.Valor_Terreno as valor_terreno,
									p.Valor_Predio as valor_predio,
									p.Area_Construccion as a_construccion,
									p.Valor_Inaf_Exo as inafecto,
									p.Valor_Predio as v_predio
								FROM 
									predio p  
									INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
									INNER JOIN anio an ON an.Id_Anio = p.Id_Anio
								   WHERE pro.Id_Contribuyente IN ($ids) 
								   and an.NomAnio=$anio  AND p.Id_Predio=:id_predio and baja='1'
								   GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
								   	
									$stmt->bindParam(":id_predio", $id_predio);
									$stmt->execute();
			}				   
								   
			else{			  
				$stmt = $pdo->prepare("SELECT 
										p.predio_UR as tipo_ru,
										p.Area_Terreno as a_terreno,
										p.Area_Construccion as a_construccion,
										p.Valor_Inaf_Exo as inafecto,
										p.Valor_Predio v_predio,
										p.Direccion_completo as direccion_completo,
										p.Valor_Construccion as valor_construccion,
										p.Valor_Terreno as valor_terreno,
										p.Valor_Predio as valor_predio,
										t.Tipo_Terreno as tipo_terreno,
										u.Uso_Terreno as uso_terreno,
										c_a.Categoria_Calidad_Agricola as categoria_calidad,
										c_a.Nombre_Grupo_Tierra as nombre_tierra,
										cd.Colindante_Sur_Nombre as colindante_sur_nombre,
				cd.Colindante_Norte_Nombre as colindante_norte_nombre,
				cd.Colindante_este_Nombre as colindante_este_nombre,
				cd.Colindante_oeste_Nombre as colindante_oeste_nombre,
				cd.Colindante_Sur_Denominacion as colindante_sur_denominacion,
				cd.Colindante_Norte_Denominacion as colindante_norte_denominacion,
				cd.Colindante_Este_Denominacion as colindante_este_denominacion,
				cd.Colindante_Oeste_Denominacion as colindante_oeste_denominacion
										
									FROM 
										predio p 
										INNER JOIN catastro_rural ca ON ca.Id_Catastro_Rural = p.Id_Catastro_Rural 
										INNER JOIN propietario pro ON pro.Id_Predio = p.Id_Predio 
										INNER JOIN anio an ON an.Id_Anio = p.Id_Anio 
										INNER JOIN contribuyente c ON c.Id_Contribuyente = pro.Id_Contribuyente 
										INNER JOIN valores_categoria_x_hectarea h ON h.Id_valores_categoria_x_hectarea = ca.Id_valores_categoria_x_hectarea 
										INNER JOIN zona_rural z ON z.Id_zona_rural = h.Id_Zona_Rural 
										INNER JOIN denominacion_rural d ON d.Id_Denominacion_Rural =p.Id_Denominacion_Rural
										INNER JOIN tipo_terreno t on t.Id_Tipo_Terreno=p.Id_Tipo_Terreno
										INNER JOIN uso_terreno u on u.Id_Uso_Terreno=p.Id_Uso_Terreno 
										inner JOIN calidad_agricola c_a on c_a.Id_Calidad_Agricola=h.Id_Calidad_Agricola
										LEFT JOIN colindante_denominacion cd  on cd.Id_Colindante_Denominacion=p.Id_Colindante_Denominacion
										
									   WHERE pro.Id_Contribuyente IN ($ids) and pro.baja='1'
									   and an.NomAnio=$anio  AND p.Id_Predio=:id_predio
									   GROUP BY p.ID_Predio HAVING COUNT(DISTINCT pro.ID_Contribuyente) = " . count($valor));
									   $stmt->bindParam(":id_predio", $id_predio);
			                           $stmt->execute();
									   
			}
		}
		$campos = $stmt->fetch();
		return $campos;
	}

	public static function mdlListarPisos_dj($id_predio)
	{   
        $pdo =  Conexion::conectar();
		$stmt = $pdo->prepare(" SELECT * FROM pisos
								WHERE Id_Predio=$id_predio;");
		$stmt->execute();
		$campos = $stmt->fetchAll();
		return $campos;
	}
	public static function mdlColindantes($id_predio)
	{
        $pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT cd.Colindante_Sur_Nombre as colindante_sur_nombre,
										cd.Colindante_Sur_Denominacion as colindante_sur_denominacion,
										cd.Colindante_Norte_Nombre as colindante_norte_nombre,
										cd.Colindante_Norte_Denominacion as colindante_norte_denominacion,
										cd.Colindante_Este_Nombre as colindante_este_nombre,
										cd.Colindante_Este_Denominacion as colindante_este_denominacion,
										cd.Colindante_Oeste_Nombre as colindante_oeste_nombre,
										cd.Colindante_Oeste_Denominacion as colindante_oeste_denominacion
										FROM predio p 
										INNER JOIN colindante_denominacion cd on cd.Id_Colindante_Denominacion=p.Id_Colindante_Denominacion  
							            WHERE p.Id_Predio=$id_predio;");
		$stmt->execute();
		$campos = $stmt->fetch();
		return $campos;
	}
	public static function mdlCondicion($id_predio)
	{
        $pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT e.Estado as estado,
								tp.Tipo as tipo,
								up.Uso as uso,
								cp.Condicion as condicion,
								ra.Regimen as regimen
								FROM predio p
								INNER JOIN estado_predio e ON e.Id_Estado_Predio=p.Id_Estado_Predio  
								INNER JOIN tipo_predio tp on tp.Id_Tipo_Predio=p.Id_Tipo_Predio
								INNER JOIN uso_predio up on up.Id_Uso_Predio=p.Id_Uso_Predio
								INNER JOIN condicion_predio cp on cp.Id_Condicion_Predio=p.Id_Condicion_Predio
								INNER JOIN regimen_afecto ra on ra.Id_Regimen_Afecto=p.Id_Regimen_Afecto   
							    WHERE p.Id_Predio=$id_predio;");
		$stmt->execute();
		$campos = $stmt->fetch();
		return $campos;
	}
	public static function mdlArancel_Urbano($catastro,$ru,$anio)
	{
        $pdo =  Conexion::conectar();
		if($ru=='urbano'){
		$stmt = $pdo->prepare("SELECT  ar.Importe as arancel from predio p inner join catastro c on c.Id_Catastro=p.Id_Catastro
		                       inner join ubica_via_urbano u on u.Id_Ubica_Vias_Urbano=c.Id_Ubica_Vias_Urbano 
							   inner join arancel_vias av on av.Id_Ubica_Vias_Urbano=u.Id_Ubica_Vias_Urbano
		                       inner join arancel ar on ar.Id_Arancel=av.Id_Arancel 
		                       inner join anio a on a.Id_Anio=ar.Id_Anio 
		                       where c.Codigo_Catastral=:catastro and a.NomAnio=$anio;");
							   $stmt->bindParam(":catastro", $catastro);
		}
		else{
			$stmt = $pdo->prepare("SELECT ar.Arancel  as arancel 
			                       from predio p 
								   inner join catastro_rural c on c.Id_Catastro_Rural=p.Id_Catastro_Rural 
								   inner join valores_categoria_x_hectarea v on v.Id_valores_categoria_x_hectarea=c.Id_valores_categoria_x_hectarea
								   inner join arancel_rustico_hectarea ah on ah.Id_valores_categoria_x_hectarea=v.Id_valores_categoria_x_hectarea 
								   inner join arancel_rustico ar on ar.Id_Arancel_Rustico=ah.Id_Arancel_Rustico 
								   inner join anio a on a.Id_Anio=ar.Id_Anio 
								   where a.NomAnio=$anio and c.Codigo_Catastral=:catastro; ");
							   $stmt->bindParam(":catastro", $catastro);
		}
							   
		$stmt->execute();
		$campos = $stmt->fetch();
		return $campos;
	}
	public static function mdlLiquidacion($anio,$id_predio)
	{
        $pdo =  Conexion::conectar();
		$stmt = $pdo->prepare("SELECT t.Id_Nombre_Arbitrio as id_arbitrio,
		                              t.Monto as monto, 
									
									  p.Area_Construccion as area 
		                        FROM predio p 
		                        INNER JOIN arbitrios a on a.Id_Arbitrios=p.Id_Arbitrios 
								INNER JOIN  tasa_arbitrio t on t.Id_Arbitrios=a.Id_Arbitrios
								INNER JOIN anio an on an.Id_Anio=t.Id_Anio
								WHERE an.NomAnio=$anio and p.Id_Predio=$id_predio ORDER BY t.Id_Nombre_Arbitrio;");   
		$stmt->execute();
		$campos = $stmt->fetchAll();
		return $campos;
	}
}