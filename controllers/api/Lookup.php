<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lookup extends CI_Controller {

 public function __construct()
 {
  parent::__construct();
  $this->load->model('lookup_model');
 }

 function get_nationalities()
 {
  $data = $this->lookup_model->get_nationalities();
  echo json_encode($data->result_array());
 }
}
?>
