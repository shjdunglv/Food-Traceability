<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->language("company", $this->language);
        $this->load->model('Company_Model');
        $this->load->helper('filter');
    }

    function profile()
    {
        $id = $this->partner_id;
        $this->load->model('Auth_Model');
        $company = $this->Auth_Model->getFullPartnerInfo(array('partner.partner_id' => $id));
        if (!$company[0]) {
            redirect(site_url("Auth/login"));
            exit();
        }
        $company = $company[1];
        if (!$company) {
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('Partner/Profile/Profile');
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
                'value' => $company->partner_id,
            );

            $this->data['id'] = $id;

            $this->data['page_title'] = lang('profile');
            $bc = array(array('link' => partner_url('company'), 'page' => lang('company')), array('link' => '#', 'page' => lang('company_site')));
            $meta = array('page_title' => lang('profile'), 'bc' => $bc);
            $this->page_construct('partner/profile', $this->data, $meta);
        }
    }

    function updateProfile()
    {
        $this->form_validation->set_rules('address_of_company', lang("address_of_company"), 'min_length[2]|max_length[50]|required');
        $this->form_validation->set_rules('phone', lang("phone"), 'required');
        if (empty($_FILES['userfile']['name'])) {
            $this->form_validation->set_rules('userfile', lang("photo_passport"), 'required');

        }
        if ($this->form_validation->run() == true) {

            //upload file
            if ($_FILES['userfile']['size'] > 0) {

                $this->load->library('upload');
                $this->load->library('image_lib');

                $config['upload_path'] = 'uploads/photo_passport';
                $config['allowed_types'] = 'gif|jpg|png';
//                $config['max_size'] = '500';
//                $config['max_width'] = '800';
//                $config['max_height'] = '800';
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect(partner_url('Profile/profile'));
                }


                //create thumb
                $photo = $this->upload->file_name;
                $data['image'] = $photo;
                createThumbs($photo);

                //do insert to database
                $data = array(
                    'partner_id' => $this->partner_id,
                    'address' => $this->input->post('address_of_company'),
                    'phone' => $this->input->post('phone'),
                    'name' => $this->input->post('name_of_company'),
                    'photo_passport' => $photo
                );
                $this->Company_Model->updateCompanyInfo($data);

                // $this->tec->print_arrays($data, $items);
            } //Validateion error
            else {
                $this->session->set_flashdata('error', validation_errors());
                redirect(partner_url('Profile/profile'));

            }
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
