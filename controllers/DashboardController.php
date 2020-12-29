<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
   
    public function __construct()
    {
        parent::__construct();
       $this->load->model('Patient_model','patient');
		$this->load->model('Lookup_model','lookup');
		 $this->load->library('form_validation');		 
        $this->load->helper('url');
       $this->load->library('auth');
    }

    public function index()
    {
             
        $data=array();		
		 $this->template->set('title', 'Patient/Sample');  	
		
		  $this->template->load('default_layout', 'contents' , 'dashboard_view',$data);
    }
}