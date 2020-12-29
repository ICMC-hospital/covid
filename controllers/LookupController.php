<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Job_positions extends CI_Controller { 
    function __construct() { 
        parent::__construct(); 
        //load model 
        $this -> load -> model('lookup_model'); 
    } 
    public 
    function get_nationalities() { 
        //fetch data from lookup_model 
        $data['natinalities'] = $this -> lookup_model -> get_nationalities(); 
        //pass data to view 
       // $this - > load - > view('patient_view', $data); 
    } 
      public 
    function get_reason_for_testing() { 
        //fetch data from lookup_model 
        $data['tbl_reason_for_testing'] = $this -> lookup_model -> get_reason_for_testing(); 
      
    } 
    
}