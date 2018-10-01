<?php
/**
 * Created by PhpStorm.
 * User: ledung
 * Date: 9/29/18
 * Time: 11:43 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Company_Model extends CI_Model
{
    public function getAllCompanys() {
        $q = $this->db->get("company_info");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function company($id = NULL) {

        //if no id was passed use the current users id
        $id || $id = $this->session->userdata('company_id');

        $q = $this->db->select('*')
            ->where('partner_id', $id)
            ->limit(1)
            ->get('company_info');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
}

