<?php

 /**
 * Author: Amirul Momenin
 * Desc:Venues Controller
 *
 */
class Venues extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Venues_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of venues table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['venues'] = $this->Venues_model->get_limit_venues($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/venues/index');
		$config['total_rows'] = $this->Venues_model->get_count_venues();
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
		
        $data['_view'] = 'admin/venues/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save venues
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'venue_name' => html_escape($this->input->post('venue_name')),
'location' => html_escape($this->input->post('location')),
'capacity' => html_escape($this->input->post('capacity')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['venues'] = $this->Venues_model->get_venues($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Venues_model->update_venues($id,$params);
				$this->session->set_flashdata('msg','Venues has been updated successfully');
                redirect('admin/venues/index');
            }else{
                $data['_view'] = 'admin/venues/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $venues_id = $this->Venues_model->add_venues($params);
				$this->session->set_flashdata('msg','Venues has been saved successfully');
                redirect('admin/venues/index');
            }else{  
			    $data['venues'] = $this->Venues_model->get_venues(0);
                $data['_view'] = 'admin/venues/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details venues
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['venues'] = $this->Venues_model->get_venues($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/venues/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting venues
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $venues = $this->Venues_model->get_venues($id);

        // check if the venues exists before trying to delete it
        if(isset($venues['id'])){
            $this->Venues_model->delete_venues($id);
			$this->session->set_flashdata('msg','Venues has been deleted successfully');
            redirect('admin/venues/index');
        }
        else
            show_error('The venues you are trying to delete does not exist.');
    }
	
	/**
     * Search venues
	 * @param $start - Starting of venues table's index to get query
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
$this->db->or_like('venue_name', $key, 'both');
$this->db->or_like('location', $key, 'both');
$this->db->or_like('capacity', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['venues'] = $this->db->get('venues')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/venues/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('venue_name', $key, 'both');
$this->db->or_like('location', $key, 'both');
$this->db->or_like('capacity', $key, 'both');

		$config['total_rows'] = $this->db->from("venues")->count_all_results();
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
		$data['_view'] = 'admin/venues/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export venues
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'venues_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $venuesData = $this->Venues_model->get_all_venues();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Venue Name","Location","Capacity"); 
		   fputcsv($file, $header);
		   foreach ($venuesData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $venues = $this->db->get('venues')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/venues/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Venues controller