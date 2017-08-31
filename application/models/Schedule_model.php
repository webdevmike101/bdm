<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "upcomingperformance";
		return $table;
	}

	function get($order_by) {
		$table = $this->get_table();
		$this->db->order_by($order_by);
		$this->db->where('date >=', date('Y-m-d'));
		$query = $this->db->get($table);
		$results = $query->result_array(); // I had to add this to make it work now. It was just returning $query. I guess it's a mysqli/new-CI-version issue
		return $results;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$table = $this->get_table();
		$this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		$query = $this->db->get($table);
		return $query;
	}

	function get_where($id) {
		$table = $this->get_table();
		$this->db->where('id', $id);
		$query = $this->db->get($table);
		return $query;
	}

	function get_where_custom($col, $value) {
		$table = $this->get_table();
		$this->db->where($col, $value);
		$query = $this->db->get($table);
		return $query;
	}

	function _insert() {

		$data = array(
			'date'				=> $this->input->post('performance_date'),
			'time'				=> $this->input->post('performance_time'),
			'am_pm'				=> $this->input->post('am_pm'),
			'details'			=> $this->input->post('performance_details'),
			'venue'				=> $this->input->post('performance_venue'),
			'street_address'	=> $this->input->post('performance_address'),
			'city_province'		=> $this->input->post('performance_city'),
		);

		$table = $this->get_table();
		$this->db->insert($table, $data);
	}

	function _update() {

		$id = $this->input->post('post_id');

		$data = array(
			'date'				=> $this->input->post('post_date'),
			'time'				=> $this->input->post('post_time'),
			'am_pm'				=> $this->input->post('post_am_pm'),
			'details'			=> $this->input->post('post_details'),
			'venue'				=> $this->input->post('post_venue'),
			'street_address'	=> $this->input->post('post_address'),
			'city_province'		=> $this->input->post('post_city_province'),
		);

		$table = $this->get_table();
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		
		$varify = $this->get_where($id);
		$row = $varify->row();
		echo json_encode($row);
		//echo $this->db->affected_rows();

		
	}

	function _delete($id) {
		$table = $this->get_table();
		$this->db->where('id', $id);
		$this->db->delete($table);

		if($this->db->affected_rows() > 0){
			echo $id;
		}
		else{
			echo $this->db->affected_rows();
		}
	}

	function count_where($column, $value) {
		$table = $this->get_table();
		$this->db->where($column, $value);
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function count_all() {
		$table = $this->get_table();
		$query = $this->db->get($table);
		$num_rows = $query->num_rows();
		return $num_rows;
	}

	function get_max() {
		$table = $this->get_table();
		$this->db->select_max('id');
		$query = $this->db->get($table);
		$row = $query->row();
		$id = $row->id;
		return $id;
	}

	function _custom_query($mysql_query) {
		$query = $this->db->query($mysql_query);
		return $query;
	}
}