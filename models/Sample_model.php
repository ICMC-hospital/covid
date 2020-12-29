<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample_model extends CI_Model {

	var $table = 'tbl_sample';
	var $column_order = array('sample_id','collection_site','sample_collection_date','travel_status',null); //set column field database for datatable orderable
	var $column_search = array('sample_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//	$this->db->from($this->table);
		$this->db->select('tbl_patient.*,tbl_sample.*,tbl_sample_collection.sc_id,tbl_hospital.* ');
		$this->db->from('tbl_patient'); // this is first table name
		$this->db->join('tbl_sample', 'tbl_sample.patient_id = tbl_patient.id','left'); 
		$this->db->join('tbl_sample_collection', 'tbl_sample_collection.lab_sample_id = tbl_sample.sample_id','left'); 
		$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');

		//restrict views only to memeber of where sample collection take place
		if($this->session->userdata('member_of') > 1)
			$this->db->where('tbl_sample.collection_site',$this->session->userdata('member_of'));


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

	public function get_by_id($id)
	{
	$this->db->select('*');
	$this->db->where('tbl_sample.sample_id',$id);
	$this->db->from('tbl_sample'); 
	$this->db->join('tbl_sample_collection', 'tbl_sample_collection.lab_sample_id = tbl_sample.sample_id','left'); // this is second table name with both table ids
	$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');
	$query = $this->db->get();
	return $query->row();
	}
	public function get_result_by_id($id)
	{
    $this->db->select('*');
	$this->db->where('tbl_sample.sample_id',$id);
	$this->db->from('tbl_sample'); 
	$this->db->join('tbl_sample_collection', 'tbl_sample_collection.lab_sample_id = tbl_sample.sample_id','left'); // this is second table name with both table ids
	$this->db->join('tbl_lab_result', 'tbl_lab_result.lb_result_sample_id = tbl_sample.sample_id','left'); 
	$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');
	// this is second table name with both table ids
	$query = $this->db->get();
	return $query->row();
	}
		


	/* public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	} */
	function save($sampledata) 
	{
		$this->db->insert('tbl_sample_collection', $sampledata);			
	}
	function saveLabResult($sampledata) 
	{
		$this->db->insert('tbl_lab_result', $sampledata);			
	}

	
	public function update($whereSampleId, $sampledata)
	{
		
		$this->db->update('tbl_sample_collection', $sampledata, $whereSampleId);
		return $this->db->affected_rows();
	}
	public function updateLabResult($wherelabid, $labresultdata)
	{
		
		$this->db->update('tbl_lab_result', $labresultdata, $wherelabid);
		return $this->db->affected_rows();
	}


	public function delete_by_id($id)
	{
		$this->db->where('sc_id', $id);
		$this->db->delete('tbl_sample_collection');
	}


}
