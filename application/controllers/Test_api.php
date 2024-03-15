<?php
 header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');


class Test_api extends CI_Controller {

	public function index($offset = 0)
	{

		$this->load->library('pagination');
	
		$config['base_url'] = base_url() . 'Test_api/index';
		$config['total_rows'] = $this->db->count_all('tbl_sample');
		$config['per_page'] = 3;
		$config['uri_segment'] = 3;
	
		$this->pagination->initialize($config);
	
		$data['results'] = $this->db->get('tbl_sample', $config['per_page'], $offset)->result();
	
		$this->load->view('api_view', $data);
	}


	

	function action()
	{
		if($this->input->post('data_action'))
		{
			$data_action = $this->input->post('data_action');

			if($data_action == "Delete")
			{
				$api_url = "http://localhost/create-crud-rest-api-in-codeigniter-step-by-two/api/delete";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;




			}

			if($data_action == "Edit")
			{
				$api_url = "http://localhost/create-crud-rest-api-in-codeigniter-step-by-two/api/update";

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name'),
					'id'				=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;







			}

			if($data_action == "fetch_single")
			{
				$api_url = "http://localhost/create-crud-rest-api-in-codeigniter-step-by-two/api/fetch_single";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;






			}

			if($data_action == "Insert")
			{
				$api_url = "http://localhost/create-crud-rest-api-in-codeigniter-step-by-two/api/insert";
			

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name')
				);

				$client = curl_init($api_url);

				curl_setopt($client, CURLOPT_POST, true);

				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);

				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

				$response = curl_exec($client);

				curl_close($client);

				echo $response;


			}





			if ($data_action == "fetch_all") {
				$api_url = "http://localhost/create-crud-rest-api-in-codeigniter-step-by-two/api";
			
				$client = curl_init($api_url);
			
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			
				$response = curl_exec($client);
			
				curl_close($client);
			
				// Decode JSON response
				$result = json_decode($response);
			
				// Output the decoded JSON data for debugging
				var_dump($result);
			
				// Rest of your code for generating HTML output
				$output = '';
			
				if (count($result) > 0) {
					foreach ($result as $row) {
						$output .= '
						<tr>
							<td>' . $row->first_name . '</td>
							<td>' . $row->last_name . '</td>
							<td><button type="button" name="edit" class="btn btn-warning btn-xs edit" id="' . $row->id . '">Edit</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="' . $row->id . '">Delete</button></td>
						</tr>';
					}
				} else {
					$output .= '
					<tr>
						<td colspan="4" align="center">No Data Found</td>
					</tr>';
				}
			
				echo $output;
			}
			
		}
	}
	
}

?>