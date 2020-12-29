<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {

 public function __construct()
 {
  parent::__construct();
  $this->load->model('patient_model');
  $this->load->library('form_validation');
 }

 function index()
 {
  $data = $this->patient_model->fetch_all();
  echo json_encode($data->result_array());
 }
 
 function insert()
 {
   //patient Data
  $this->form_validation->set_rules("first_name", "First Name", "required");
  $this->form_validation->set_rules("father_name", "Last Name", "required");
  $this->form_validation->set_rules("grand_father_name", "Grand Father Name", "required");
  $this->form_validation->set_rules("gender", "gender", "required");
  $this->form_validation->set_rules("birth_date", "birth_date", "required");
  $this->form_validation->set_rules("phone_number", "phone number", "required");
  $this->form_validation->set_rules("passport_number", "Passport number", "required");
  //sample data
  $this->form_validation->set_rules("sample_collection_date", "Sample Collection Date", "required");
  $array = array();
  if($this->form_validation->run())
  {
   $patientdata = array(
    'first_name' => trim($this->input->post('first_name')),
    'father_name'  => trim($this->input->post('father_name')),
    'grand_father_name'  => trim($this->input->post('grand_father_name')),
    'birth_date'  => trim($this->input->post('birth_date')),
    'phone_number'  => trim($this->input->post('phone_number')),
    'passport_number'  => trim($this->input->post('passport_number')),
    'region'  => trim($this->input->post('region')),
    'nationality'  => trim($this->input->post('nationality')),
    'city'  => trim($this->input->post('city')),
    'gender'  => trim($this->input->post('gender')),
    'email'  => trim($this->input->post('email'))
   );
    
   $sampledata = array(  
     'patient_id'=> 36,  
    'collection_site' => trim($this->input->post('collection_site')),
    'physician_phone_number'  => trim($this->input->post('physician_phone_number')),
    'travel_status'  => trim($this->input->post('travel_status')),
    'test_result_with'  => trim($this->input->post('test_result_with')),
    'test'  => trim($this->input->post('test')),
    'sample_collection_date'  => trim($this->input->post('sample_collection_date'))
     );
   $this->patient_model->insert_patient($patientdata,$sampledata);

   $array = array(
    'success'  => true
   );
  }
  else
  {
   $array = array(
    'error'    => true,
    'first_name_error' => form_error('first_name'),
    'father_name_error' => form_error('father_name'),
    'grand_father_name_error' => form_error('grand_father_name'),
    'gender_rrror' => form_error('gender'),
    'phone_number_error' => form_error('phone_number'),
    'birth_date_error' => form_error('birth_date'),
    'passport_number_error' => form_error('passport_number'),
    'sample_collection_date_error' => form_error('sample_collection_date')
   );
  }
  echo json_encode($array, true);
 }

 function fetch_single()
 {
  if($this->input->post('id'))
  {
   $data = $this->patient_model->fetch_single_patient($this->input->post('id'));
   foreach($data as $row)
   {
    $output['id'] = $row["id"];
    $output['first_name'] = $row["first_name"];
    $output['father_name'] = $row["father_name"];
    $output['grand_father_name'] = $row["grand_father_name"];
    $output['gender'] = $row["gender"];
    $output['phone_number'] = $row["phone_number"];
    $output['nationality'] = $row["nationality"];
    $output['birth_date'] = $row["birth_date"];
    $output['passport_number'] = $row["passport_number"];
    $output['region'] = $row["region"];
    $output['city'] = $row["city"];
    $output['email'] = $row["email"];

   }
   echo json_encode($output);
  }
 }

 function update()
 {
    $this->form_validation->set_rules("first_name", "First Name", "required");
    $this->form_validation->set_rules("father_name", "Last Name", "required");
    $this->form_validation->set_rules("grand_father_name", "Grand Father Name", "required");
    $this->form_validation->set_rules("gender", "gender", "required");
    $this->form_validation->set_rules("birth_date", "birth_date", "required");
    $this->form_validation->set_rules("phone_number", "phone_number", "required");
  
  $array = array();
  if($this->form_validation->run())
  {
   $data = array(
    'first_name' => trim($this->input->post('first_name')),
    'father_name'  => trim($this->input->post('father_name')),
    'grand_father_name'  => trim($this->input->post('grand_father_name')),
    'birth_date'  => trim($this->input->post('birth_date')),
    'phone_number'  => trim($this->input->post('phone_number')),
    'passport_number'  => trim($this->input->post('passport_number')),
    'region'  => trim($this->input->post('region')),
    'nationality'  => trim($this->input->post('nationality')),
    'city'  => trim($this->input->post('city')),
    'gender'  => trim($this->input->post('gender')),
    'email'  => trim($this->input->post('email'))
   
   );
   $this->patient_model->update_patient($this->input->post('id'), $data);
   $array = array(
    'success'  => true
   );
  }
  else
  {
   $array = array(
    'error'    => true,
    'first_name_error' => form_error('first_name'),
    'father_name_error' => form_error('father_name'),
    'grand_father_name_error' => form_error('grand_father_name'),
    'gender_rrror' => form_error('gender'),
    'phone_number_error' => form_error('phone_number')
   
   );
  }
  echo json_encode($array, true);
 }

 function delete()
 {
  if($this->input->post('id'))
  {
   if($this->patient_model->delete_single_patient($this->input->post('id')))
   {
    $array = array(
     'success' => true
    );
   }
   else
   {
    $array = array(
     'error' => true
    );
   }
   echo json_encode($array);
  }
 }
 
}
