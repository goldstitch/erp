<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transporters extends CI_Model {
    public function getMaxId() {
        $this->db->select_max('transporter_id');
        $result = $this->db->get('transporter');
        $row = $result->row_array();
        $maxId = $row['transporter_id'];
        return $maxId;
    }
    public function isTransporterAlreadySaved($transporter) {
        $result = $this->db->query("SELECT * FROM transporter WHERE transporter_id <> " . $transporter['transporter_id'] . " AND name = '" . $transporter['name'] . "'");
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function save($transporter) {
        $this->db->where(array('transporter_id' => $transporter['transporter_id']));
        $result = $this->db->get('transporter');
        $affect = 0;
        if ($result->num_rows() > 0) {
            $this->db->where(array('transporter_id' => $transporter['transporter_id']));
            $result = $this->db->update('transporter', $transporter);
            $affect = $this->db->affected_rows();
        } else {
            unset($transporter['transporter_id']);
            $result = $this->db->insert('transporter', $transporter);
            $affect = $this->db->affected_rows();
            $id = $this->db->insert_id();
            $this->db->where(array('transporter_id' => $id));
            $result = $this->db->get('transporter');
            return $result->row_array();
        }
        if ($affect === 0) {
            return false;
        } else {
            return true;
        }
    }
    public function fetch($transporter_id) {
        $this->db->where(array('transporter_id' => $transporter_id));
        $result = $this->db->get('transporter');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function fetchAll() {
        $result = $this->db->get('transporter');
        return $result->result_array();
    }
    public function delete($transporter_id) {
        $this->db->where(array('transporter_id' => $transporter_id));
        $result = $this->db->get('transporter');
        if ($result->num_rows() > 0) {
            $this->db->where(array('transporter_id' => $transporter_id));
            $this->db->delete('transporter');
            return true;
        } else {
            return false;
        }
    }
}