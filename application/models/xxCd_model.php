<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cd_model extends CI_Model {

	function __construct() {

		parent::__construct();
	}

	function get_table() {
		$table = "cd";
		return $table;
	}

	function get() {

		$this->db->order_by('release_date desc');
		$cds = $this->db->get('cd');
		$cds_result = $cds->result_array();
		
		$this->db->order_by('song_number asc');
		$songs = $this->db->get('song');
		$songs_result = $songs->result_array();
		
		$results = array();
		
		foreach ($cds_result as $row){
			
			$results[$row['cd_id']] = array(
				
				'cd_id' 			=> $row['cd_id'],
				'cd_title' 			=> $row['cd_title'],
				'total_songs' 		=> $row['total_songs'],
				'description'		=> $row['description'],
				'image_name'		=> $row['image_name'],
				'price'				=> $row['price'],
				'release_date'		=> $row['release_date']
			);
		}
		
		foreach($songs_result as $row){
			
			array_push($results[$row['cd_id']], array(
					
						'song_title'	=> $row['song_title'],
						'song_number'	=> $row['song_number'],
						'clip_name'		=> $row['clip_name']				
				)				
			);		
		}

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

	function _insert($image_data) {

		$image_name	= $image_data['file_name'];
		$cd_title = $this->input->post('title');
		$price = $this->input->post('price');
		$release_date = $this->input->post('release_date');
		$total_songs = $this->input->post('total_songs');
		$description = $this->input->post('description');

		$song_data = array();

		for($i = 0; $i < $total_songs; $i++)
		{
			$song_title = $this->input->post('song_'.$i + 1);
			$clip_name = $_FILES[$i]['name'];

 			$song_data[$i] = array(

 				'song_title' 	=> (!empty($song_title)) ? $song_title : null,
 				'clip_name'		=> (!empty($clip_name)) ? $clip_name : null,
			);
		}

		$cd_data = array(

			// If the input is empty set it to null or there will be an empty
			// entry in the database. /////////////////////////////////////////
			'image_name'	=> (!empty($image_name)) ? $image_name : null,
			'cd_title'		=> (!empty($cd_title)) ? $cd_title : null,
			'price'			=> (!empty($price)) ? $price : null,
			'release_date'	=> (!empty($release_date)) ? $release_date : null,
			'total_songs'	=> (!empty($total_songs)) ? $total_songs : null,
			'description'	=> (!empty($description)) ? $description : null
		);

		$table = $this->get_table();
		
		if($this->db->insert($table, $cd_data))
		{
			return true;
		}
		else
		{
			return false;
		}
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