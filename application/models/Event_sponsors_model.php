<?php

/**
 * Author: Amirul Momenin
 * Desc:Event_sponsors Model
 */
class Event_sponsors_model extends CI_Model
{
	protected $event_sponsors = 'event_sponsors';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get event_sponsors by id
	 *@param $id - primary key to get record
	 *
     */
    function get_event_sponsors($id){
        $result = $this->db->get_where('event_sponsors',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('event_sponsors');
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
	
    /** Get all event_sponsors
	 *
     */
    function get_all_event_sponsors(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('event_sponsors')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit event_sponsors
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_event_sponsors($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('event_sponsors')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count event_sponsors rows
	 *
     */
	function get_count_event_sponsors(){
       $result = $this->db->from("event_sponsors")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-event_sponsors
	 *
     */
    function get_all_users_event_sponsors(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('event_sponsors')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-event_sponsors
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_event_sponsors($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('event_sponsors')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-event_sponsors rows
	 *
     */
	function get_count_users_event_sponsors(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("event_sponsors")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new event_sponsors
	 *@param $params - data set to add record
	 *
     */
    function add_event_sponsors($params){
        $this->db->insert('event_sponsors',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update event_sponsors
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_event_sponsors($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('event_sponsors',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete event_sponsors
	 *@param $id - primary key to delete record
	 *
     */
    function delete_event_sponsors($id){
        $status = $this->db->delete('event_sponsors',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
