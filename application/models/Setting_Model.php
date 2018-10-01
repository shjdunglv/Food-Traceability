<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_Model extends CI_Model
{
    public function getSettings(){
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }
}
