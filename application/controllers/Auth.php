<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_Model');
    }

    //home load login
    public function login()
    {

        if ($this->session->userdata('admin_login') == 1)
            redirect(site_url('admin/dashboard'), 'refresh');

        if ($this->session->userdata('partner_login') == 1)
            redirect(site_url('partner/dashboard'), 'refresh');
        $data["page_name"] = "login";

        $this->load->view("Auth/login_layout.php", $data);

    }
    public function AdminLogin()
    {

        if ($this->session->userdata('admin_login') == 1)
            redirect(site_url('admin/dashboard'), 'refresh');

        if ($this->session->userdata('partner_login') == 1)
            redirect(site_url('partner/dashboard'), 'refresh');
        $data["page_name"] = "admin_login";

        $this->load->view("Auth/login_layout.php", $data);

    }

    public function submit_login()
    {
        $credential = $this->validate_login();
//        if(!empty($this->input->post('login_type'))&&($this->input->post('login_type')==1))
//        {
//            $this->process_login($credential,1);
//
//        }
//        if(!empty($this->input->post('login_type'))&&($this->input->post('login_type')==2))
//            $this->process_login($credential,2);

//        $this->session->set_flashdata('error', lang('invalid_login'));
//        redirect(site_url('Auth/Login'), 'refresh');
        $this->process_login($credential,2);

    }
    public function submit_admin_login()
    {
        $credential = $this->validate_login();
//        if(!empty($this->input->post('login_type'))&&($this->input->post('login_type')==1))
//        {
//            $this->process_login($credential,1);
//
//        }
//        if(!empty($this->input->post('login_type'))&&($this->input->post('login_type')==2))
//            $this->process_login($credential,2);

//        $this->session->set_flashdata('error', lang('invalid_login'));
//        redirect(site_url('Auth/Login'), 'refresh');
        $this->process_login($credential,1);

    }

    //Validating login from ajax request
    private function validate_login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password));
        return $credential;
    }
    private function process_login($credential,$type){
        switch ($type) {
            case 1:
                {

                    // Checking login credential for admin
                    $query = $this->db->get_where('admin', $credential);
                    if ($query->num_rows() > 0) {
                        $row = $query->row();
                        $this->session->set_userdata('admin_login', '1');
                        $this->session->set_userdata('admin_id', $row->admin_id);
                        $this->session->set_userdata('login_user_id', $row->admin_id);
                        $this->session->set_userdata('name', $row->name);
                        $this->session->set_userdata('login_type', 'admin');
                        $this->session->set_userdata('user_type', 1);
                        redirect(site_url('admin/dashboard'), 'refresh');
                    }
                    $this->session->set_flashdata('error', lang('invalid_login'));
                    redirect(site_url('Auth/AdminLogin'));
                    break;
                }
            case 2:
                {
                    // Checking login credential for teacher
                    $query = $this->db->get_where('partner', $credential);
                    if ($query->num_rows() > 0) {
                        $this->load->model('Company_Model');
                        $row = $query->row();
                        $company = $this->Company_Model->company($row->partner_id);
                        $this->user_type = 2;//partner
                        $this->user_id = $row->partner_id;
                        $this->session->set_userdata('partner_login', '1');
                        $this->session->set_userdata('partner_status', $company->status);
                        $this->session->set_userdata('user_type', 2);
                        $this->session->set_userdata('partner_id', $row->partner_id);
                        $this->session->set_userdata('partner', $row);
                        $this->session->set_userdata('company_info', $company);
                        if(!$company->status){
                            redirect(partner_url('dashboard'), 'refresh');
                        }
                        else
                        redirect(partner_url('dashboard'), 'refresh');
                    }
                    $this->session->set_flashdata('error', lang('invalid_login'));
                    redirect(site_url('Auth/login'));
                    break;
                }
        }

    }
    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(site_url('Auth/login'), 'refresh');
    }

    function register()
    {
        if ($this->session->userdata('admin_login') == 1)
            redirect(site_url('admin/dashboard'), 'refresh');

        if ($this->session->userdata('partner_login') == 1)
            redirect(site_url('partner/dashboard'), 'refresh');
        $data["page_name"] = "register";
        $this->load->view("Auth/login_layout.php", $data);
    }

    function submit_register()
    {
        $rs = $this->process_register();
        if ($rs[0]) {
            $this->load->model("Auth_Model");
            $this->Auth_Model->getFullPartnerInfo(array('partner.partner_id'=>$rs[1]));

            $this->session->set_flashdata('globalmsg', lang('register_successly_callback'));
            $this->session->set_flashdata('loadPage', true);
            redirect(site_url('Auth/registerSuccessly'), 'refresh');
        } else {
            $this->session->set_flashdata('error', $rs[1]);
            redirect(site_url('Auth/register'), 'refresh');
        }
    }

    private function process_register()
    {
        //create validation
        $this->form_validation->set_rules('email', lang('email'), 'required');
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('password', lang('password'), 'required|max_length[25]');
        $this->form_validation->set_rules('comfirm_password', lang('comfirm_password'), 'required|matches[password]');


        //run validation
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/register/');
        } else {

            //create data in array
            $dt = array('email' => $this->input->post('email'),
                "password" => sha1($this->input->post('password')),
                'name' => $this->input->post('name'),
                'create_at' => fullDateTimeNow(),
                'religion' => 1
            );
            //Check email is exist
            if ($this->checkIfIssetEmail($dt)[0])
                return array(false, lang('error_email_is_exist'));
            //return result in query
            return $this->Auth_Model->registerPartner($dt);
        }
    }

    function checkIfIssetEmail($dt)
    {
        $result = $this->Auth_Model->getPartnerByEmail($dt);
        return $result;

    }

    function registerSuccessly()
    {
        if ((!($this->session->flashdata('loadPage')) && ($this->session->flashdata('loadPage') == true))) {
            show_404();
            exit;
        } else {
            $data["page_name"] = "register_successly";
            $this->load->view("Auth/login_layout.php", $data);
        }
    }

}
