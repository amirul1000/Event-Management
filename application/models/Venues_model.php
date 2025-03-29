<?php

/**
 * Author: Amirul Momenin
 * Desc:Venues Model
 */
class Venues_model extends CI_Model
{
	protected $venues = 'venues';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get venues by id
	 *@param $id - primary key to get record
	 *
     */
    function get_venues($id){
        $result = $this->db->get_where('venues',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('venues');
			foreach ($fields as $field)
			{
			   $result[$field] = ''; 	  
			}
		}
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    } 
	
    /** Get all venues
	 *
     */
    function get_all_venues(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('venues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit venues
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_venues($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('venues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count venues rows
	 *
     */
	function get_count_venues(){
       $result = $this->db->from("venues")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-venues
	 *
     */
    function get_all_users_venues(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('venues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-venues
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_venues($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('venues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-venues rows
	 *
     */
	function get_count_users_venues(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("venues")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new venues
	 *@param $params - data set to add record
	 *
     */
    function add_venues($params){
        $this->db->insert('venues',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update venues
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_venues($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('venues',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete venues
	 *@param $id - primary key to delete record
	 *
     */
    function delete_venues($id){
        $status = $this->db->delete('venues',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
