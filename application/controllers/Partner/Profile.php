<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->language("company", $this->language);
        $this->load->model('Company_Model');
    }

    function profile($id = NULL)
    {

        if (!$id || empty($id)) {
            show_404();
            exit();
        }

        $this->data['title'] = lang('profile');

        $company = $this->Company_Model->company($id);
        exit();
        if (!$company) {
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('Admin/Company/listCompany');
        } else {
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['company'] = $company;


            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'class' => 'form-control',
                'type' => 'password',
                'value' => ''
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'class' => 'form-control',
                'type' => 'password',
                'value' => ''
            );
            $this->data['min_password_length'] = 5;
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'class' => 'form-control',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'class' => 'form-control',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            );
            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $company->id,
            );

            $this->data['id'] = $id;

            $this->data['page_title'] = lang('profile');
            $bc = array(array('link' => partner_url('company'), 'page' => lang('company')), array('link' => '#', 'page' => lang('company_site')));
            $meta = array('page_title' => lang('profile'), 'bc' => $bc);
            $this->page_construct('partner/profile', $this->data, $meta);
        }
    }

    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
