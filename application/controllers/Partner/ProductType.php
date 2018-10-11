<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProductType extends PartnerController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->language("product", $this->language);
        $this->load->model('Product_Model');

    }
    public function index(){
        $productType = $this->Product_Model->getAllProductType(array('partner_id' => $this->partner_id));
        if ($productType[0] == false) {
            $this->session->set_flashdata('error', lang('error_must_create_product_type_first'));
            redirect(partner_url("ProductType/add"));
        }
        foreach ($productType[1] as $ptype)
        {
            $settings = json_decode(json_decode($ptype->settings),true);
            foreach ($settings as $key=>$value){
                $sets[] = lang($key);
            }
            $ptype->sets = join(',',$sets);
            unset($sets);

        }
        $this->data["productType"] = $productType[1];

        $this->data['page_title'] = lang('products');
        $bc = array(array('link' => '#', 'page' => lang('products')));
        $meta = array('page_title' => lang('products'), 'bc' => $bc);
        $this->page_construct('productType/index', $this->data, $meta);
    }
    public function add(){

        $bc = array(array('link' => partner_url('productType'), 'page' => lang('product_type')), array('link' => '#', 'page' => lang('add_product_type')));
        $meta = array('page_title' => lang('add_product_type'), 'bc' => $bc);
        $this->page_construct('partner/productType/add', $this->data, $meta);
    }
    public function addNew(){
        $this->form_validation->set_rules('productCheckList[]', lang('setting_product'), 'required');
        $this->form_validation->set_rules('type_name', lang('type_name'), 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(partner_url('productType/add'));
            exit();
        }
        if (!empty($this->input->post('productCheckList'))){
            //load Model
            $this->load->model("Product_Model");
            //get data post
            $productCheckList = $this->input->post('productCheckList');
            $type_name = $this->input->post('type_name');
            //string processing
            $productSetting = $this->process_settings($productCheckList);

            $data = array("type_name"=>$type_name,"settings"=>json_encode($productSetting),'create_at'=>fullDateTimeNow(),'partner_id' => $this->user_id);
            $result = $this->Product_Model->addNewProductType($data);
            $this->session->set_flashdata('message', lang('add_product_type_success'));
            redirect(partner_url("ProductType/add"));
        }
        else
        {
            $this->session->set_flashdata('error', lang('add_product_type_failed'));
            redirect(partner_url("ProductType/add"));
        }
    }
    private function process_settings($productCheckList){
        $settings = new ArrayObject();
        foreach($productCheckList as $setting){
            $settings[$setting] = 'enabled';
        }
        return json_encode($settings);
    }
}
