<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_cds extends CI_Controller 
{

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
		$this->load->model('Cd_model');
		$data['cds'] = $this->Cd_model->get_cd();
		$this->load->view('admin_header_view', $data);
		$this->load->view('edit_cds_view');
	}

	function insert_cd()
	{
		$action = "insert";
		$_SESSION['errors'] = "";
		$cdTitle = strtolower($this->input->post('title'));
		$num_songs = $this->input->post('total_songs');

		if(!is_dir('images/cds/'.$cdTitle))
		{
			mkdir('images/cds/'.$cdTitle);
		}

		$this->unset_session_data($num_songs);
		$this->setValidationRules($action, $num_songs);
 		// If the form vaildates, insert the CD information. Image first ////////////////////
 		/////////////////////////////////////////////////////////////////////////////////
		if($this->form_validation->run())
		{
			$imageUploadConfig = array(
				'image_library' => 'GD2',
				'upload_path'	=> 'images/cds/'.$cdTitle,
				'allowed_types'	=> 'gif|jpg|jpeg|png|tif'
			);

			$this->load->library('upload', $imageUploadConfig, 'image_upload');

			if($this->image_upload->do_upload('cd_image'))// cd_image is what codeigniter usualy refers to as userfile
			{
				// I need the image data to get the name of the CD image after it is uploaded.
				// I could get it from the POST, but if for some reason the user uploads an
				// image with the same name as one already in the images folder, the new image
				// will have a 1 added to the name which will make the "<image src=" incorrect. 
				$image_data = $this->image_upload->data();

				// Prepare to upload song clips
				if(!is_dir('music/clips/'.$cdTitle))
				{
					mkdir('music/clips/'.$cdTitle);
				}

				$clipsUploadConfig = array(
					'upload_path'	=> 'music/clips/'.$cdTitle,
					'allowed_types'	=> 'mp3'
				);				

				$this->load->library('upload', $clipsUploadConfig, 'clips_upload');
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////CHANGE THIS TO UPLOAD MULTIPLE FILES////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////

				foreach($_FILES as $key => $value)
				{
					if(strpos($key, 'song_clip') === 0)
					{
						if($this->clips_upload->do_upload($key))
							continue;
						else
							$_SESSION['errors'] = $this->upload->display_errors();
					}
				}
				if(!isset($_SESSION['errors']))
				{
					$this->load->model('cd_model');

					if(!$this->cd_model->_insert_cd($image_data))
					{
						$_SESSION['errors'] = "There was a problem adding the CD. Please contact the Website Administrator.";
					}
				}
				////////////////////////////////////////////////////////////////////////////////////////////////////////////				
				////////////////////////CHANGE THIS TO UPLOAD MULTIPLE FILES////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////								
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

		if(isset($_SESSION['errors']))
		{
			$_SESSION['title'] = $this->input->post('title');
			$_SESSION['price'] = $this->input->post('price');
			$_SESSION['release_date'] = $this->input->post('release_date');
			$_SESSION['total_songs'] = $this->input->post('total_songs');

			for($i = 1; $i <= $num_songs; $i++)
			{
				$_SESSION['song_'.$i] = $this->input->post('song_'.$i);
			}

			$_SESSION['description'] = $this->input->post('description');
		}

		redirect('edit_cds');
	}

	function update_cd(){

		$this->load->model('cd_model');
		$this->cd_model->_update_cd();

		// var_dump($_REQUEST);
		// 	var_dump($_FILES);
	}

	function setValidationRules($action, $num_songs)
	{
		// Set rules for all form input validation////////////////////////////////////////////
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'The Title', 'required');
		$this->form_validation->set_rules('price', 'The Price', 'required');
		$this->form_validation->set_rules('release_date', 'The Release Date', 'required');
		$this->form_validation->set_rules('total_songs', 'The Total Number of Songs', 'required|numeric');
		$this->form_validation->set_rules('description', 'The Description', 'required');

		for($i = 1; $i <= $num_songs; $i++)
		{
			$this->form_validation->set_rules('song_'.$i, 'Song '.$i. " Title", 'required');

			if($action == 'insert' && empty($_FILES['song_clip_'.$i]['name']))
			{
				$this->form_validation->set_rules('song_clip_'.$i, 'Song Clip '.$i, 'required');
			}
		}

		// The CI 'userfile' never validates, so I have to check $_FILES['userfile']['name'] and only set the 
		// validation rule for 'userfile' (or in this case, cd_image) if $_FILES['userfile']['name']) is empty.
		// The Library function 'upload' does its own validation, but I want to display all
		// errors to the user at once, and this happens before the image upload.
		if($action == 'insert' && empty($_FILES['cd_image']['name']))
		{
			$this->form_validation->set_rules('cd_image', 'An Image of the CD', 'required');
			$this->form_validation->set_message('required', '%s is required.');
		}
	}

	function unset_session_data($num_songs)
	{
		// Unset previous errors if there were any, so if there are none
		// this time, there won't be errors carried over in $_SESSION.
		unset($_SESSION['errors']);
		unset($_SESSION['title']);
		unset($_SESSION['price']);
		unset($_SESSION['release_date']);
		unset($_SESSION['description']);

		for($i = 1; $i <= $num_songs; $i++)
		{
			unset($_SESSION['song_'.$i]);
		}

		unset($_SESSION['total_songs']);
	}
}