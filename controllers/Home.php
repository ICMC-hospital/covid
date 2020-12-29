<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Dashboard.
    |
    */
    public function __construct()
    {
         parent::__construct();
    	$this->load->model('Patient_model','patient');
		$this->load->model('Lookup_model','lookup');
		 $this->load->library('form_validation');	
    }

    public function index()
    {
       // Load all views as normal
      $data=array();		
       // $this->template->set('title', 'Home');        
        	  $data['hospitals'] = $this->lookup->get_hospitals(); 
		 $data['reason_for_testing'] = $this->lookup->get_reason_for_testing(); 
    $this->load->view('home/index',$data);
           
    
    }

    		public function addPatient()
	{
	
     $rules = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
			),
			 array(
                'field' => 'sample_id',
                'label' => 'Sample Id',
				'rules' => 'required|exact_length[11]',
				 'errors' => array(
					'required' => 'You must provide a %s.',
					'min_length'=> '%s: the minimum of characters is %s'
                ),
			
			),
			
			 array(
                'field' => 'father_name',
                'label' => 'Father Name',
                'rules' => 'required'
			),
			 array(
                'field' => 'grand_father_name',
                'label' => 'Grand First Name',
                'rules' => 'required'
			),
			 array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'required'
			),
			 array(
                'field' => 'passport_number',
                'label' => 'Passport',
                'rules' => 'required'
            ),
            array(
                'field' => 'phone_number',
                'label' => 'Phone Number',
                'rules' => 'required|regex_match[/^[0-9]{10}$/]'), //{10} for 10 digits number
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
			
			 array(
                'field' => 'birth_date',
                'label' => 'Date Of birth',
                'rules' => 'required'
            ),
           
        );
	 $this->form_validation->set_rules($rules);
	 //$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
        //Generate 13 digit random number to render barcode
		 $barcode = rand(1111111111111,9999999999999);		 
		$array = array();
		
  	$patientdata = array(
	'first_name' => trim($this->input->post('first_name')),
	'barcode_number'=> trim($this->input->post('sample_id')),
    'father_name'  => trim($this->input->post('father_name')),
    'grand_father_name'  => trim($this->input->post('grand_father_name')),
    'birth_date'  => $this->input->post('birth_date'),
    'phone_number'  => trim($this->input->post('phone_number')),
    'passport_number'  => trim($this->input->post('passport_number')),
    'region'  => trim($this->input->post('region')),
    'nationality'  => trim($this->input->post('nationality')),
    'city'  => trim($this->input->post('city')),
    'gender'  => trim($this->input->post('gender')),
	'email'  => trim($this->input->post('email'))
	
   );
    
   $sampledata = array( 
	'sample_id' => trim($this->input->post('sample_id')),
    'collection_site' => trim($this->input->post('collection_site')),
    'physician_phone_number'  => trim($this->input->post('physician_phone_number')),
    'travel_status'  => trim($this->input->post('travel_status')),
    'test_result_with'  => trim($this->input->post('test_result_with')),
	'test'  => trim($this->input->post('test')),
	'case_status'  => trim($this->input->post('case_status')),
	'sample_collection_date'  => trim($this->input->post('sample_collection_date')),
	'reason_for_testing'  => trim($this->input->post('reason_for_testing')) 
	 );

    if ($this->form_validation->run())  
           { 
			   $insert = $this->patient->save($patientdata,$sampledata);
			   
   $array = array(
    'status'  => true
   );
}
 else
  {
   $array = array(
	'error'    => true,
	'sample_id_error' => form_error('sample_id'),
    'first_name_error' => form_error('first_name'),
    'father_name_error' => form_error('father_name'),
    'grand_father_name_error' => form_error('grand_father_name'),
    'gender_error' => form_error('gender'),
    'phone_number_error' => form_error('phone_number'),
    'birth_date_error' => form_error('birth_date'),
    'passport_number_error' => form_error('passport_number'),
   
   );
  }
	 echo json_encode($array, true);
	//	echo json_encode(array("status" => TRUE));
	}
}