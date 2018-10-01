<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_Model extends CI_Model
{
    function registerPartner($data)
    {
        $partner = filterOnly(["email","password","create_at","religion"],$data);

            $this->db->insert('partner', $partner);

            if ($this->db->affected_rows() > 0) {
                $company_info = filterOnly(["name"], $data);
                $company_info["partner_id"] = $this->db->insert_id();
                $company_info["status"] = 0;
                $this->db->insert('company_info', $company_info);
                if ($this->db->affected_rows() > 0) {
                    return array(True, $company_info["partner_id"]);
                }
                else
                    return array(false, lang('error_create_company_info'));
            } else
                return array(false, lang('error_create_partner'));

    }
    function getPartnerByEmail($data){
        $partner = filterOnly(["email"],$data);
        $q = $this->db->select('*')
            ->where($partner)
            ->limit(1)
            ->get('partner');
        if ($q->num_rows() > 0) {
            return array(true,$q->row());
        }
        return FALSE;
    }
}
