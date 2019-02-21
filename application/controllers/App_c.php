<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_c extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct(){
		parent::__construct();
		$this->load->model('search_m', 'sm');
	}

	// Mostrar página inicial/home de las consultas dinámicas y el mapa
	public function index()
	{
		// Llenar select #cbCapas
		// https://stackoverflow.com/questions/23691396/building-a-select-with-optgroup-from-a-sql-query
		/*$db_capas = $this->sm->getCapas();
		$cbCapas = array();
		foreach($db_capas as $key => $value) {
    		$cbCapas[$value['carpeta']][] = array(
        		'capa' => $value['capa']
    		);
		}
		$data['cbCapas'] = $cbCapas;*/

		// Cargar página inicial/home de los filtros y el mapa
		//$this->load->view('home', $data);
		$this->load->view('searchengine');
	}

	public function getCampos()
	{
		// Llenar select #cbCampos (campos a filtrar según capa)
		$campos = $this->sm->getCampos();
		echo json_encode($campos);
	}

	public function getValores()
	{
		/* Llenar select #cbValores (valores a filtrar según campo de la capa). Sólo aplica para campos con un
		rango de valores preestablecidos, como material, cond_fisica o empresa */
		$valores = $this->sm->getValores();
		echo json_encode($valores);
	}

	public function getMapTotals()
	{
		$this->load->model('map_m', 'm');
		$totals = $this->m->getMapTotals();
		echo json_encode($totals);
	}

	public function getMapMarkers()
	{
		$this->load->model('map_m', 'm');
		$markers = $this->m->getMapMarkers();
		echo json_encode($markers);
	}

	public function getMapSelectedMarker()
	{
		$this->load->model('map_m', 'm');
		$selectedMarker = $this->m->getMapSelectedMarker();
		echo json_encode($selectedMarker);
	}
}
?>