<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Model
{
    /**
     * User constructor.
     */
    	var $table = 'tbl_hospital';
	var $column_order = array('hospital_name','hospital_short_name','hospital_lab_name',null); //set column field database for datatable orderable
	var $column_search = array('hospital_name','hospital_short_name','hospital_lab_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('hospital_id' => 'desc'); // default order 

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
		$this->db->select('*');
		$this->db->from('tbl_hospital');
		$this->db->where('hospital_id',$id);
		$query = $this->db->get();

		return $query->row();
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
	

	public function save($data)
	{
		return $this->db->insert('tbl_hospital', $data);
	}

    /**
     * Edit data.
     *
     * @param $data
     * @return mixed
     */
    	public function edit($data)
    	{
        	return $this->db->update('tbl_hospital', $data, array('hospital_id' => $data['hospital_id']));
    	}
	
   	public function delete_by_id($id)
	{
		$this->db->where('hospital_id', $id);
		$this->db->delete($this->table);
	}

}