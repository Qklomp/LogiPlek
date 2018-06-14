<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $data = $this->user_data();
        $data['contacten'] = $this->bericht_model->get_contacten($data['id']);

        $data['js'] = array(
            'logiplek/bericht/index',
        );

        $data['title'] = 'Berichten';
        $data['root'] = 'bericht';
        $data['main_content'] = 'admin/bericht/index';

        $this->load->view('admin/includes/template', $data);
    }


    public function get_chat()
    {
        $data = $this->user_data();
        $data['contactId'] = $this->input->post('contactId');
        $berichten = $this->bericht_model->get_berichten($data['id'], $data['contactId']);
        echo json_encode($berichten);
    }

    public function verstuur_bericht()
    {
        $this->bericht_model->verstuur_bericht();
        return true;
    }

    public function refreshCheck()
    {
        $data = $this->user_data();
        echo json_encode($this->bericht_model->refreshCheck($data['id']));
    }

    public function contactSearch()
    {
        $searchValue = $this->input->post('searchValue');
        $contacten = $this->bericht_model->contactSearch($searchValue);
        echo json_encode($contacten);
    }
}