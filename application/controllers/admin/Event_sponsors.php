<?php

 /**
 * Author: Amirul Momenin
 * Desc:Event_sponsors Controller
 *
 */
class Event_sponsors extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Event_sponsors_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of event_sponsors table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['event_sponsors'] = $this->Event_sponsors_model->get_limit_event_sponsors($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/event_sponsors/index');
		$config['total_rows'] = $this->Event_sponsors_model->get_count_event_sponsors();
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
		
        $data['_view'] = 'admin/event_sponsors/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save event_sponsors
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
'sponsor_name' => html_escape($this->input->post('sponsor_name')),
'amount' => html_escape($this->input->post('amount')),
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
			$data['event_sponsors'] = $this->Event_sponsors_model->get_event_sponsors($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Event_sponsors_model->update_event_sponsors($id,$params);
				$this->session->set_flashdata('msg','Event_sponsors has been updated successfully');
                redirect('admin/event_sponsors/index');
            }else{
                $data['_view'] = 'admin/event_sponsors/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $event_sponsors_id = $this->Event_sponsors_model->add_event_sponsors($params);
				$this->session->set_flashdata('msg','Event_sponsors has been saved successfully');
                redirect('admin/event_sponsors/index');
            }else{  
			    $data['event_sponsors'] = $this->Event_sponsors_model->get_event_sponsors(0);
                $data['_view'] = 'admin/event_sponsors/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details event_sponsors
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['event_sponsors'] = $this->Event_sponsors_model->get_event_sponsors($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/event_sponsors/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting event_sponsors
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $event_sponsors = $this->Event_sponsors_model->get_event_sponsors($id);

        // check if the event_sponsors exists before trying to delete it
        if(isset($event_sponsors['id'])){
            $this->Event_sponsors_model->delete_event_sponsors($id);
			$this->session->set_flashdata('msg','Event_sponsors has been deleted successfully');
            redirect('admin/event_sponsors/index');
        }
        else
            show_error('The event_sponsors you are trying to delete does not exist.');
    }
	
	/**
     * Search event_sponsors
	 * @param $start - Starting of event_sponsors table's index to get query
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
$this->db->or_like('sponsor_name', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['event_sponsors'] = $this->db->get('event_sponsors')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/event_sponsors/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('events_id', $key, 'both');
$this->db->or_like('sponsor_name', $key, 'both');
$this->db->or_like('amount', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("event_sponsors")->count_all_results();
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
		$data['_view'] = 'admin/event_sponsors/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export event_sponsors
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'event_sponsors_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $event_sponsorsData = $this->Event_sponsors_model->get_all_event_sponsors();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Events Id","Sponsor Name","Amount","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($event_sponsorsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $event_sponsors = $this->db->get('event_sponsors')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/event_sponsors/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Event_sponsors controller