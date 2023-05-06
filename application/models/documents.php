<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class documents extends CI_Model {
public function __construct() {
parent::__construct();
}

public function save_document($id,$name,$date,$company,$amount,$by,$status)
{
	$result = $this->db->query("insert into document (id,name,date,company,amount,sender,status) values ('$id','$name','$date','$company','$amount','$by','$status') ");
	return true;
}


public function update_document($id,$name,$date,$company,$amount,$by,$status)
{
	$result = $this->db->query("update document set name='$name' ,amount ='$amount',company='$company', sender ='$by' where id ='$id' ");
	return true;
}

public function update_return($id,$date)
{
	$result = $this->db->query("update document set return_date='$date',status ='Returned' where id ='$id' ");

	return true;
}

public function getMaxIddocument() {
	$this->db->select_max('id');
	$result = $this->db->get('document');
	$row = $result->row_array();
	$maxId = $row['id'];
	return $maxId;
}

public function delete_document($id)
{

$this->db->where(array('id'=>$id));
$this->db->delete('document');
return true;

}

public function fetch_document($id) {
		$result = $this->db->query("select * from document where id ='$id' and status ='Received'");
		return $result->result_array();
	}


public function document()
	{
		$result = $this->db->query("select * from document ");
		return $result->result_array();
	}


}