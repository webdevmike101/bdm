<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_cds extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		session_start();
		if(!isset($_SESSION['userName']))
		{
			redirect('admin');
		}		
	}

	public function index()
	{		
		$data['title'] = "Edit CDs";
		$this->load->view('admin_header_view', $data);
		$this->load->view('edit_cds_view');
	}

	function insert_cd()
	{

		unset($_SESSION['errors']);
		unset($_SESSION['title']);
		unset($_SESSION['price']);
		unset($_SESSION['release_date']);
		unset($_SESSION['description']);
		unset($_SESSION['total_songs']);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'The Title', 'required');
		$this->form_validation->set_rules('price', 'The Price', 'required');
		$this->form_validation->set_rules('release_date', 'The Release Date', 'required');
		$this->form_validation->set_rules('total_songs', 'The Total Number of Songs', 'required|numeric');
		$this->form_validation->set_rules('description', 'The Description', 'required');

		if(empty($_FILES['userfile']['name']))
		{
			$this->form_validation->set_rules('userfile', 'An Image of the CD', 'required');
			$this->form_validation->set_message('required', '%s is required.');
		};

		if($this->form_validation->run()) // If the form validates
		{
			$this->load->model('cd_model');

			// If the insert fails
			if(!$this->cd_model->_insert())
			{
				$_SESSION['errors'] = "There was a problem adding the CD. Please contact the Website Administrator.";	
			}		
		}
		else // If the form doesn't validate
		{
			$_SESSION['errors'] = validation_errors();
		}

		// If there was any problem, send the user's input back to re-populate the input fields
		if($_SESSION['errors'])
		{
			$_SESSION['title'] = $this->input->post('title');
			$_SESSION['price'] = $this->input->post('price');
			$_SESSION['release_date'] = $this->input->post('release_date');
			$_SESSION['total_songs'] = $this->input->post('total_songs');
			$_SESSION['description'] = $this->input->post('description');
		}

		redirect('edit_cds');
	}
}