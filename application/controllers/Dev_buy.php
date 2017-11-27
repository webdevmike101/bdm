<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dev_buy extends CI_Controller {

	public function index()
	{
		$data['title'] = "Purchase Brian Dorsey's Music";
		$this->load->model('Cd_model');
		$data['cds'] = $this->Cd_model->get_cd();
		$this->load->view('header_view', $data);
		$this->load->view('dev_buy_view');
		$this->load->view('footer_view');
	}
}