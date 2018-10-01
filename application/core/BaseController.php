<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        //set Timezone
        date_default_timezone_set("Asia/Bangkok");
        //load setting
        $this->theme = $this->db->get_where('settings', array('type' => 'system_theme'))->row()->description.'/views/';
        //get language setting in DB if not set default;
        $this->language = 'vietnam';
        $this->load->language("app",$this->language);
        $this->load->language("error",$this->language);

        $this->data['assets'] = base_url() . 'themes/default/assets/';
        //menu left
        $this->m = strtolower($this->router->fetch_class());
        $this->v = strtolower($this->router->fetch_method());
        $this->data['m']= $this->m;
        $this->data['v'] = $this->v;

    }

    function page_construct($page, $data = array(), $meta = array()) {
        if(empty($meta)) { $meta['page_title'] = $data['page_title']; }
        $meta['message'] = isset($data['message']) ? $data['message'] : $this->session->flashdata('message');
        $meta['error'] = isset($data['error']) ? $data['error'] : $this->session->flashdata('error');
        $meta['warning'] = isset($data['warning']) ? $data['warning'] : $this->session->flashdata('warning');
        $meta['Admin'] = "admin";
//        $meta['loggedIn'] = $data['loggedIn'];
//        $meta['Settings'] = $data['Settings'];
        $meta['assets'] = $data['assets'];

        $meta['store'] = json_decode('{
    "id": "1",
    "name": "SimplePOS",
    "code": "POS",
    "logo": "logo.png",
    "email": "store@tecdiary.com",
    "phone": "012345678",
    "address1": "Address Line 1",
    "address2": "",
    "city": "Petaling Jaya",
    "state": "Selangor",
    "postal_code": "46000",
    "country": "Malaysia",
    "currency_code": "MYR",
    "receipt_header": null,
    "receipt_footer": "This is receipt footer for store"
  }');
        $meta['Settings'] = json_decode('{"bsty":"3","display_kb":"0","default_category":"1","default_discount":"0","item_addition":"1","barcode_symbology":"","pro_limit":"10","decimals":"2","thousands_sep":",","decimals_sep":".","focus_add_item":"ALT+F1","add_customer":"ALT+F2","toggle_category_slider":"ALT+F10","cancel_sale":"ALT+F5","suspend_sale":"ALT+F6","print_order":"ALT+F11","print_bill":"ALT+F12","finalize_sale":"ALT+F8","today_sale":"Ctrl+F1","open_hold_bills":"Ctrl+F2","close_register":"ALT+F7","java_applet":"0","receipt_printer":"","pos_printers":"","cash_drawer_codes":"","char_per_line":"42","rounding":"1","pin_code":"abdbeb4d8dbe30df8430a8394b7218ef","purchase_code":"65806230-5697-4f94-89f4-49275c3c19d8","envato_username":"sgr1875","theme_style":"green","after_sale_page":null,"overselling":"1","multi_store":null,"qty_decimals":"2","symbol":null,"sac":"0","display_symbol":null,"remote_printing":"1","printer":"1","order_printers":null,"auto_print":"0","local_printers":null,"rtl":null,"print_img":null,"selected_language":"english"}
    ');
//        $meta['suspended_sales'] = $this->site->getUserSuspenedSales();
//        $meta['qty_alert_num'] = $this->site->getQtyAlerts();
        $this->load->view($this->theme . 'header', $meta);
        $this->load->view($this->theme . $page, $data);
        $this->load->view($this->theme . 'footer');
    }
}

class AdminController extends BaseController {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();

        $this->Admin = 1;
    }

}
