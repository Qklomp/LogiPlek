<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 3-5-2018
 * Time: 10:48
 */

class emballage extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('autos_model');
        // $this->load->model('emballage_model');
    }

    public function index(){

        $data = $this->user_data();


        $data['autos'] = $this->autos_model->get_autos();

        $data['title'] = 'Emballage';
        $data['root'] = 'emballage';
        $data['main_content'] = 'admin/emballage/index';

        $this->load->view('admin/includes/template', $data);
    }

    public function toevoegen(){


    }
}