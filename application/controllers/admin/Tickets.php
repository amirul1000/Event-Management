<?php

 /**
 * Author: Amirul Momenin
 * Desc:Tickets Controller
 *
 */
class Tickets extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Tickets_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of tickets table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['tickets'] = $this->Tickets_model->get_limit_tickets($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/tickets/index');
		$config['total_rows'] = $this->Tickets_model->get_count_tickets();
		$config['per_page'] = 10;
		//Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';		
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
        $data['_view'] = 'admin/tickets/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save tickets
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		$created_at = "";
$updated_at = "";

		if($id<=0){
															 $created_at = date("Y-m-d H:i:s");
														 }
else if($id>0){
															 $updated_at = date("Y-m-d H:i:s");
														 }

		$params = array(
					 'events_id' => html_escape($this->input->post('events_id')),
'attendees_id' => html_escape($this->input->post('attendees_id')),
'ticket_type' => html_escape($this->input->post('ticket_type')),
'price' => html_escape($this->input->post('price')),
'purchase_date' => html_escape($this->input->post('purchase_date')),
'created_at' =>$created_at,
'updated_at' =>$updated_at,

				);
		 
		if($id>0){
							                        unset($params['created_at']);
						                          }if($id<=0){
							                        unset($params['updated_at']);
						                          } 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['tickets'] = $this->Tickets_model->get_tickets($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Tickets_model->update_tickets($id,$params);
				$this->session->set_flashdata('msg','Tickets has been updated successfully');
                redirect('admin/tickets/index');
            }else{
                $data['_view'] = 'admin/tickets/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $tickets_id = $this->Tickets_model->add_tickets($params);
				$this->session->set_flashdata('msg','Tickets has been saved successfully');
                redirect('admin/tickets/index');
            }else{  
			    $data['tickets'] = $this->Tickets_model->get_tickets(0);
                $data['_view'] = 'admin/tickets/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details tickets
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['tickets'] = $this->Tickets_model->get_tickets($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/tickets/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting tickets
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $tickets = $this->Tickets_model->get_tickets($id);

        // check if the tickets exists before trying to delete it
        if(isset($tickets['id'])){
            $this->Tickets_model->delete_tickets($id);
			$this->session->set_flashdata('msg','Tickets has been deleted successfully');
            redirect('admin/tickets/index');
        }
        else
            show_error('The tickets you are trying to delete does not exist.');
    }
	
	/**
     * Search tickets
	 * @param $start - Starting of tickets table's index to get query
     */
	function search($start=0){
		if(!empty($this->input->post('key'))){
			$key =$this->input->post('key');
			$_SESSION['key'] = $key;
		}else{
			$key = $_SESSION['key'];
		}
		
		$limit = 10;		
		$this->db->like('id', $key, 'both');
$this->db->or_like('events_id', $key, 'both');
$this->db->or_like('attendees_id', $key, 'both');
$this->db->or_like('ticket_type', $key, 'both');
$this->db->or_like('price', $key, 'both');
$this->db->or_like('purchase_date', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['tickets'] = $this->db->get('tickets')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/tickets/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('events_id', $key, 'both');
$this->db->or_like('attendees_id', $key, 'both');
$this->db->or_like('ticket_type', $key, 'both');
$this->db->or_like('price', $key, 'both');
$this->db->or_like('purchase_date', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("tickets")->count_all_results();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		$config['per_page'] = 10;
		// Bootstrap 4 Pagination fix
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
		$config['next_tag_close']   = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']   = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close']  = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']   = '</span></li>';
		$this->pagination->initialize($config);
        $data['link'] =$this->pagination->create_links();
		
		$data['key'] = $key;
		$data['_view'] = 'admin/tickets/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export tickets
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'tickets_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $ticketsData = $this->Tickets_model->get_all_tickets();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Events Id","Attendees Id","Ticket Type","Price","Purchase Date","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($ticketsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $tickets = $this->db->get('tickets')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/tickets/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Tickets controller