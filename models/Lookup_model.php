
<?php
class Lookup_model extends CI_Model
{
	function get_nationalities()
	{	$this->db->order_by('name', 'DESC');
		return $this->db->get('tbl_nationality');
	}
	function get_country()
	{	$this->db->order_by('name', 'ASC');
		return $this->db->get('country');
	}
	function get_reason_for_testing()
	{	$this->db->order_by('display_order', 'DESC');
		return $this->db->get('tbl_reason_for_testing');
	}

	function get_roles()
	{	
		$this->db->order_by('display_name', 'DESC');
		return $this->db->get('roles');
	}

	function get_users()
	{	$this->db->order_by('first_name', 'DESC');
		return $this->db->get('users');
	}

	function get_hospitals()
	{	$this->db->order_by('display_order', 'DESC');
		return $this->db->get('tbl_hospital');
	}
}
?>