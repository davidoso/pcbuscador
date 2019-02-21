<?php
class Sidebar_m extends CI_Model {

	public function getCapas()
	{
		// Alternativa escribiendo query
		/*$query =
		"SELECT carpeta, capa FROM
		ctrl_select_capas ORDER BY 1, 2";
		$query = $this->db->query($query);*/

		/*$this->db->select('carpeta, capa');
		$this->db->order_by('carpeta, capa');
		$query = $this->db->get('ctrl_select_capas');

        return $query->result_array();*/
	}

	public function getCampos()
	{
		$capa = $this->input->get('capa');

		$this->db->select("CF.campo_frontend AS 'campo'");
		$this->db->from('ctrl_select_capas AS SC');
		$this->db->join('ctrl_campos_a_filtrar AS CF', 'SC.id_capa = CF.id_capa');
		$this->db->where('SC.capa', $capa);
		$this->db->order_by('CF.campo_frontend');
		$query = $this->db->get();

		return $query->result();
	}

	public function getValores()
	{
		$capa = $this->input->get('capa');
		$campo = $this->input->get('campo');

		$this->db->select("SC.nombre_tabla AS 'nombre_tabla', NC.columna_bd AS 'columna_bd'");
		$this->db->from('ctrl_select_capas AS SC');
		$this->db->join('ctrl_campos_a_filtrar AS CF', 'SC.id_capa = CF.id_capa');
		$this->db->join('ctrl_nombre_columnas AS NC', 'CF.campo_frontend = NC.columna_frontend');
		$this->db->where('SC.capa', $capa);
		$this->db->where('CF.campo_frontend', $campo);

		$query = $this->db->get()->row_array();
		$nombre_tabla = $query['nombre_tabla'];
		$columna_bd = $query['columna_bd'];

		switch($campo) {
			case "MATERIAL":
				$this->db->select("DISTINCT(UPPER(C.material)) AS 'valor'");
				$this->db->from($nombre_tabla . ' AS T');
				$this->db->join('ct_material AS C', 'T.id_material = C.id_material');
				$this->db->order_by(1);
				$query = $this->db->get();
				return $query->result();

			case "CONDICIÓN FÍSICA":
				$this->db->select("DISTINCT(UPPER(C.cond_fisica)) AS 'valor'");
				$this->db->from($nombre_tabla . ' AS T');
				$this->db->join('ct_cond_fisica AS C', 'T.id_cond_fisica = C.id_cond_fisica');
				$query = $this->db->get();
				return $query->result();

			case "GIRO COMERCIAL":
				$this->db->select("DISTINCT(UPPER(L.giro_comercial)) AS 'valor'");
				$this->db->from($nombre_tabla . ' AS T');
				$this->db->join('comercio_tbl_giros_comerciales_licencias AS L', 'T.id = L.id_giro_comercial');
				$this->db->order_by(1);
				$query = $this->db->get();
				return $query->result();

			case "MERCADO":
			case "TIANGUIS":
				$this->db->select("DISTINCT(UPPER(nombre)) AS 'valor'");
				$this->db->order_by(1);
				$comercio_tbl = ($campo == "MERCADO" ? "comercio_tbl_mercados" : "comercio_tbl_tianguis");
				$query = $this->db->get($comercio_tbl);
				return $query->result();

			default:
				$queryException = $this->valueExceptions($capa, $campo, $nombre_tabla);
				if(!$queryException) {
					$this->db->select('DISTINCT(UPPER(' . $columna_bd . ')) AS valor');
					$this->db->order_by(1);
					$query = $this->db->get($nombre_tabla);
					return $query->result();
				}
				else {
					return $queryException;
				}
		}
	}

	private function valueExceptions($capa, $campo, $nombre_tabla)
	{
		$exception = false;
		switch($capa) {
			case "LUMINARIAS":
				if($campo == "FUENTE") {
					$this->db->select("DISTINCT(UPPER(IFNULL(f_secundaria, 'SIN FUENTE'))) AS valor");
					$this->db->order_by(1);
					$exception = true;
				}
				break;
			case "TELÉFONOS PÚBLICOS":
				if($campo == "FUNCIONA") {
					$this->db->select('DISTINCT(UPPER(funciona)) AS valor');
					$exception = true;
				}
				break;
		}

		if($exception) {
			$query = $this->db->get($nombre_tabla);
			return $query->result();
		}
		else {
			return false;
		}
	}

	/* VERSIÓN BETA: FUNCIONES INNECESARIAS DESPÚES DE MEJORAR EL CÓDIGO CON LLAMADAS AJAX
	public function getCampos()
	{
		$query =
		"SELECT SC.capa, CF.campo_frontend AS 'campo' FROM
		ctrl_select_capas SC
		JOIN ctrl_campos_a_filtrar CF ON SC.id_capa = CF.id_capa ORDER BY SC.carpeta, SC.capa";
		$query = $this->db->query($query);
		return $query->result_array();
	}

	public function getMaterial($dbTable)
	{
		$query =
		"SELECT DISTINCT(C.material) FROM
		dbTable T
		JOIN ct_material C ON T.id_material = C.id_material ORDER BY 1";

		$query = str_replace("dbTable", $dbTable, $query);
		$query = $this->db->query($query);
		return $query->result_array();
	}

	public function getCondFisica($dbTable)
	{
		$query =
		"SELECT DISTINCT(C.cond_fisica) FROM
		dbTable T
		JOIN ct_cond_fisica C ON T.id_cond_fisica = C.id_cond_fisica";

		$query = str_replace("dbTable", $dbTable, $query);
		$query = $this->db->query($query);
        return $query->result_array();
	}

	public function getEmpresa($dbTable)
	{
		$this->db->select('DISTINCT(empresa_responsable)');
		$this->db->order_by(1);
		$query = $this->db->get($dbTable);
		return $query->result_array();
	}

	public function getBancoServicio()
	{
		$this->db->select('DISTINCT(tipo)');
		$this->db->order_by(1);
		$query = $this->db->get('generales_tbl_bancos');
        return $query->result_array();
	}

	public function getTelefonoCampo($campo)
	{
		$this->db->select('DISTINCT(' . $campo . ')');
		$query = $this->db->get('generales_tbl_telefonos_publicos');
		return $query->result_array();
	}

	public function getLuminariaFuente()
	{
		$query =
		"SELECT DISTINCT(IFNULL(f_secundaria, 'SIN FUENTE'))
		FROM generales_tbl_luminarias ORDER BY 1";
		$query = $this->db->query($query);
        return $query->result_array();
	}

	public function getMonumentoCampo($campo)
	{
		$this->db->select('DISTINCT(' . $campo . ')');
		$this->db->order_by(1);
		$query = $this->db->get('inah_tbl_monumentos_historicos');
        return $query->result_array();
	}*/
}
?>