<?php

/**
 * Author: Amirul Momenin
 * Desc:Attendees Model
 */
class Attendees_model extends CI_Model
{
	protected $attendees = 'attendees';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get attendees by id
	 *@param $id - primary key to get record
	 *
     */
    function get_attendees($id){
        $result = $this->db->get_where('attendees',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('attendees');
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
	
    /** Get all attendees
	 *
     */
    function get_all_attendees(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('attendees')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit attendees
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_attendees($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('attendees')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count attendees rows
	 *
     */
	function get_count_attendees(){
       $result = $this->db->from("attendees")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-attendees
	 *
     */
    function get_all_users_attendees(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('attendees')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-attendees
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_attendees($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('attendees')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-attendees rows
	 *
     */
	function get_count_users_attendees(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("attendees")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new attendees
	 *@param $params - data set to add record
	 *
     */
    function add_attendees($params){
        $this->db->insert('attendees',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update attendees
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_attendees($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('attendees',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete attendees
	 *@param $id - primary key to delete record
	 *
     */
    function delete_attendees($id){
        $status = $this->db->delete('attendees',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
