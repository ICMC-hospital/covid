<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			$this->load->model('user_model','userModel');
			$this->load->model('User','user');
				$this->load->model('Role','role');
				$this->load->model('Permission','permission');
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
		  $this->template->set('title', 'User');
		  $data['roles'] = $this->lookup->get_roles(); 
		  $data['hospitals'] = $this->lookup->get_hospitals(); 
		  $this->template->load('default_layout', 'contents' , 'user/user_view',$data);
	}

	public function user_list()
	{
		$list = $this->user->all();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->first_name .' '. $user->last_name;		
			$row[] = $user->username;
			$row[] = $user->phone;
			$row[] = $user->email;
			//add html for action
			$row[] = '
			
    <div class="btn-group">
  
    <div class="btn-group">
    <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
      Actions
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
	   <li> <a  href="'.base_url().'UserController/add_edit_user_role/'.$user->id.'"><i class="glyphicon glyphicon-pencil"></i>User Roles</a> </li>
	   <li><a  href="javascript:void(0)" title="Edit" onclick="edit_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a></li>
		
	  <li><a href="javascript:void(0)" title="Hapus" onclick="delete_user('."'".$user->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a></li>
    </ul>
  </div>
</div>
';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user->count_all(),
						"recordsFiltered" => $this->user->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function user_edit($id)
	{
		$data = $this->user->find($id);
		echo json_encode($data);
	}
//retrive user Roles
	public function add_edit_user_role($id)
	{
		$data=array();
		$data['roles'] = $this->lookup->get_roles(); 
		$data['userWiseRoles'] = $this->user->userWiseRoles($id);
	
		$this->template->set('title', 'User Roles');	
		$this->template->load('default_layout', 'contents' , 'user/add_edit_user_role',$data);
      //save User Roles
		 if($this->input->post('saveUserRoles')){
		  $roles = $this->input->post('roles');
		  $roledata=array();
          foreach ($roles as $role) {
                $roledata[] = $role;
                  }		
         $this->session->set_userdata('success_msg',$roledata); 
		   $insert = $this->user->editRoles($id,$roledata);
		   if($insert){ 
			  
                    $this->session->set_userdata('success_msg', 'saved'); 
                    redirect('UserController/index'); 
                }else{ 
                    $data['error_msg'] = 'Some problems occured, please try again.'; 
                }  
		 }


	}
	
	public function user_add()
	{
		$data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'gender' => $this->input->post('gender'),
				'phone' => $this->input->post('phone'),
				'member_of' => $this->input->post('member_of'),
				'username' => $this->input->post('username'),
				'password' => 123,
			);
		$insert = $this->user->add($data);
		echo json_encode(array("status" => TRUE));
	}

	public function user_update()
	{
		$data = array(
			   'id' => $this->input->post('id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'gender' => $this->input->post('gender'),
				'phone' => $this->input->post('phone'),
				'member_of' => $this->input->post('member_of'),
				'username' => $this->input->post('username'),
			);
			
		$this->user->edit($data);
		echo json_encode(array("status" => TRUE));
	}

	public function user_delete($id)
	{
		$this->userModel->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	public function	role_permissions()
	{
			$data=array();
	      $data['permissions']=null;		  
		   $role_id=0;
		   $data['role_id']=$role_id;
		   $data['roles'] = $this->lookup->get_roles(); 
		  
		   $data['roleWisePermissions'] = $this->role->roleWisePermissions($role_id);
		   
		  if($this->input->post('serachRolPermissions')){
			$id=$this->input->post('role_id');
			 $data['role_id']=$id;
			 $role_id=$id;
	    	 $data['roleWisePermissions'] = $this->role->roleWisePermissions($id);
	    	 $data['permissions'] = $this->permission->all(); 
		}

		     if($this->input->post('saveRolePermissions')){
			   $permissions = $this->input->post('permissions');
			    $role_id = $this->input->post('role_id');
		        $permissiondata=array();
              foreach ($permissions as $permission) {
                $permissiondata[] = $permission;
                  }	
           
		   $insert = $this->role->editPermissions($role_id,$permissiondata);
		   if($insert){ 
			       $data['role_id']=$role_id;
                    $this->session->set_userdata('success_msg', 'saved'); 
				   $data['roleWisePermissions'] = $this->role->roleWisePermissions($role_id);
				    $data['permissions'] = $this->permission->all();  
                }else{ 
                    $data['error_msg'] = 'Some problems occured, please try again.'; 
                }  
		 }

	                
		$this->template->set('title', 'User Roles');	
		$this->template->load('default_layout', 'contents' , 'user/role_permission_view',$data);
	}


	public function change_password()
{
	  $this->session->set_userdata('error_msg','');	
	    $this->session->set_userdata('success_message','');	
	  
		if($this->input->post('change_pass'))
		{		
			$session_id=$this->session->userdata('userID');

    $this->form_validation->set_rules('old_pass', 'Current Password', 'required|alpha_numeric');
    $this->form_validation->set_rules('new_pass', 'New Password', 'required|alpha_numeric|min_length[6]|max_length[20]');
    $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|alpha_numeric|min_length[6]|max_length[20]');

    if($this->form_validation->run())
    {
        $cur_password = $this->input->post('old_pass');
        $new_password = $this->input->post('new_pass');
        $conf_password = $this->input->post('confirm_pass'); 

        try
        {
		     $objUser = $this->user->find($session_id);
			  //if ($objUser->password != password_hash($cur_password,PASSWORD_BCRYPT))  
				 if(!password_verify($cur_password,$objUser->password))
				 				   		         {
  $this->session->set_userdata('error_msg','Sorry! Current password is not matching');
			     throw new Exception('Sorry! Current password is not matching');
				
													 }		 
					
				if ($new_password != $conf_password) 
				{ $this->session->set_userdata('error_msg','New password & Confirm password is not matching');	
			 throw new Exception('New password & Confirm password is not matching');}  
				
		  
		    	$this->user->changePassword($session_id,$new_password);
			//echo 'Password updated successfully';
			 $this->session->set_userdata('success_message','Password updated successfully');	

        }
        catch (Exception $e)
        {
			//echo $e->getMessage('exception');
			 // $this->session->set_userdata('error_msg',$e);			
        }
    }
    else
    {
	  //$error= validation_errors('<div class="alert alert-danger">','</div>');
	  $this->session->set_userdata('error_msg',validation_errors());	
    }
	
		}

		$this->template->set('title', 'Change My Password');
			
		$this->template->load('default_layout', 'contents' , 'user/change_password_view');

}
    public function password_check($oldpass)
    {
			echo print_r($old_pass);
        $id = $this->session->userdata('userID');
        $user = $this->user->find($id);

        if($user->password !== password_hash($oldpass,PASSWORD_BCRYPT)) {
            $this->form_validation->set_message('password_check', 'The {field} does not match');
            return false;
        }

        return true;
    }
}