<?php

/**
 * Author: Amirul Momenin
 * Desc:Organizers Model
 */
class Organizers_model extends CI_Model
{
	protected $organizers = 'organizers';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get organizers by id
	 *@param $id - primary key to get record
	 *
     */
    function get_organizers($id){
        $result = $this->db->get_where('organizers',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('organizers');
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
	
    /** Get all organizers
	 *
     */
    function get_all_organizers(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('organizers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit organizers
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_organizers($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('organizers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count organizers rows
	 *
     */
	function get_count_organizers(){
       $result = $this->db->from("organizers")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-organizers
	 *
     */
    function get_all_users_organizers(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('organizers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-organizers
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_organizers($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('organizers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-organizers rows
	 *
     */
	function get_count_users_organizers(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("organizers")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new organizers
	 *@param $params - data set to add record
	 *
     */
    function add_organizers($params){
        $this->db->insert('organizers',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update organizers
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_organizers($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('organizers',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete organizers
	 *@param $id - primary key to delete record
	 *
     */
    function delete_organizers($id){
        $status = $this->db->delete('organizers',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
