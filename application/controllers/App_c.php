<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_c extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_m', 'sm');
	}

	// Mostrar página inicial/home del buscador
	public function index()
	{
		$this->load->view('searchengine');
	}

	// Llamar webservice con USUARIOID y BUSCAR para crear DataTable con el json retornado
	public function getMasterweb()
	{
		$docsMasterweb = $this->sm->getMasterweb();
		echo json_encode($docsMasterweb);
	}
}
?>