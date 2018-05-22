<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 3-5-2018
 * Time: 10:43
 */

class Bericht extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bericht_model');
    }

    public function index()
    {
        $handle = fopen('D://login.txt', 'a');
        $data = $this->user_data();
        fwrite($handle, print_r($data));
        $data['contacten'] = $this->bericht_model->get_contacten($data['id']);

        $data['js'] = array(
            'logiplek/bericht/index',
        );

        $data['title'] = 'Berichten';
        $data['root'] = 'bericht';
        $data['main_content'] = 'admin/bericht/index';

        fclose($handle);

        $this->load->view('admin/includes/template', $data);
    }


    public function get_Chat(){

    }


}