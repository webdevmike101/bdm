<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cd_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "cd";
		return $table;
	}

	function get($order_by) {
		$table = $this->get_table();

		$this->db->select('cd_id, cd_title, release_date, price, image_path, total_songs, description');
		$this->db->order_by($order_by);
		$query = $this->db->get($table);
		$results = $query->result_array(); // I had to add this to make it work now. It was just returning $query. I guess it's a mysqli/new-CI-version issue
		


		foreach ($results as $r) {

			$array = array(
					$songTitle => (	$this->db->select('song_title');
									$this->db->where('cd_id', $r['cd.id']);
									$this->db->get('song');
								);

		}

		return $array;


		// $this->db->select('cd.cd_id, cd_title, release_date, song_title, song_number, price, image_path, total_songs, description');
		// $this->db->order_by($order_by);
		// $this->db->join('song', 'song.cd_id = cd.cd_id', 'left outer');
		// $query = $this->db->get($table);
		// $results = $query->result_array(); // I had to add this to make it work now. It was just returning $query. I guess it's a mysqli/new-CI-version issue
		
		// return $results;
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
			'image_path' 	=> $_FILES['userfile']['name'],
			'cd_title'		=> $this->input->post('title'),
			'price'			=> $this->input->post('price'),
			'release_date'	=> $this->input->post('release_date'),
			'total_songs'	=> $this->input->post('total_songs'),
			'description'	=> $this->input->post('description')
		);
		$table = $this->get_table();
		$this->db->insert($table, $data);
	}

	function _update($id, $data) {
		$table = $this->get_table();
		$this->db->where('id', $id);
		$this->db->update($table, $data);
	}

	function _delete($id) {
		$table = $this->get_table();
		$this->db->where('id', $id);
		$this->db->delete($table);
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