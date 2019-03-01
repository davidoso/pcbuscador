<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_controller {

    public function index()
    {
        $this->load->view('login/header');
        $this->load->view('login/login');
        $this->load->view('login/footer');
    }

    public function validar_usuario()
    {
        // Post fields required by Valida_Usuario webservice
        $usuario = $this->input->post('usuario');
        $contrasena = $this->input->post('contrasena');

        // Initiate the cURL object (open connection)
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "http://vadaexterno:8080/wsAutEmp/Service1.asmx/Valida_Usuariomw");     // URL to fetch
        curl_setopt($curl, CURLOPT_POST, TRUE);														// TRUE to do a regular HTTP POST (most commonly used by HTML forms)
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");											// Request type (POST, DELETE, GET, PUT, HEAD)
        curl_setopt($curl, CURLOPT_POSTFIELDS, "usuario=$usuario&contrasena=$contrasena");          // Data to post passed as a urlencoded string or as an associative array
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);											// TRUE to return the transfer as a string of the return value

        // Submit the POST request and decode the returned JSON string as an array of objects
        $output = curl_exec($curl);
        $output = json_decode($output);

        // Close cURL session handle (close connection)
        curl_close($curl);

        $this->iniciar_sesion($output);
    }

    private function iniciar_sesion($datos_usuario)
    {
        if (count($datos_usuario) > 0)
        {
            $this->session->set_userdata('userid', $datos_usuario[0]->USUARIOID);
            $this->session->set_userdata('username', $datos_usuario[0]->NOMBRE);

            /*if ($this->es_admin($datos_usuario[0]->GRUPOSAD) == true)
            {
                // Escribir aquí lo que se hará si es administrador
                $this->session->set_userdata('admin', 1);
                //redirect('Administrador');
            }*/
            redirect('Buscador');
        }
        redirect('Login');
    }

    public function cerrar_sesion()
    {
        $this->session->sess_destroy();
        redirect('Login#SesionCerrada', 'refresh');
    }

    private function es_admin($cadena) // Determinar si el usuario es administrador
    {
        $array = explode(",", $cadena);
        $flag = false;

        foreach ($array as $item)
        {
            if ($item == 'GG_BITCORA_ADMIN')
            {
                return true;
            }
        }
        return $flag;
    }

    public function get_puesto()
    {
		// Bloquear acceso directo a la función o mediante URL en el navegador
		if($this->input->server('REQUEST_METHOD') != 'POST') {
			$this->session->sess_destroy();
			redirect('Login#SesionNoIniciada', 'refresh');
		}

        // Post fields required by OBTENER_PUESTO webservice
        $usuario = $this->input->post('usuario');

        // Initiate the cURL object (open connection)
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "http://vadaexterno:8080/wsAutEmp/Service1.asmx/OBTENER_PUESTO");       // URL to fetch
        curl_setopt($curl, CURLOPT_POST, TRUE);														// TRUE to do a regular HTTP POST (most commonly used by HTML forms)
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");											// Request type (POST, DELETE, GET, PUT, HEAD)
        curl_setopt($curl, CURLOPT_POSTFIELDS, "usuario=$usuario");                                 // Data to post passed as a urlencoded string or as an associative array
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);											// TRUE to return the transfer as a string of the return value

        // Submit the POST request and decode the returned JSON string as an array of objects
        $output = curl_exec($curl);
        $output = json_decode($output);

        // Close cURL session handle (close connection)
        curl_close($curl);

        $puesto = empty($output) ? 'Usuario no encontrado' : $output[0]->PUESTO;
        echo json_encode($puesto);
    }
}
?>