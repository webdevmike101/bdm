<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');

class Cd_model extends CI_Model{

	function __construct($cd){

		parrent::construct();

		$title = $cd['cd_title'];

	}

	function getCD(){

		
	}
}