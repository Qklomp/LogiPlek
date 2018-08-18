<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 24-5-2018
 * Time: 11:03
 */

class emballage_mee extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('emballage_model');
    }

    public function index()
    {
        $data = $this->user_data();

        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();

        $data['title'] = 'Emballage soorten mee';
        $data['root'] = 'emballage';
        $data['main_content'] = 'admin/emballage_mee/index';

        $this->load->view('admin/includes/template', $data);

    }

    public function verwijderen($id)
    {
        $this->emballage_model->delete_emballage_soorten_mee($id);
        $this->session->set_flashdata('verwijderd', true);
        redirect('/emballage_mee/', 'refresh');
    }

    public function aanpassen()
    {
        $this->emballage_model->set_emballage_soorten_mee();
        $this->session->set_flashdata('toegevoegd', true);
        redirect('/emballage_mee/', 'refresh');
    }


}