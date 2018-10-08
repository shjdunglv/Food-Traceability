<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_API extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Product_Model");
        $this->load->language('product',$this->language);
    }

    public function getSettingProductType(){
        if(!empty($this->input->post('type_id'))){
            $type_id = $this->input->post('type_id');
            $result = $this->Product_Model->getSettingProductType(array("type_id"=>$type_id));
            echo json_encode($result);
        }
        else
        echo json_encode(array(false,lang('error_info_not_exist')));
    }
    public function getPage(){
        if(!empty($this->input->post("get_setting")) && !empty($this->input->post("settings")) && !empty($this->input->post("type_id"))){
            $settings = $this->input->post("settings");
            $type_id = $this->input->post("type_id");
            $data['type_id'] = $type_id;
            $data["settings"] = json_decode(json_decode($settings),true);
            $this->load->view('default/views/partner/product_API',$data);
        }
    }
}
