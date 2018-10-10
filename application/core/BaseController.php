<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

    var $user_type;
    var $user_id = 0;
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
        //load helper
        $this->load->helper('filter');
        //load assets directory
        $this->data['assets'] = base_url() . 'themes/default/assets/';

        //load userdata
//        if($this->session->userdata('user_type')){
//            $this->user_type = $this->session->userdata('user_type');
//            switch ($this->user_type) {
//                case 1:{ //admin
//                    break;}
//                case 2:{
//                        break;
//                    }
//            if ($this->session->userdata('user_id')) {
//            $this->user_id = $this->session->userdata('user_id');
////            $this->user_data= $this->Auth_Model->UserData($this->user_id);
////            $this->session->set_userdata('user_auth', $this->user_data["type"]);
//            }
//        }
//        }
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
        if( !empty($this->session->userdata('user_type')))
        $meta['user_type'] = $this->session->userdata('user_type');
//        $meta['loggedIn'] = $data['loggedIn'];
//        $meta['Settings'] = $data['Settings'];
        $meta['assets'] = $data['assets'];

        $meta['Settings']["selected_language"] = $this->language;
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


        if(!empty($this->session->userdata('admin_login')))
        {
            $this->Admin = 1;
        }
        else{
            redirect(site_url("Auth/AdminLogin"));
        }
    }

}
class PartnerController extends UserController {

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

        if ($this->session->userdata('user_type')) {
            $this->load->model('Company_Model');
            $this->user_type = $this->session->userdata('user_type');
            $this->partner_id = $this->session->userdata('partner_id');
            $this->user_id = $this->session->userdata('partner_id');
            $this->Partner=1;
            $user_data = $this->Company_Model->company($this->partner_id);
            $this->session->set_userdata('user_data',$user_data);

        }
        else{
            show_404();
            exit();
        }
        if ($this->user_type != 2) {
            redirect(site_url('Auth/Login'));
            exit();
        }

        if(!$user_data->status)
        {
            $this->session->set_flashdata('warning', lang("access_denied"));
            redirect(partner_url('profile/profile'));
            exit();
        }


        if (!empty($this->session->userdata("company_info"))) {
            $this->data["store"] = $this->session->userdata("company_info");
        }

    }

}
class UserController extends BaseController {

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

        if ($this->session->userdata('user_type')) {
            $this->load->model('Company_Model');
            $this->user_type = $this->session->userdata('user_type');
            $this->partner_id = $this->session->userdata('partner_id');
            $this->user_id = $this->session->userdata('partner_id');
            $this->Partner=1;
            $this->session->set_userdata('user_data',$this->Company_Model->company($this->partner_id));

        }

    else{
            show_404();
            exit();
        }
        if ($this->user_type != 2) {
            redirect(site_url('Auth/Login'));
            exit();
        }


        if (!empty($this->session->userdata("company_info"))) {
            $this->data["store"] = $this->session->userdata("company_info");
        }

    }

}
