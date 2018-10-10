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
        $data = array('company_info.partner_id'=>$id);
        $this->db->select('*');
        $this->db->join('company_info', 'company_info.partner_id = partner.partner_id');
        $q = $this->db->limit(1)->get_where('partner', $data);

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    public function updateCompanyInfo($data) {
        //if no id was passed use the current users id
        $id = filterOnly(['partner_id'],$data);
        $data = filterOnly(['address','phone','name','photo_passport'],$data);
        $this->db->where($id);
        $this->db->update('company_info', $data);
        if ($this->db->affected_rows() > 0) {
            return array(true,lang("update_successly"));
        }
        return FALSE;
    }
    public function updateCompanyInfoForAdmin($data) {
        //if no id was passed use the current users id
        $id = filterOnly(['partner_id'],$data);
        $data = filterOnly(['address','phone','name','photo_passport','status'],$data);
        $this->db->where($id);
        $this->db->update('company_info', $data);
        if ($this->db->affected_rows() > 0) {
            return array(true,lang("update_successly"));
        }
        return FALSE;
    }
}

