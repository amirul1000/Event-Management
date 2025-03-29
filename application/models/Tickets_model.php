<?php

/**
 * Author: Amirul Momenin
 * Desc:Tickets Model
 */
class Tickets_model extends CI_Model
{
	protected $tickets = 'tickets';
	
    function __construct(){
        parent::__construct();
    }
	
    /** Get tickets by id
	 *@param $id - primary key to get record
	 *
     */
    function get_tickets($id){
        $result = $this->db->get_where('tickets',array('id'=>$id))->row_array();
		if(!(array)$result){
			$fields = $this->db->list_fields('tickets');
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
	
    /** Get all tickets
	 *
     */
    function get_all_tickets(){
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('tickets')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit tickets
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_tickets($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('tickets')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count tickets rows
	 *
     */
	function get_count_tickets(){
       $result = $this->db->from("tickets")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	
	 /** Get all users-tickets
	 *
     */
    function get_all_users_tickets(){
        $this->db->order_by('id', 'desc');
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('tickets')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
	/** Get limit users-tickets
	 *@param $limit - limit of query , $start - start of db table index to get query
	 *
     */
    function get_limit_users_tickets($limit, $start){
		$this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
		$this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('tickets')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** Count users-tickets rows
	 *
     */
	function get_count_users_tickets(){
	   $this->db->where('users_id', $this->session->userdata('id'));
       $result = $this->db->from("tickets")->count_all_results();
	   $db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $result;
    }
	
    /** function to add new tickets
	 *@param $params - data set to add record
	 *
     */
    function add_tickets($params){
        $this->db->insert('tickets',$params);
        $id = $this->db->insert_id();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $id;
    }
	
    /** function to update tickets
	 *@param $id - primary key to update record,$params - data set to add record
	 *
     */
    function update_tickets($id,$params){
        $this->db->where('id',$id);
        $status = $this->db->update('tickets',$params);
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
	
    /** function to delete tickets
	 *@param $id - primary key to delete record
	 *
     */
    function delete_tickets($id){
        $status = $this->db->delete('tickets',array('id'=>$id));
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		return $status;
    }
}
