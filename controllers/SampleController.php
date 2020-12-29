<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SampleController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
        $this->auth->route_access();
		$this->load->model('Sample_model','sample');
		$this->load->model('Lookup_model','lookup');
		$this->load->library('form_validation');		 
		$this->load->helper('url');
	
	}

	public function index()
	{
		$data=array();		
		 $this->template->set('title', 'Patient/Sample');  	
		 $data['reason_for_testing'] = $this->lookup->get_reason_for_testing();
		  $data['users'] = $this->lookup->get_users();
        //  $data['location'] = $this->lookup->get_locations(); 
        //  $data['specimen_type'] = $this->lookup->get_specimen_type();
        //  $data['draw_type'] = $this->lookup->get_draw_types();
         
		  $this->template->load('default_layout', 'contents' , 'sample_view',$data);
	}

	public function getSampleList()
	{
			$canAddSample="disabled";
			$canEnterResult="disabled";
			if($this->auth->can('add-sample'))
				{
					$canAddSample="";					
				}
				if($this->auth->can('add_lab_result'))
				{
					$canEnterResult="";					
				}
		$list = $this->sample->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sample) {
			$no++;
			$row = array();
			$row[] = $sample->sample_id;
			$row[] = $sample->first_name.' '. $sample->father_name.' '. $sample->grand_father_name;		
		    $row[] = $sample->hospital_name;
			$row[] = $sample->sample_collection_date;
			$row[] = $sample->travel_status;    
			//add html for action
			if($sample->sc_id>0)
			{
			
	             $row[] = '<a class="btn btn-sm btn-primary '.$canAddSample.'" href="javascript:void(0)" title="Collect Patient Sample" onclick="edit_sample('."'".$sample->sample_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Take Sample</a>
				
	     <a class="btn btn-sm btn-primary '.$canEnterResult.'" href="javascript:void(0)" title="Enter Lab Result" onclick="edit_lab_result('."'".$sample->sample_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Enter Result </a>
				</a>';
			}
			else{
	$row[] = '<a class="btn btn-sm btn-primary '.$canAddSample.'" href="javascript:void(0)" title="Collect Patient Sample" onclick="edit_sample('."'".$sample->sample_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Take Sample</a>';
			}
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sample->count_all(),
						"recordsFiltered" => $this->sample->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		 // Get output html
      
	}
public function printLabResult()
{
	// Get output html
        $html = $this->output->get_output();
         
        // Load library
        $this->load->library('dompdf_gen');
         
        // Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("welcome.pdf",array('Attachment'=>0));
        //or without preview in browser
        //$this->dompdf->stream("welcome.pdf");
}
	public function editSample($id)
	{
		$data = $this->sample->get_by_id($id);			
		echo json_encode($data);
	}
	public function editLabResult($id)
	{
		$data = $this->sample->get_result_by_id($id);	
		echo json_encode($data);
	}

	public function updateSample()
	{	
   $sampledata = array(  
	'sc_id'=> $this->input->post('sc_id'),
	'lab_sample_id'=> trim($this->input->post('sample_id')),  
    'location' => trim($this->input->post('location')),
    'specimen_type'  => trim($this->input->post('specimen_type')),
    'draw_type'  => trim($this->input->post('draw_type')),
	/* 'collected_by'  => $this->session->userdata('userID'), */
	'collected_by'  =>trim($this->input->post('collected_by')),
	 );
  
	 if($this->input->post('sc_id')>1)
	 {
	$this->sample->update(array('sc_id' => $this->input->post('sc_id')), $sampledata);
	 }
	 else{
		$this->sample->save($sampledata); 
	 }
	
		echo json_encode(array("status" => TRUE));

	}

	public function updateLabResult()
	{
	
   	$labData = array(  	 
    	'result' => trim($this->input->post('result')),
    	'test_method'  => trim($this->input->post('test_method')),
	'reagent'  => trim($this->input->post('reagent')),
	'test_done_by'  => trim($this->input->post('test_done_by')),
	'result_date' => trim($this->input->post('result_date'))
	
	 );
	  
	 if($this->input->post('lb_result_sample_id')>1)
	 {
	 $labData['result_id']= $this->input->post('result_id');
	 $labData['result_date']= trim($this->input->post('result_date'));
	 $labData['lb_result_sample_id']=$this->input->post('lb_result_sample_id');		  
	$this->sample->updateLabResult(array('result_id' => $this->input->post('result_id')), $labData);
	 }
	 else{
		 $labData['lb_result_sample_id']=$this->input->post('sample_id');	
		$this->sample->saveLabResult($labData); 
	 }
	
		echo json_encode(array("status" => TRUE));

	}


	
	

	public function sample_delete($id)
	{
		$this->sample->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}