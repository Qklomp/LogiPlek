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
    }

    public function index()
    {
        $data = $this->user_data();

        $data['title'] = 'berichten';
        $data['root'] = 'bericht';
        $data['main_content'] = 'admin/bericht/index';

        $this->load->view('admin/includes/template', $data);
    }
}