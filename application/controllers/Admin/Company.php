<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->language("company", $this->language);
        $this->load->model('Company_Model');
    }
    function listCompany() {
        if (!$this->Admin) {
            $this->session->set_flashdata('warning', lang("access_denied"));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['companys'] = $this->Company_Model->getAllCompanys();
        $bc = array(array('link' => '#', 'page' => lang('users')));
        $meta = array('page_title' => lang('company'), 'bc' => $bc);
        $this->data['page_title'] = lang('company');
        $this->page_construct('company/index', $this->data, $meta);
    }

    function profile($id = NULL) {
        if (!$id || empty($id)) {
            redirect('Admin/Company/listCompany');
        }

        $this->data['title'] = lang('profile');

        $company = $this->Company_Model->company($id);
        if(!$company) {
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('Admin/Company/listCompany');
        }
        else {
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
            $bc = array(array('link' => admin_url('company'), 'page' => lang('company')), array('link' => '#', 'page' => lang('company_site')));
            $meta = array('page_title' => lang('profile'), 'bc' => $bc);
            $this->page_construct('company/profile', $this->data, $meta);
        }
    }
    function updateCompany()
    {
            //upload file
            if (!empty($_FILES['userfile'])) {

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
                    'partner_id' => $this->input->post('id'),
                    'address' => $this->input->post('address_of_company'),
                    'phone' => $this->input->post('phone'),
                    'name' => $this->input->post('name_of_company'),
                    'photo_passport' => $photo
                );
                $rs = $this->Company_Model->updateCompanyInfoForAdmin($data);

                // $this->tec->print_arrays($data, $items);
            } //Validateion error
            else {
                $data = array(
                    'partner_id' => $this->input->post('id'),
                    'address' => $this->input->post('address_of_company'),
                    'phone' => $this->input->post('phone'),
                    'name' => $this->input->post('name_of_company'),
                    'status' => $this->input->post('status')
                );
                $rs = $this->Company_Model->updateCompanyInfoForAdmin($data);
            }
            if($rs[0]==false){
                $this->session->set_flashdata('error', lang('error_system'));
                redirect(Admin_url('CCompany/listCompany'));
            }
            else{
                $this->session->set_flashdata('success', lang('update_successly'));
                redirect(Admin_url('Company/listCompany'));
            }
    }
    function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
