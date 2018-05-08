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
        $this->load->model('emballage_model');
    }

    public function index(){

        $data = $this->user_data();

        $data['emballage'] = $this->emballage_model->get_emballage();

        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();
        $data['emballage_emballagemee'] = $this->emballage_model->get_emballage_emballageMee();
        $data['emballage_emballageretour'] = $this->emballage_model->get_emballage_emballageRetour();

        if (($this->session->flashdata('toegevoegd')))
        {
            $data['toegevoegd'] = true;
        }

        $data['title'] = 'Emballage';
        $data['root'] = 'emballage';


        if($this->session->userdata('functie_id')==0 || $this->session->userdata('functie_id')==3) {
            $data['main_content'] = 'admin/emballage/index';
        }else{
            $data['main_content'] = 'admin/emballage/toevoegen';
        }
        $this->load->view('admin/includes/template', $data);
    }

    public function toevoegen(){

        $data = $this->user_data();

        if (($this->session->flashdata('toegevoegd')))
        {
            $data['toegevoegd'] = true;
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('Klantnummer', 'Klantnummer', 'trim|required|numeric');

        if ($this->form_validation->run() === false) {

            $data['autos'] = $this->autos_model->get_autos();

            $data['title'] = 'Emballage';
            $data['root'] = 'emballage';

            $data['main_content'] = 'admin/emballage/toevoegen';

            $this->load->view('admin/includes/template', $data);
        }else{
            $this->emballage_model->toevoegen_emballage();
            $this->session->set_flashdata('toegevoegd', true);

            if($this->session->userdata('functie_id')==0 || $this->session->userdata('functie_id')==3){
                redirect('/emballage/', 'refresh');
            }else{
                redirect('/emballage/toevoegen', 'refresh');;
            }
        }


    }

}