<?php
class Paginacion
{

	public function paginarContribuyente($reload, $page, $tpages, $adjacents,$tipo)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';
		// previous label
		if ($page == 1) {
			$out .= "<li class='disabled'><span><a class='pagi'>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(1,".$tipo.")'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(" . ($page - 1) . ",".$tipo.")'>$prevlabel</a></span></li>";
		}
		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a  class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(1,".$tipo.")'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a class='pagi' >...</a></li>";
		}
		// pages
		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a class='pagi'>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(1,".$tipo.")'>$i</a></li>";
			} else {
				$out .= "<li><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(" . $i . ",".$tipo.")'>$i</a></li>";
			}
		}
		// interval
		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a class='pagi' >...</a></li>";
		}
		// last
		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a class='pagi'  href='javascript:void(0);' onclick='loadContribuyentep($tpages,".$tipo.")'>$tpages</a></li>";
		}
		// next
		if ($page < $tpages) {
			$out .= "<li><span><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep(" . ($page + 1) . ",".$tipo.")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a class='pagi' >$nextlabel</a></span></li>";
		}
		$out .= "</ul>";
		return $out;
	}
	public function paginar_zonas_rustico($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';
		// previous label
		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}
		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}
		// pages
		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(" . $i . ")'>$i</a></li>";
			}
		}
		// interval
		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}
		// last
		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePredioRusticop($tpages)'>$tpages</a></li>";
		}
		// next
		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePredioRusticop(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
		$out .= "</ul>";
		return $out;
	}
public function paginarContribuyente_impuesto($reload, $page, $tpages, $adjacents)
{
    $prevlabel = "&lsaquo;";
    $nextlabel = "&rsaquo;";
    $out = '<ul class="pagination ">';
    // previous label
    if ($page == 1) {
        $out .= "<li class='disabled'><span><a class='pagi'>$prevlabel</a></span></li>";
    } else if ($page == 2) {
        $out .= "<li><span><a href='javascript:void(0);' onclick='loadContribuyentep_impuesto(1)' class='pagi'>$prevlabel</a></span></li>";
    } else {
        $out .= "<li><span><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep_impuesto(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
    }
    // first label
    if ($page > ($adjacents + 1)) {
        $out .= "<li><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep_impuesto(1)'>1</a></li>";
    }
    // interval
    if ($page > ($adjacents + 2)) {
        $out .= "<li><a class='pagi'>...</a></li>";
    }
    // pages
    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out .= "<li class='active'><a class='pagi'>$i</a></li>";
        } else if ($i == 1) {
            $out .= "<li><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep_impuesto(1)'>$i</a></li>";
        } else {
            $out .= "<li><a  class='pagi' href='javascript:void(0);' onclick='loadContribuyentep_impuesto(" . $i . ")'>$i</a></li>";
        }
    }
    // interval
    if ($page < ($tpages - $adjacents - 1)) {
        $out .= "<li><a class='pagi'>...</a></li>";
    }
    // last
    if ($page < ($tpages - $adjacents)) {
        $out .= "<li><a class='pagi'  href='javascript:void(0);' onclick='loadContribuyentep_impuesto($tpages)'>$tpages</a></li>";
    }
    // next
    if ($page < $tpages) {
        $out .= "<li><span><a class='pagi' href='javascript:void(0);' onclick='loadContribuyentep_impuesto(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
    } else {
        $out .= "<li class='disabled'><span><a class='pagi'>$nextlabel</a></span></li>";
    }

    $out .= "</ul>";
    return $out;
}
	public function paginarContribuyente_impuesto_recaudacion($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';
		// previous label
		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}
		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}
		// pages
		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(" . $i . ")'>$i</a></li>";
			}
		}

		// interval

		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}

		// last

		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop($tpages)'>$tpages</a></li>";
		}

		// next

		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='recaudar_loadContribuyente_impuestop(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}

		$out .= "</ul>";
		return $out;
	}
	public function paginarContribuyente_agua($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';

		// previous label

		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadContribuyente_agua(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadContribuyente_agua(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}

		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadContribuyente_agua(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}

		// pages

		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='loadContribuyente_agua(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='loadContribuyente_agua(" . $i . ")'>$i</a></li>";
			}
		}

		// interval

		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}

		// last

		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadContribuyente_agua($tpages)'>$tpages</a></li>";
		}

		// next

		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadContribuyente_agua(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}

		$out .= "</ul>";
		return $out;
	}




	public function paginarViascalles($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';

		// previous label

		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallep(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallep(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}

		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallep(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}

		// pages

		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallep(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallep(" . $i . ")'>$i</a></li>";
			}
		}

		// interval

		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}

		// last

		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallep($tpages)'>$tpages</a></li>";
		}

		// next

		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallep(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}

		$out .= "</ul>";
		return $out;
	}
	//PAGINADOR DE VIAS Y CALLES EN LA VISTA DE PREDIO - EN EL MODAL DE AGREGAR VIAS Y CALLES
	public function paginarViascallesPredio($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';
		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePrediop(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePrediop(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}
		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePrediop(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}
		// pages
		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePrediop(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePrediop(" . $i . ")'>$i</a></li>";
			}
		}
		// interval
		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}
		// last
		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadViacallePrediop($tpages)'>$tpages</a></li>";
		}
		// next
		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadViacallePrediop(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
		$out .= "</ul>";
		return $out;
	}

	//PAGINACION DEL PROIETARIO AL REGISTRAR PREDIO URBANO -VALIDADO
	public function paginarPropietario($reload, $page, $tpages, $adjacents)
	{
		$prevlabel = "&lsaquo;";
		$nextlabel = "&rsaquo;";
		$out = '<ul class="pagination ">';

		// previous label

		if ($page == 1) {
			$out .= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if ($page == 2) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadPropietariop(1)'>$prevlabel</a></span></li>";
		} else {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadPropietariop(" . ($page - 1) . ")'>$prevlabel</a></span></li>";
		}

		// first label
		if ($page > ($adjacents + 1)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadPropietariop(1)'>1</a></li>";
		}
		// interval
		if ($page > ($adjacents + 2)) {
			$out .= "<li><a>...</a></li>";
		}

		// pages

		$pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
		$pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
		for ($i = $pmin; $i <= $pmax; $i++) {
			if ($i == $page) {
				$out .= "<li class='active'><a>$i</a></li>";
			} else if ($i == 1) {
				$out .= "<li><a href='javascript:void(0);' onclick='loadPropietariop(1)'>$i</a></li>";
			} else {
				$out .= "<li><a href='javascript:void(0);' onclick='loadPropietariop(" . $i . ")'>$i</a></li>";
			}
		}

		// interval

		if ($page < ($tpages - $adjacents - 1)) {
			$out .= "<li><a>...</a></li>";
		}

		// last

		if ($page < ($tpages - $adjacents)) {
			$out .= "<li><a href='javascript:void(0);' onclick='loadPropietariop($tpages)'>$tpages</a></li>";
		}

		// next

		if ($page < $tpages) {
			$out .= "<li><span><a href='javascript:void(0);' onclick='loadPropietariop(" . ($page + 1) . ")'>$nextlabel</a></span></li>";
		} else {
			$out .= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}

		$out .= "</ul>";
		return $out;
	}
}
