<?php 
class Setting_configurations extends cI_Model {
    public function save($obj) {
        $result = $this->db->get('setting_configuration');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $result = $this->db->update('setting_configuration', $obj);
            $affect = $this->db->affected_rows();
        } else {
            $result = $this->db->insert('setting_configuration', $obj);
            $affect = $this->db->affected_rows();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch() {
        $sql = "select * from setting_configuration";
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
}