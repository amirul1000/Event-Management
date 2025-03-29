<?php

/**
 * Author: Amirul Momenin
 * Desc:Event_staff Model
 */
class Event_staff_model extends CI_Model
{
	protected $event_staff = 'event_staff';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get event_staff by id
	 *@param $id - primary key to get record
	 *
     */
    function get_event_staff($id){
        $result = $this->db->get_where('event_staff',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('event_staff');
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
	
    /** Get all event_staff
	 *
     */
    function get_all_event_staff(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('event_staff')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit event_staff
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_event_staff($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('event_staff')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count event_staff rows
	 *
     */
	function get_count_event_staff(){
       $result = $this->db->from("event_staff")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-event_staff
	 *
     */
    function get_all_users_event_staff(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('event_staff')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-event_staff
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_event_staff($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('event_staff')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-event_staff rows
	 *
     */
	function get_count_users_event_staff(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("event_staff")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new event_staff
	 *@param $params - data set to add record
	 *
     */
    function add_event_staff($params){
        $this->db->insert('event_staff',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update event_staff
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_event_staff($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('event_staff',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete event_staff
	 *@param $id - primary key to delete record
	 *
     */
    function delete_event_staff($id){
        $status = $this->db->delete('event_staff',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
