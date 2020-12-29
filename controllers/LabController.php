<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LabController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lab_model','lab');
		$this->load->model('Lookup_model','lookup');
		$this->load->library('form_validation');
		$this->load->library('pdf');	
		$this->load->library('pdf_report');	 
		$this->load->helper('url');
		 $this->load->library(['auth']);
	    $this->auth->route_access(); 
	}

	public function index()
	{
		$data=array();		
		$this->template->set('title', 'Lab Result');  	
		$data['reason_for_testing'] = $this->lookup->get_reason_for_testing(); 
		$this->template->load('default_layout', 'contents' , 'lab_view',$data);
	}

	public function getLabResult()
	{
			$can_approve="disabled";
			$can_print="disabled";
			if($this->auth->can('print_lab_result'))
				{
					$can_print="";					
				}
				if($this->auth->can('approve_lab_result'))
				{
					$can_approve="";					
				}

		$list = $this->lab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lab) {
			$no++;
			$row = array();
			$row[] = $lab->barcode_number;
			$row[] = $lab->first_name.' '. $lab->father_name.' '. $lab->grand_father_name;
			$row[] = $lab->passport_number;
			$row[] = $lab->hospital_name;
			$row[] = $lab->test_result_with;
			$row[] = $lab->result;
			$row[] = $lab->date;	
			//add html for action
			if($lab->result_approved==0)
			{
          $row[] = '<a class="btn btn-sm btn-danger '.$can_approve.'" href="javascript:void(0)" title="Approve" 
			onclick="approve_lab_result('."'".$lab->result_id."'".')"><i class="glyphicon glyphicon-info"></i> Approve</a>
			';
			}
			else{

				$row[]='<a class="btn btn-sm btn-secondary '.$can_print.'" href="'.base_url().'LabController/print_lab_result/'.$lab->id.' ">
				               <i class="glyphicon glyphicon-print"></i>  Print</a>
				    			   ';
			}
			/*  <a class="btn btn-sm btn-primary" href="'.base_url().'LabController/generate_pdf/'.$lab->id.'">Barcode</a>
 */
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->lab->count_all(),
						"recordsFiltered" => $this->lab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function print_lab_result($id)
	{
           	//$data = $this->lab->get_LabReport_by_id($id);	
		  // echo json_encode($data);
		    $html_content = '<img src="http://localhost/covid/assets//images//icmclogo.png"/>';
			$html_content .= $this->lab->get_LabReport_by_id($id);
			$this->pdf->loadHtml($html_content);


		    	$this->pdf->render();
			   $this->pdf->stream("".$id.".pdf", array("Attachment"=>0)); 


	}
     public function approve_lab_result($id)
	{
		$approvedBy=$this->session->userdata('userID');
		$this->lab->approve_lab_result($id,$approvedBy);		
		echo json_encode(array("status" => TRUE));
	}

	public function generate_pdf($id) {
	//	$html_content = '<img src="'.base_url().'assets/images/icmclogo.png"/>';
			$data['data']= $this->lab->get_LabReport_by_idd($id);
            $this->load->view('lab_report_view',$data);
}
}