<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MembersController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Members','members');
		$this->load->model('Lookup_model','lookup');
		$this->load->library('form_validation');	
		$this->load->helper('form');	 
		$this->load->helper('url');
	        $this->load->library(['auth']);
	        $this->auth->route_access(); 
	}

	public function index()
	{
	      $data=array();
		  $this->template->set('title', 'Members');
		  $data['roles'] = $this->lookup->get_roles(); 
		  $data['hospitals'] = $this->lookup->get_hospitals(); 
		  $this->template->load('default_layout', 'contents' , 'members_view',$data);
	}

	public function members_list()
	{
		$list = $this->members->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->hospital_name;		
			$row[] = $user->hospital_short_name;
			$row[] = $user->hospital_lab_name;
			//add html for action
			$row[] = '
	   			<a  href="javascript:void(0)" title="Edit" onclick="edit_member('."'".$user->hospital_id."'".')" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
		
	 			<a href="javascript:void(0)" title="Hapus" onclick="delete_member('."'".$user->hospital_id."'".')" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->members->count_all(),
						"recordsFiltered" => $this->members->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function editMember($id)
	{
		$data = $this->members->find($id);
		echo json_encode($data);
	}
	
	public function addMember()
	{
		$data = array(
				'hospital_name' => $this->input->post('hospital_name'),
				'hospital_short_name' => $this->input->post('hospital_short_name'),
				'hospital_lab_name' => $this->input->post('hospital_name'),
				'hospital_lab_short_name' => $this->input->post('hospital_lab_short_name'),
			);
		$insert = $this->members->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function update_member()
	{
		$data = array(
			   'hospital_id' => $this->input->post('hospital_id'),
				'hospital_name' => $this->input->post('hospital_name'),
				'hospital_short_name' => $this->input->post('hospital_short_name'),
				'hospital_lab_name' => $this->input->post('hospital_name'),
				'hospital_lab_short_name' => $this->input->post('hospital_lab_short_name'),
			);
			
		$this->members->edit($data);
		echo json_encode(array("status" => TRUE));
	}

	public function delete_member($id)
	{
		$this->members->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}




}