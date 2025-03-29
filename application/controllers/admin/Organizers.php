<?php

 /**
 * Author: Amirul Momenin
 * Desc:Organizers Controller
 *
 */
class Organizers extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->library('Customlib');
		$this->load->helper(array('cookie', 'url')); 
		$this->load->database();  
		$this->load->model('Organizers_model');
		if(! $this->session->userdata('validated')){
				redirect('admin/login/index');
		}  
    } 
	
    /**
	 * Index Page for this controller.
	 *@param $start - Starting of organizers table's index to get query
	 *
	 */
    function index($start=0){
		$limit = 10;
        $data['organizers'] = $this->Organizers_model->get_limit_organizers($limit,$start);
		//pagination
		$config['base_url'] = site_url('admin/organizers/index');
		$config['total_rows'] = $this->Organizers_model->get_count_organizers();
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
		
        $data['_view'] = 'admin/organizers/index';
        $this->load->view('layouts/admin/body',$data);
    }
	
	 /**
     * Save organizers
	 *@param $id - primary key to update
	 *
     */
    function save($id=-1){   
		 
		
		
		$params = array(
					 'organizer_name' => html_escape($this->input->post('organizer_name')),
'email' => html_escape($this->input->post('email')),
'phone' => html_escape($this->input->post('phone')),

				);
		 
		 
		$data['id'] = $id;
		//update		
        if(isset($id) && $id>0){
			$data['organizers'] = $this->Organizers_model->get_organizers($id);
            if(isset($_POST) && count($_POST) > 0){   
                $this->Organizers_model->update_organizers($id,$params);
				$this->session->set_flashdata('msg','Organizers has been updated successfully');
                redirect('admin/organizers/index');
            }else{
                $data['_view'] = 'admin/organizers/form';
                $this->load->view('layouts/admin/body',$data);
            }
        } //save
		else{
			if(isset($_POST) && count($_POST) > 0){   
                $organizers_id = $this->Organizers_model->add_organizers($params);
				$this->session->set_flashdata('msg','Organizers has been saved successfully');
                redirect('admin/organizers/index');
            }else{  
			    $data['organizers'] = $this->Organizers_model->get_organizers(0);
                $data['_view'] = 'admin/organizers/form';
                $this->load->view('layouts/admin/body',$data);
            }
		}
        
    } 
	
	/**
     * Details organizers
	 * @param $id - primary key to get record
	 *
     */
	function details($id){
        $data['organizers'] = $this->Organizers_model->get_organizers($id);
		$data['id'] = $id;
        $data['_view'] = 'admin/organizers/details';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Deleting organizers
	 * @param $id - primary key to delete record
	 *
     */
    function remove($id){
        $organizers = $this->Organizers_model->get_organizers($id);

        // check if the organizers exists before trying to delete it
        if(isset($organizers['id'])){
            $this->Organizers_model->delete_organizers($id);
			$this->session->set_flashdata('msg','Organizers has been deleted successfully');
            redirect('admin/organizers/index');
        }
        else
            show_error('The organizers you are trying to delete does not exist.');
    }
	
	/**
     * Search organizers
	 * @param $start - Starting of organizers table's index to get query
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
$this->db->or_like('organizer_name', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');


		$this->db->order_by('id', 'desc');
		
        $this->db->limit($limit,$start);
        $data['organizers'] = $this->db->get('organizers')->result_array();
		$db_error = $this->db->error();
		if (!empty($db_error['code'])){
			echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
			exit;
		}
		
		//pagination
		$config['base_url'] = site_url('admin/organizers/search');
		$this->db->reset_query();		
		$this->db->like('id', $key, 'both');
$this->db->or_like('organizer_name', $key, 'both');
$this->db->or_like('email', $key, 'both');
$this->db->or_like('phone', $key, 'both');

		$config['total_rows'] = $this->db->from("organizers")->count_all_results();
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
		$data['_view'] = 'admin/organizers/index';
        $this->load->view('layouts/admin/body',$data);
	}
	
    /**
     * Export organizers
	 * @param $export_type - CSV or PDF type 
     */
	function export($export_type='CSV'){
	  if($export_type=='CSV'){	
		   // file name 
		   $filename = 'organizers_'.date('Ymd').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   // get data 
		   $this->db->order_by('id', 'desc');
		   $organizersData = $this->Organizers_model->get_all_organizers();
		   // file creation 
		   $file = fopen('php://output', 'w');
		   $header = array("Id","Organizer Name","Email","Phone"); 
		   fputcsv($file, $header);
		   foreach ($organizersData as $key=>$line){ 
			 fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
	  }else if($export_type=='Pdf'){
		    $this->db->order_by('id', 'desc');
		    $organizers = $this->db->get('organizers')->result_array();
		   // get the HTML
			ob_start();
			include(APPPATH.'views/admin/organizers/print_template.php');
			$html = ob_get_clean();
			require_once FCPATH.'vendor/autoload.php';			
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->WriteHTML($html);
			$mpdf->Output();
			exit;
	  }
	   
	}
}
//End of Organizers controller