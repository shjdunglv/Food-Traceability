<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends PartnerController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->language("product", $this->language);
        $this->load->model("Product_Model");
    }

    function index()
    {
        $result = $this->Product_Model->getAllProductByPartnerID(array('partner_id'=>$this->user_id));
        ($result[0] == true) ? $this->data['product'] = $result[1] : $data['product'] = null;

        $this->data['page_title'] = lang('products');
        $bc = array(array('link' => '#', 'page' => lang('products')));
        $meta = array('page_title' => lang('products'), 'bc' => $bc);
        $this->page_construct('products/index', $this->data, $meta);
    }

    function add()
    {
        if (!$this->Partner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('/');
        }
        //load all product type by id
        $productType = $this->Product_Model->getAllProductType(array('partner_id' => $this->partner_id));
        if ($productType[0] == false) {
            $this->session->set_flashdata('error', lang('error_must_create_product_type_first'));
            redirect(partner_url("ProductType/add"));
        }
        $this->data["productType"] = $productType[1];

        $this->data['page_title'] = lang('add_product');
        $bc = array(array('link' => site_url('products'), 'page' => lang('products')), array('link' => '#', 'page' => lang('add_product')));
        $meta = array('page_title' => lang('add_product'), 'bc' => $bc);
        $this->page_construct('products/add', $this->data, $meta);


    }

    function insertProduct()
    {
        if (!empty($this->input->post("type"))) {
            $result = $this->Product_Model->getSettingProductType(array("type_id" => $this->input->post("type")));
            if ($result[0] == false) {
                $this->session->set_flashdata('error', lang('access_denied'));
                redirect(partner_url('Product/Add'));
                exit();
            } else {
                $settings = json_decode(json_decode($result[1]->settings), true);
            }
        }
        foreach ($settings as $key => $val) {
            $this->form_validation->set_rules($key, lang($key), 'required');
        }
        $this->form_validation->set_rules('code', lang("code"), 'min_length[2]|max_length[50]|required');
        $this->form_validation->set_rules('name', lang("product_name"), 'required');
        $this->form_validation->set_rules('type', lang("type"), 'required');

        if ($this->form_validation->run() == true) {
            foreach ($settings as $key => $val) {
                $dataSettings[] = array($key => $this->input->post($key));
            }
            $data = array(
                'type_id' => $this->input->post('type'),
                'product_id' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'create_at' => fullDateTimeNow(),
                'data' => json_encode($dataSettings)
            );


            //upload file
            if ($_FILES['userfile']['size'] > 0) {

                $this->load->library('upload');
                $this->load->library('image_lib');

                $config['upload_path'] = 'uploads/photo_passport';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '500';
                $config['max_width'] = '800';
                $config['max_height'] = '800';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(partner_url("Product/add"));
                }

                $photo = $this->upload->file_name;
                $data['image'] = $photo;

                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'uploads/' . $photo;
                $config['new_image'] = 'uploads/thumbs/' . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 110;
                $config['height'] = 110;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if (!$this->image_lib->resize()) {
                    $this->session->set_flashdata('error', $this->image_lib->display_errors());
                    redirect(partner_url("Product/add"));
                }

            }
            // $this->tec->print_arrays($data, $items);
        } //Validateion error
        else {
            $this->session->set_flashdata('error', validation_errors());
            redirect(partner_url('Product/add'));
        }


        //add new product
        $result = $this->Product_Model->addNewProduct($data);
        if ($result[0] == true) {
            $this->session->set_flashdata('message', lang("product_added"));
            redirect(partner_url('Product/add'));

        } else {
            $this->session->set_flashdata('error', $result[1]);
            redirect(partner_url('Product/add'));

        }
    }

    private function process_datas($productCheckList)
    {
        $settings = new ArrayObject();
        foreach ($productCheckList as $setting) {
            $settings[$setting] = 'enabled';
        }
        return json_encode($settings);
    }

    function printBarcode($id)
    {
        $limit = 10;
        $page = $this->input->get('page');
        $imgBarcode = $this->imgBarcode($id);
        $html = $this->htmlBarcode($imgBarcode);
        $this->data['html'] = $html;
        $this->data['page_title'] = lang("print_barcodes");
        $this->data['id'] = $id;

        $this->load->view($this->theme . 'products/print_barcode', $this->data);
    }
    private function imgBarcode($id){
        $code =$id;
        $barcode_symbology="code128";
         return $this->product_barcode($code, $barcode_symbology, 60);
    }
    private function htmlBarcode($imgBarcode){
        $html = "";
        $html .= '<table class="table table-bordered table-centered mb0">
                    <tbody><tr>line 1</tr><tr>line 2<td><h4>name proudc</h4><strong>name product</strong><br>'.$imgBarcode.'<br><span class="price">line 7</span></td>';
        $html .= '</tr></tbody>
        </table>';
        return $html;
    }
    function product_barcode($product_code = NULL, $bcs = 'code128', $height = 60) {
        $this->load->library('barcodes');
        if ($this->input->get('code')) {
            $product_code = $this->input->get('code');
        }
        return $this->barcodes->barcode($product_code, $bcs, $height);
    }
    function printPDF($id){
        $this->load->library('pdf');
        $imgBarcode = $this->imgBarcode($id);
        $html = $this->htmlBarcode($imgBarcode);
//        $html = ob_get_clean();
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
//        $htmlData = ob_get_contents();
        $this->pdf->render();
        $this->pdf->stream($id.".pdf");

//        ob_end_clean();


    }

    function import() {
//        if (!$this->Admin) {
//            $this->session->set_flashdata('error', lang('access_denied'));
//            redirect('pos');
//        }
        $productType = $this->Product_Model->getAllProductType(array('partner_id' => $this->partner_id));
        if ($productType[0] == false) {
            $this->session->set_flashdata('error', lang('error_must_create_product_type_first'));
            redirect(partner_url("ProductType/add"));
        }
        $this->data["productType"] = $productType[1];

        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang("upload_file"), 'xss_clean');
        $this->form_validation->set_rules('type', lang("product_type"), 'trim|required|xss_clean');

        if ($this->form_validation->run() == true) {


            if (isset($_FILES["userfile"])) {

                $this->load->library('upload');

                $config['upload_path'] = 'uploads/files/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '500';
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(partner_url("product/import"));
                }


                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen("uploads/files/" . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }

                $keysOfFile = array_shift($arrResult);

                $keys = array('code', 'name', 'type_id');

                $final = array();
                $type = $this->input->post('type');


                //get setting of type
                if(!($protype = $this->Product_Model->getSettingProductType(array('type_id'=>$type)))[0]){
                    $this->session->set_flashdata('error', lang("category_not_exist") . " (" . $type . "). " . lang("category_not_exist"));
                    redirect(partner_url("product/import"));
                    exit();
                }

                //Add setting to keys
                $sets = json_decode(json_decode($protype[1]->settings),true);
                foreach ($sets as $key=>$value){
                    $keys[] = $key;
                }

                //make key to data
                foreach ($arrResult as $key => $value) {
                    $errKey;
                    if(count($keys)!==count($value)){
                        $this->session->set_flashdata('error', lang("error_properties_incorrect") . " (" . $csv_pr['category code'] . "). " . lang("category_not_exist"));
                        redirect(partner_url("product/import"));
                    }
                    else
                        $final[] = array_combine($keys, $value);
                }

                if (sizeof($final) > 1001) {
                    $this->session->set_flashdata('error', lang("more_than_allowed"));
                    redirect(partner_url("product/import"));
                }
                foreach ($final as $csv_pr) {
                    $arr = [];
                    if (($info =$this->Product_Model->getInfoProduct(array('product_id'=>$csv_pr['code'])))[0]) {
                        $this->session->set_flashdata('error', lang("error_check_product_code") . " (" . $csv_pr['code'] . "). " . lang("error_check_product_code"));
                    }

                    //check permission

                    if($protype[1]->partner_id != $this->user_id) {
                        $this->session->set_flashdata('error', lang("category_not_exist") . " (" . $csv_pr['category code'] . "). " . lang("category_not_exist"));
                        redirect(partner_url("product/import"));
                    }
                    foreach ($sets as $key=>$value){
                        $setting[$key] = $csv_pr[$key];
                    }

                    $arr[] = array(
                        'product_id' => $csv_pr['code'],
                        'name' => $csv_pr['name'],
                        'type_id' => $type,
                        'create_at'=>fullDateTimeNow(),
                    );
                    $data[] = array_merge($arr[0],array('data' =>json_encode($setting)));

                }
                //print_r($data); die();
            }

        }

        if ($this->form_validation->run() == true && ($this->Product_Model->addNewMultiProduct($data)[0]==true)) {

            $this->session->set_flashdata('message', lang("products_added"));
            redirect(partner_url('product/import'));

        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
//            $this->data['categories'] = $this->site->getAllCategories();
            $this->data['page_title'] = lang('import_products');
            $bc = array(array('link' => site_url('products'), 'page' => lang('products')), array('link' => '#', 'page' => lang('import_products')));
            $meta = array('page_title' => lang('import_products'), 'bc' => $bc);
            $this->page_construct('products/import', $this->data, $meta);

        }
    }
}
