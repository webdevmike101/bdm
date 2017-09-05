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
		// Unset previous errors if there were any, so if there are none /////////////////
		// this time, there won't be errors carried over in $_SESSION. ///////////////////
		unset($_SESSION['errors']);
		unset($_SESSION['title']);
		unset($_SESSION['price']);
		unset($_SESSION['release_date']);
		unset($_SESSION['description']);

		$num_songs = $this->input->post('total_songs');

		for($i = 1; $i <= $num_songs; $i++)
		{
			unset($_SESSION['song_'.$i]);
			unset($_SESSION['song_clip_'.$i]);
		}

		unset($_SESSION['total_songs']);
		/////////////////////////////////////////////////////////////////////////////////////

		// // Validate all form input. //////////////////////////////////////////////////////
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'The Title', 'required');
		$this->form_validation->set_rules('price', 'The Price', 'required');
		$this->form_validation->set_rules('release_date', 'The Release Date', 'required');
		$this->form_validation->set_rules('total_songs', 'The Total Number of Songs', 'required|numeric');

		for($i = 1; $i <= $num_songs; $i++)
		{
			$this->form_validation->set_rules('song_'.$i, 'Song '.$i. " Title", 'required');
			$this->form_validation->set_rules('song_clip_'.$i, 'Song Clip '.$i, 'required');
		}

		$this->form_validation->set_rules('description', 'The Description', 'required');

		// The CI userfile never validates, so I have to check $_FILES['userfile']['name'] and
		// only set the validation rule for userfile if $_FILES['userfile']['name']) is empty.
		if(empty($_FILES['userfile']['name']))
		{
			$this->form_validation->set_rules('userfile', 'An Image of the CD', 'required');
			$this->form_validation->set_message('required', '%s is required.');
		};
		/////////////////////////////////////////////////////////////////////////////////////

 		// If the form vaildates, insert the CD information. Image first ///////////////////
		if($this->form_validation->run())
		{
			// Set up the image upload configuration.
			$uploadConfig = array(
				'image_library' => 'GD2',
				'upload_path'	=> 'images/cds/',
				'allowed_types'	=> 'gif|jpg|jpeg|png'
			);

			// Upload the CD image to the images folder ///////////////////////////////////////
			$this->load->library('upload', $uploadConfig);
			// If the image upload is successful, insert the CD information. //////////////////
			if($this->upload->do_upload()) // The CI do_upload function already looks for "userfile" as passed from the view.
			{
				// Get the image data for the image_path value in the insert
				$image_data = $this->upload->data();

				$this->load->model('cd_model'	);

				// Insert the CD information.
				// If the insert fails, set the errors key in $_SESSION. ///////////////////////
				if(!$this->cd_model->_insert($image_data))
				{
					$_SESSION['errors'] = "There was a problem adding the CD. Please contact the Website Administrator.";	
				}	
			}
			else
			{
				$_SESSION['errors'] = $this->upload->display_errors();
			}
		}
		else // If the form doesn't validate, set an errors var in $_SESSION. /////////////
		{
			$_SESSION['errors'] = validation_errors();
		}

		// If there was any problem at all with the insert or file upload, ///////////////
		// send the user's input back to re-populate the input fields. ////////////////////
		if($_SESSION['errors'])
		{
			$_SESSION['title'] = $this->input->post('title');
			$_SESSION['price'] = $this->input->post('price');
			$_SESSION['release_date'] = $this->input->post('release_date');
			$_SESSION['total_songs'] = $this->input->post('total_songs');

			for($i = 1; $i <= $num_songs; $i++)
			{
				$_SESSION['song_'.$i] = $this->input->post('song_'.$i);
				$_SESSION['song_clip_'.$i] = $this->input->post('song_clip_'.$i);
			}

			$_SESSION['description'] = $this->input->post('description');
		}

		redirect('edit_cds');
	}
}