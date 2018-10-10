<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_Model extends CI_Model
{
    function addNewProductType($data)
    {
        $productType = filterOnly(["type_name","partner_id","settings","create_at"],$data);

        $this->db->insert('product_type', $productType);

        if ($this->db->affected_rows() > 0) {

                return array(True, $this->db->insert_id());

        } else
            return array(false, lang('error_create_partner'));

    }
    function addNewProduct($data)
    {
        $productType = filterOnly(["product_id","type_id","name","data","create_at"],$data);
        $this->db->insert('product_list', $productType);

        if ($this->db->affected_rows() > 0) {
            return array(True, $this->db->insert_id());

        } else
            return array(false, lang('error_create_partner'));

    }
    function addNewMultiProduct($data)
    {
        $this->db->insert_batch('product_list', $data);
        if ($this->db->affected_rows() > 0) {
            return array(True, $this->db->insert_id());

        } else
            return array(false, lang('error_create_partner'));

    }
    function getAllProductType($data){
        $partner = filterOnly(["type_id"],$data);
        $q = $this->db->get_where('product_type', $partner);
        if ($q->num_rows() > 0) {
            return array(true,$q->row());
        }
        return array(false,lang("error_info_not_exist"));
    }
    function getSettingProductType($data){
        $partner = filterOnly(["type_id"],$data);
        $this->db->select('type_id,type_name,settings');
        $q = $this->db->get_where('product_type', $partner);
        if ($q->num_rows() > 0) {
            return array(true,$q->row());
        }
        return array(false,lang("error_info_not_exist"));
    }
    function getInfoProduct($data){
        $partner = filterOnly(["product_id"],$data);
        $q = $this->db->get_where('product_list', $partner);
        if ($q->num_rows() > 0) {
            return array(true,$q->row());
        }
        return array(false,lang("error_info_not_exist"));
    }
    function getAllProductByPartnerID($data){
        $this->db->select('*');
        $this->db->join('product_type', 'product_list.type_id = product_type.type_id');
        $q = $this->db->get_where('product_list',$data);
        if($q->num_rows()>0)
            return array(true,$q->result());
        else
            return array(false,"error_info_not_exist");
    }
}
