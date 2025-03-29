<?php

 /**
 * Author: Amirul Momenin
 * Desc:Events Controller
 *
 */
class Events extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Events_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of events table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['events'] = $this->Events_model->get_limit_events($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/events/index');
		$config['total_rows'] = $this->Events_model->get_count_events();
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
		
        $data['_view'] = 'admin/events/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save events
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
					 'event_name' => html_escape($this->input->post('event_name')),
'event_date' => html_escape($this->input->post('event_date')),
'venues_id' => html_escape($this->input->post('venues_id')),
'organizers_id' => html_escape($this->input->post('organizers_id')),
'description' => html_escape($this->input->post('description')),
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
			$data['events'] = $this->Events_model->get_events($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Events_model->update_events($id,$params);
				$this->session->set_flashdata('msg','Events has been updated successfully');
                redirect('admin/events/index');
            }else{
                $data['_view'] = 'admin/events/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $events_id = $this->Events_model->add_events($params);
				$this->session->set_flashdata('msg','Events has been saved successfully');
                redirect('admin/events/index');
            }else{  
			    $data['events'] = $this->Events_model->get_events(0);
                $data['_view'] = 'admin/events/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details events
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['events'] = $this->Events_model->get_events($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/events/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting events
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $events = $this->Events_model->get_events($id);

        // check if the events exists before trying to delete it
        if(isset($events['id'])){
            $this->Events_model->delete_events($id);
			$this->session->set_flashdata('msg','Events has been deleted successfully');
            redirect('admin/events/index');
        }
        else
            show_error('The events you are trying to delete does not exist.');
    }
	
	/**
     * Search events
	 * @param $start - Starting of events table's index to get query
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
$this->db->or_like('event_name', $key, 'both');
$this->db->or_like('event_date', $key, 'both');
$this->db->or_like('venues_id', $key, 'both');
$this->db->or_like('organizers_id', $key, 'both');
$this->db->or_like('description', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['events'] = $this->db->get('events')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/events/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('event_name', $key, 'both');
$this->db->or_like('event_date', $key, 'both');
$this->db->or_like('venues_id', $key, 'both');
$this->db->or_like('organizers_id', $key, 'both');
$this->db->or_like('description', $key, 'both');
$this->db->or_like('created_at', $key, 'both');
$this->db->or_like('updated_at', $key, 'both');

		$config['total_rows'] = $this->db->from("events")->count_all_results();
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
		$data['_view'] = 'admin/events/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export events
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'events_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $eventsData = $this->Events_model->get_all_events();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Event Name","Event Date","Venues Id","Organizers Id","Description","Created At","Updated At"); 
		   fputcsv($file, $header);
		   foreach ($eventsData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $events = $this->db->get('events')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/events/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Events controller