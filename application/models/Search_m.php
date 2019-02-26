<?php
class Search_m extends CI_Model {

	public function getMasterweb()
	{
		// Post fields required by BUSCAMW webservice
		$userid = $this->input->post('userid');
		$keyword = $this->input->post('keyword');

		// Initiate the cURL object (open connection)
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, "http://vadaexterno:8080/wsAutEmp/Service1.asmx/BUSCAMW");		// URL to fetch
		curl_setopt($curl, CURLOPT_POST, TRUE);															// TRUE to do a regular HTTP POST (most commonly used by HTML forms)
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");												// Request type (POST, DELETE, GET, PUT, HEAD)
		curl_setopt($curl, CURLOPT_POSTFIELDS, "USUARIOID=$userid&BUSCAR=$keyword");					// Data to post passed as a urlencoded string or as an associative array
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);												// TRUE to return the transfer as a string of the return value

		// Submit the POST request and decode the returned JSON string as an array
		$output = curl_exec($curl);
		$output = json_decode($output);

		// Close cURL session handle (close connection)
		curl_close($curl);

		return is_null($output) ? json_decode("{}") : $output;
	}
}
?>