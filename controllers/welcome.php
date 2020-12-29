
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
         //$this->output->nocache();
        if ($this->session->userdata('validated') !=TRUE)
            redirect('login/index');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('Login_model');
        $this->load->model('Calendar_model');
    }

    function validatecredetial() {
        if ($this->session->userdata('validated'))
            redirect('welcome/home');
        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');
        if ($this->form_validation->run() == FALSE) { // validation hasn't been passed
            $msg = '';
            $this->index($msg);
        } else {

            $result = $this->Login_model->validate();
            // Now we verify the result
            if (!$result) {
                // If user did not validate, then show them login page again
                $msg = '<font color=red>Invalid username and/or password.</font><br />';
                $this->index($msg);
            } else {
                redirect('welcome/home');
            }
        }
    }

    function home() {
      //  if ($this->session->userdata('validated') != true)
        $data['activity'] = $this->Calendar_model->selectActivity();
        $data['campus'] = $this->Calendar_model->getCampus();
        $data['semister'] = $this->Calendar_model->selectSemister();
        $data['program'] = $this->Calendar_model->selectprogram();
        $data['menu'] = $this->Login_model->getMenu();
        $this->load->view('banner', $data);
        $data['title'] = 'My Calendar';
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

   function json_events() {

        $data['calendar'] = $this->Calendar_model->getcalender();
// Initializes a container array for all of the calendar events
        $jsonArray = array();

        foreach ($data['calendar'] as $cal) {
            $sub = $cal->subject;
            $sem = $cal->semester_name;
          
//            if ($sem === '1') {
//                $sub1 = + $sub;
//            }
//            elseif ($sem === '2') {
//              $sub1 = "Second Semester " + $sub;
//        }else{
//              $sub1 = "Third Semester " + $sub;
//        }
            $buildjson = array('id' => $cal->calendar_id,
                'title' => $cal->title,
                'start' => $cal->start_date,
                'end' => $cal->end_date,
                'campus' => $cal->campus_name,
                'program' => $cal->program_name,
                'semester' =>    $sem,
                'subject' => $sub,
                'allday' => false);

            array_push($jsonArray, $buildjson);
        }
        echo json_encode($jsonArray);
    }


         protected function no_cache() {
         $this->output->set_header("HTTP/1.0 200 OK");
         $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        
    }
 

}

?>