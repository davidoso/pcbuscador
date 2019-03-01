<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscador extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_m', 'sm');
	}

	// Mostrar página inicial/home del buscador
	public function index()
	{
		if(!$this->session->userdata('userid')) {
			redirect('Login#SesionNoIniciada', 'refresh');
		}
		$this->load->view('searchengine');
	}

	// Llamar webservice BUSCAMW con USUARIOID y BUSCAR para crear DataTable con el JSON retornado
	public function getMasterweb()
	{
		// Bloquear acceso directo a la función o mediante URL en el navegador
		if($this->input->server('REQUEST_METHOD') != 'POST') {
			$this->session->sess_destroy();
			redirect('Login#SesionNoIniciada', 'refresh');
		}
		$docsMasterweb = $this->sm->getMasterweb();
		echo json_encode($docsMasterweb);
	}
}
?>