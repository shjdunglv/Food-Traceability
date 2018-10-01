<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Errors extends BaseController
{

    public function error404(){
        $this->load->view("default/errors/cli/error_404");
    }
}
