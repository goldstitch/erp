<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');
class discounts extends CI_Model {
public function __construct() {
parent::__construct();

}

public function loaddata()
{
      $result = $this->db->query("SELECT DISTINCT department.name, stockdetail.item_id,stockdetail.godown_id,item.item_des,stockdetail.item_discount,ROUND(item.srate2,0) as srate2,ROUND(item.srate,0) as srate ,ROUND(item.cost_price,0) as cost ,item.item_barcode FROM stockdetail 
      LEFT JOIN department ON department.did = stockdetail.godown_id
      INNER JOIN item on stockdetail.item_id=item.item_id
      where stockdetail.frate >0 
      order By department.did");
      return $result->result_array();
}


public function update_price($item_id,$item_barcode,$w_price,$r_price)
{
    if ($r_price =='')
    {
        $query = $this->db->query("update item set srate2 = $w_price where item_id = '$item_id' and item_barcode='$item_barcode' ");
    }
    else if ($w_price=='')
    {
        $query = $this->db->query("update item set srate =$r_price where item_id = '$item_id' and item_barcode='$item_barcode'");
    }
    else if ($w_price!=0 and $r_price!=0)
    {
        $query = $this->db->query("update item set srate =$r_price  where item_id = $item_id and item_barcode=$item_barcode");
        $query = $this->db->query("update item set srate2 = $w_price where item_id = $item_id and item_barcode=$item_barcode");
    }
    else{}
    
}



public function disc($item_id,$godown_id,$item_discount)
{
    $query = $this->db->query("update stockdetail set item_discount = $item_discount where item_id = $item_id and godown_id = $godown_id");
}

public function limitdisc($item_id,$godown_id,$from_date,$to_date,$limit_discount)
{
    $query = $this->db->query("update stockdetail set limited_discount = '$limit_discount' , from_date = '$from_date' , to_date = '$to_date' where item_id ='$item_id' and godown_id = '$godown_id'");
}


public function save_price($item_id,$name,$w_price,$r_price, $item_des , $date ,$cost,$price)
{
    $ $result = $this->db->query("insert into price (item_id,item_name,location,w_price,newprice,sale_price,new_price,date) values ('$item_id','$item_des','$name','$cost','$w_price','$price','$r_price','$date') ");
}

public function save_discount($item_id,$item_des,$name,$item_discount,$limit_discount,$discount,$date)
{
    $result = $this->db->query("insert into discount (item_id,item_name,location,old_disc,new_disc,limit_disc,Date) values ('$item_id','$item_des','$name','$discount','$item_discount','$limit_discount','$date') ");
}

}
