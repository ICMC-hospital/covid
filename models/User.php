<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
    /**
     * User constructor.
     */
    	var $table = 'users';
	var $column_order = array('first_name','last_name','username','phone','email',null); //set column field database for datatable orderable
	var $column_search = array('first_name','last_name','username'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
    }
    
    	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
    /**
     * Find data.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->db->get_where("users", array("id" => $id, "deleted_at" => null))->row(0);
    }

    /**
     * Find all data.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->db->get_where("users", array("deleted_at" => null))->result();
    }

    /**
     * Insert data.
     *
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);

        return $this->db->insert('users', $data);
    }

    /**
     * Edit data.
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->update('users', $data, array('id' => $data['id']));
    }
 
    /**
     * Delete data.
     *
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $data['deleted_at'] = date("Y-m-d H:i:s");

        return $this->find($id) ? $this->db->update('users', $data, array('id' => $id)) : 0;
    }

    /**
     * Insert roles.
     *
     * @param $user_id
     * @param $roles
     * @return int
     */
    public function addRoles($user_id, $roles)
    {
        $data["user_id"] = $user_id;
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $data["role_id"] = $role;
                $this->addRole($data);
            }
        }
        else {
            $data["role_id"] = $roles;
            $this->addRole($data);
        }

        return 1;
    }

    /**
     * Insert role.
     *
     * @param $data
     * @return mixed
     */
    public function addRole($data)
    {
        return $this->db->insert('roles_users', $data);
    }

    /**
     * Edit roles.
     *
     * @param $user_id
     * @param $roles
     * @return int
     */
    public function editRoles($user_id, $roles)
    {
        if($this->deleteRoles($user_id, $roles))
            $this->addRoles($user_id, $roles);

        return 1;
    }

    /**
     * Delete roles.
     *
     * @param $user_id
     * @param $roles
     * @return mixed
     */
    public function deleteRoles($user_id, $roles)
    {

        return $this->db->delete('roles_users', array('user_id' => $user_id));
    }

    /**
     * Delete role.
     *
     * @param $user_id
     * @param $role_id
     * @return mixed
     */
    public function deleteRole($user_id, $role_id)
    {

        return $this->db->delete('roles_users', array('user_id' => $user_id, 'role_id' => $role_id));
    }

    /**
     * Find roles associated with user.
     *
     * @param $id
     * @return array
     */
    public function userWiseRoles($id)
    {
        return array_map(function($item){
            return $item["role_id"];
        }, $this->db->get_where("roles_users", array("user_id" => $id))->result_array());
    }

    //get user roles by userid
    public function userRoles($id)
    {
           $this->db->select("roles.*,roles_users.user_id");
           $this->db->where('roles_users.user_id',$id);
           $this->db ->from("roles");
           $this->db->join("roles_users", "roles.id = roles_users.role_id", "left");
          
		$query = $this->db->get();

		return $query->row();
    }

   

    /**
     * Find role details associated with user.
     *
     * @param $id
     * @return array
     */
    public function userWiseRoleDetails($id)
    {
        return array_map(function($item){
            $user = new User();
            return $user->findRole($item);
        }, $this->userWiseRoles($id));
    }

    /**
     * Find role.
     *
     * @param $id
     * @return mixed
     */
    public function findRole($id)
    {
        return $this->db->get_where("roles", array("id" => $id, "deleted_at" => null))->row(0);
    }


    public function getCurrPassword($userid){
  $query = $this->db->where(['id'=>$userid])
                    ->get('users');
    if($query->num_rows() > 0){
        return $query->row();
    } }

 
 public function changePassword($userid,$new_password)
 {
    $data = array
    (
        'password'=> password_hash($new_password,PASSWORD_BCRYPT)
    );
    if (!$this->db->where('id', $userid)->update('users', $data))
    {
        throw new Exception('Failed to update password');
    }
}
}
