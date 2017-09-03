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