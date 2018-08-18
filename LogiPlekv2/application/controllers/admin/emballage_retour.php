<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 24-5-2018
 * Time: 11:03
 */

class emballage_retour extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('emballage_model');
    }

    public function index()
    {
        $data = $this->user_data();

        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();

        $data['title'] = 'Emballage soorten retour';
        $data['root'] = 'emballage';
        $data['main_content'] = 'admin/emballage_retour/index';

        $this->load->view('admin/includes/template', $data);

    }

    public function verwijderen($id)
    {
        $this->emballage_model->delete_emballage_soorten_retour($id);
        $this->session->set_flashdata('verwijderd', true);
        redirect('/emballage_retour/', 'refresh');
    }

    public function aanpassen()
    {
        $this->emballage_model->set_emballage_soorten_retour();
        $this->session->set_flashdata('toegevoegd', true);
        redirect('/emballage_retour/', 'refresh');
    }
}