<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		// Call the parent class constructor
		parent::__construct();

		// Load the api_model
		$this->load->model('api_model');
	
		// Load the form_validation library
		$this->load->library('form_validation');
		
	}
	

	function index()
	{
		
		// Call the fetch_all() method of api_model to retrieve data
		$data = $this->api_model->fetch_all();
	
		// Convert the data to a plain PHP array using result_array() method
		$result_array = $data->result_array();
	
		// Encode the PHP array as JSON
		$json_data = json_encode($result_array);
	
		// Output the JSON data
		echo $json_data;
	}
	

	public function insert()
	{
		// Load form validation library
		$this->load->library('form_validation');
	
		// Set validation rules
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		
	
		// Check if form validation passes
		if ($this->form_validation->run() === TRUE)
		{
			// Form validation passed, proceed with inserting data
			$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name')
			);
	
			// Insert data into the database using the API model
			$this->api_model->insert_api($data);
	
			// Prepare success response
			$response = array(
				'success' => true
			);
		}
		else
		{
			// Form validation failed, prepare error response
			$response = array(
				'error' => true,
				'first_name_error' => form_error('first_name'),
				'last_name_error' => form_error('last_name')
			);
		}
	
		// Send JSON response
		echo json_encode($response);
	}
	
	function fetch_single()
	{
		if($this->input->post('id'))
		{
			$data = $this->api_model->fetch_single_user($this->input->post('id'));

			foreach($data as $row)
			{
				$output['first_name'] = $row['first_name'];
				$output['last_name'] = $row['last_name'];
			}
			echo json_encode($output);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'required');

		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		if($this->form_validation->run())
		{	
			$data = array(
				'first_name'		=>	$this->input->post('first_name'),
				'last_name'			=>	$this->input->post('last_name')
			);

			$this->api_model->update_api($this->input->post('id'), $data);

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'				=>	ture,
				'first_name_error'	=>	form_error('first_name'),
				'last_name_error'	=>	form_error('last_name')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->api_model->delete_single_user($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}

}


?>