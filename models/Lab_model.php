<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab_model extends CI_Model {

	var $table = 'tbl_lab_result';
	var $column_order = array('first_name','father_name','gender','phone_number','passport_number','location',null); //set column field database for datatable orderable
	var $column_search = array('first_name','father_name','phone_number'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
	//	$this->db->from($this->table);
	/* $this->db->select('tbl_patient.*,tbl_sample.*,tbl_sample_collection.* ','tbl_lab_result.*');
	$this->db->from('tbl_patient'); // this is first table name
	$this->db->join('tbl_sample', 'tbl_sample.patient_id = tbl_patient.id','left'); 
	$this->db->join('tbl_sample', 'tbl_sample.sample_id=tbl_sample_collection.lab_sample_id','left'); 
	$this->db->join('tbl_sample', 'tbl_sample.sample_id=tbl_lab_result.lb_result_sample_id','left');  */

	$this->db->select('*');
	$this->db->from('tbl_patient'); 
	$this->db->join('tbl_sample', 'tbl_sample.patient_id = tbl_patient.id', 'left');
	$this->db->join('tbl_sample_collection', 'tbl_sample.sample_id=tbl_sample_collection.lab_sample_id');
	$this->db->join('tbl_lab_result', 'tbl_sample.sample_id=tbl_lab_result.lb_result_sample_id');
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
	$this->db->join('tbl_lab_result', 'tbl_lab_result.lb_result_sample_id = tbl_sample.sample_id','left'); // this is second table name with both table ids
	$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');
	$query = $this->db->get();
	return $query->row();
	}
	public function test($id)
	{
	$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		
		return NULL;
}
	public function get_LabReport_by_id($id)
	{
		
		$this->db->select('tbl_patient.*,tbl_sample.*,tbl_sample_collection.*,tbl_lab_result.*,
		smu.first_name as cbyfname,smu.last_name as cbylname,
		tdby.first_name as tdbyfname,tdby.last_name as tdbylname,
		rapby.first_name as rapbyfname,rapby.last_name as rapbylname,tbl_hospital.*,country.name as nationality'
	);
		$this->db->from('tbl_patient'); 
		$this->db->join('country','tbl_patient.nationality = country.iso');
		$this->db->join('tbl_sample', 'tbl_sample.patient_id = tbl_patient.id', 'left');
		$this->db->join('tbl_sample_collection', 'tbl_sample.sample_id=tbl_sample_collection.lab_sample_id');
		$this->db->join('tbl_lab_result', 'tbl_sample.sample_id=tbl_lab_result.lb_result_sample_id');
		$this->db->join('users as smu', 'tbl_sample_collection.collected_by=smu.id');//sample collected by
		$this->db->join('users as tdby', 'tbl_lab_result.test_done_by=tdby.id');//sample done by
		$this->db->join('users as rapby', 'tbl_lab_result.result_approved_by=rapby.id');//result approved by
		$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');
		$this->db->where('tbl_patient.id', $id);
					$data = $this->db->get();	
	   $this->load->helper('date');
		$dateTimeformat = "%Y-%m-%d %h:%i %A";
		$dateformat = "%Y-%m-%d %h:%i %A";
		$timeformat = "%h:%i %A";
      
		$output = '<table align=left cellpadding = "2"  style="font-family: sans-serif; font-size:13px;" >';

		foreach($data->result() as $row)
		{
		
			$output .= '
			   <tr><th  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold; padding:5px 0px 5px 10px; margin:20px; font-size:14px ; overflow-wrap:anywhere;">
			   Client Identification
			   </th>
			</tr>
			   <tr>				  		   
				<td width="50%" align=left>
					<p><b>Full Name : </b>'.$row->first_name.' '. $row->father_name.' '. $row->grand_father_name.' </p>
					<p><b>Gender : </b>'.$row->gender.'</p>
					<p><b>Passport Number : </b>'.$row->passport_number.'</p>
					<p><b>ResidenceCity/Town : </b> '.$row->city.' </p>	
				</td>
				<td width="50%" align=left>	
				<p><b>Age in year : </b>'.(date('Y') - date('Y',strtotime($row->birth_date))).'</p>
				<p><b>Nationality : </b>'.$row->nationality.'</p>
				<p><b>phone Number : </b> '.$row->phone_number.' </p>
				<p><b>Region : </b>'.$row->region.'</p>
					
				</td>
			</tr>			
			 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white; font-weight: bold; padding:5px 2px;" font-size:14px>
			   Specimen Information
			   </td>
			   </tr>
			   <tr>				  		   
				<td width="50%" align=left>
				<p><b>Sample Id : </b>'.$row->sample_id.' </p>
					
					<p><b>Date of Specimen Collection : </b>'.date('d/m/y', strtotime($row->sample_collection_date)).'</p>
					<p><b>Site of specimen collection : </b>'.$row->hospital_name.'</p>					
					<p><b>Reason for Test : </b>'.$row->reason_for_testing.'</p>
				</td>
				<td width="50%" align=left>	
								
					<p ><b>Specimen Type : </b>'.$row->specimen_type.'</p>
					<p><b>Time of Specimen Collection : </b>'.date('g:i A', strtotime($row->sample_collection_date)).'</p>
					<p><b>Sample Collected by : </b>'.$row->cbyfname.' '. $row->cbylname.' </p>					
				    <p><b>Requested by : </b>Self </p>
				</td>
			</tr>			
			 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold; padding:5px 2px; font-size:14px">
			   Test Result
			   </td>
			   </tr>
			   <tr>				  		   
				<td width="50%" align=left>
				<p><b>Requested Test :  : </b>'.$row->test.' </p>
				
					<p><b>Test Result : </b>'.$row->result.'</p>
					<p><b>Time Result Issued :  </b>'.date('g:i A', strtotime($row->result_date)).'</p>
					<p><b>Result Reviewed by:</b>'.$row->rapbyfname.' '. $row->rapbylname.' </p>	
					
				</td>
				<td width="50%">
				<p><b>Test Method : </b>'.$row->test_method.'</p>					
				<p><b>Date Result Issued :  </b>'.date('d/m/y', strtotime($row->result_date)).'</p>
				<p><b>Test Done by :  </b>'.$row->tdbyfname.' '. $row->tdbylname.' </p>	
				<p><b>Testing Laboratory : </b>'.$row->hospital_lab_name.'</p>					
					
					</td>
			</tr>
	  <tr>
	     <td colspan="2">
         <p><b>Report Authorized and Issued by : </b>'.$row->rapbyfname.' '. $row->rapbylname.' </p>
					<p style="padding-bottom:40px;"><b>Signature : </b>_______________________________</p>
					</td>
		</tr>
		 <tr>
			 <td  colspan="2" style="background-color:#4385F4;color: white;font-weight: bold; padding:10px 0px;">
			   
			   </td>
			   </tr>
			<tr>
			<td colspan="2" align="left" ><img src="http://localhost/covid/assets/images/info.png" /></td>
		</tr>
		';
		}
	
		$output .= '</table>';
		return $output;


	}

	public function get_LabReport_by_idd($id)
	{
		
		$this->db->select('tbl_patient.*,tbl_sample.*,tbl_sample_collection.*,tbl_lab_result.*,
		smu.first_name as cbyfname,smu.last_name as cbylname,
		tdby.first_name as tdbyfname,tdby.last_name as tdbylname,
		rapby.first_name as rapbyfname,rapby.last_name as rapbylname,tbl_hospital.*'
	);
		$this->db->from('tbl_patient'); 
		$this->db->join('tbl_sample', 'tbl_sample.patient_id = tbl_patient.id', 'left');
		$this->db->join('tbl_sample_collection', 'tbl_sample.sample_id=tbl_sample_collection.lab_sample_id');
		$this->db->join('tbl_lab_result', 'tbl_sample.sample_id=tbl_lab_result.lb_result_sample_id');
		$this->db->join('users as smu', 'tbl_sample_collection.collected_by=smu.id');//sample collected by
		$this->db->join('users as tdby', 'tbl_lab_result.test_done_by=tdby.id');//sample done by
		$this->db->join('users as rapby', 'tbl_lab_result.result_approved_by=rapby.id');//result approved by
$this->db->join('tbl_hospital', 'tbl_sample.collection_site = tbl_hospital.hospital_id');
		$this->db->where('tbl_patient.id', $id);
	    return $this->db->get();
	       // return $query->row();
}


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
	public function updateLabResult($wherelab, $labresultdata)
	{
		
		$this->db->update('tbl_lab_result', $labresultdata, $wherelabid);
		return $this->db->affected_rows();
	}

public function approve_lab_result($id,$approvedBy)
{
		$this->db->set('result_approved', '1');
		$this->db->set('result_approved_by', $approvedBy);	
		$this->db->where('result_id',$id);			
		$this->db->update('tbl_lab_result');
		
		//return $this->db->affected_rows();
}
	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tbl_sample_collection');
	}


}