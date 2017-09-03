<<<<<<< HEAD
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
		$this->load->view('edit_cds_view', array('msg' => ''));
	}

	function insert_cd()
	{
		$this->load->model('cd_model');
		$this->cd_model->_insert();
		// redirect('edit_cds');
	}
}

=======
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
		unset($_SESSION['songTitles']);
		unset($_SESSION['errors']);
		unset($_SESSION['title']);
		unset($_SESSION['price']);
		unset($_SESSION['release_date']);
		unset($_SESSION['total_songs']);
		unset($_SESSION['description']);
		unset($_SESSION['songTitles']);

		$num_songs = $this->input->post('total_songs');
		$songTitles = array();

		$this->load->library('form_validation');	

		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required');
		$this->form_validation->set_rules('release_date', 'Release Date', 'required');
		$this->form_validation->set_rules('total_songs', 'Total Number of Songs', 'required|numeric');

		for($i = 1; $i <= $num_songs; $i++)
		{
			$songTitles[] = $this->input->post('song_'. $i);
			$this->form_validation->set_rules('song_'. $i, 'Song '. $i, 'required');
		};	


		$this->form_validation->set_rules('description', 'Description', 'required');
		if(empty($_FILES['userfile']['name']))// I don't know why it's ['userfile']['name'], but it is.
		{
			$this->form_validation->set_rules('userfile', 'Image', 'required');
		}

		if($this->form_validation->run() !== false)
		{
			$this->load->model('cd_model');
			$this->cd_model->_insertCD();			
		}
		else
		{
			$_SESSION['errors'] = validation_errors();
			$_SESSION['title'] = $this->input->post('title');
			$_SESSION['price'] = $this->input->post('price');
			$_SESSION['release_date'] = $this->input->post('release_date');
			$_SESSION['total_songs'] = $this->input->post('total_songs');
			$_SESSION['description'] = $this->input->post('description');
			$_SESSION['songTitles'] = $songTitles;
		}

		redirect('edit_cds');
	}
}


>>>>>>> 428131f37fe5cd236ee98daffe31b1b452107c3b
