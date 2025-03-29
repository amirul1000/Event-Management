<?php

/**
 * Author: Amirul Momenin
 * Desc:Events Model
 */
class Events_model extends CI_Model
{
	protected $events = 'events';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get events by id
	 *@param $id - primary key to get record
	 *
     */
    function get_events($id){
        $result = $this->db->get_where('events',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('events');
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
	
    /** Get all events
	 *
     */
    function get_all_events(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('events')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit events
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_events($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('events')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count events rows
	 *
     */
	function get_count_events(){
       $result = $this->db->from("events")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-events
	 *
     */
    function get_all_users_events(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('events')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-events
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_events($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('events')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-events rows
	 *
     */
	function get_count_users_events(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("events")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new events
	 *@param $params - data set to add record
	 *
     */
    function add_events($params){
        $this->db->insert('events',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update events
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_events($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('events',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete events
	 *@param $id - primary key to delete record
	 *
     */
    function delete_events($id){
        $status = $this->db->delete('events',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
