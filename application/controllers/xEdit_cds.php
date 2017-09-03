<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_cds extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		// session_stop();
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

		$num_songs = $this->input->post('total_songs');

		for($i = 1; $i <= $num_songs; $i++)
		{
			unset($_SESSION['song_'.$i]);
			unset($_SESSION['song_clip_'.$i]);
		}

		unset($_SESSION['total_songs']);
		unset($_SESSION['cd_image']);

		

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_rules('release_date', 'Release Date', 'required');
		$this->form_validation->set_rules('total_songs', 'Total Number of Songs', 'required|numeric');

		for($i = 1; $i <= $num_songs; $i++)
		{
			$this->form_validation->set_rules('song_'.$i, 'Song '.$i. " Title", 'required');
			$this->form_validation->set_rules('song_clip_'.$i, 'Song Clip '.$i, 'required');
		}

		$this->form_validation->set_rules('userfile', 'Image', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');

		if(true)
		{
			$this->load->model('cd_model');
			if($this->cd_model->_insert())
			{
				echo"<script type=text/javascript> alert('success!'); </script>";
			}			
		}
		else
		{
			$_SESSION['errors'] = validation_errors();
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
			$_SESSION['cd_image'] = $this->input->post('cd_image');
		}

		redirect('edit_cds');
	}
}


