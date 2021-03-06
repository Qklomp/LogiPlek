<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        $this->load->model('personeel_model');
    }

    public function index()
    {
        $data = $this->user_data();

        $data['emballage'] = $this->emballage_model->get_emballage();
        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();
        $data['emballage_emballagemee'] = $this->emballage_model->get_emballage_emballageMee();
        $data['emballage_emballageretour'] = $this->emballage_model->get_emballage_emballageRetour();

        if (($this->session->flashdata('toegevoegd'))) {
            $data['toegevoegd'] = true;
        }
        if (($this->session->flashdata('aangepast')))
        {
            $data['aangepast'] = true;
        }
        if (($this->session->flashdata('verwijderd')))
        {
            $data['verwijderd'] = true;
        }

        $data['js'] = array(
            'DataTable/media/js/jquery.dataTables.min',
            'logiplek/datatables',
            'logiplek/emballage/toevoegen',
        );

        $data['title'] = 'Emballage';
        $data['root'] = 'Emballage';


        if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) {
            $data['main_content'] = 'admin/emballage/index';
        } else {
            $data['main_content'] = 'admin/emballage/toevoegen';
        }
        $this->load->view('admin/includes/template', $data);
    }

    public function toevoegen()
    {
        $data = $this->user_data();

        if (($this->session->flashdata('toegevoegd'))) {
            $data['toegevoegd'] = true;
        }

        $data['js'] = array(
            'parsley.min',
            'bootstrap-datepicker.min',
            'logiplek/forms',
            'logiplek/emballage/toevoegen',
        );

        $data['vrachtwagen'] = $this->personeel_model->get_vrachtwagen($this->session->userdata('id'));
        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();

        $this->load->library('form_validation');
        $this->load->helper('date');

        $this->form_validation->set_rules('Klantnummer', 'Klantnummer', 'trim|required|numeric');

        if ($this->form_validation->run() === false) {

            $data['autos'] = $this->autos_model->get_autos();

            $data['title'] = 'Emballage';
            $data['root'] = 'Emballage';

            $data['main_content'] = 'admin/emballage/toevoegen';

            $this->load->view('admin/includes/template', $data);
        } else {
            $this->emballage_model->toevoegen_emballage();
            $this->session->set_flashdata('toegevoegd', true);

            if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) {
                redirect('/emballage/', 'refresh');
            } else {
                redirect('/emballage/toevoegen', 'refresh');
            }
        }
    }

    public function bekijken($id)
    {
        $data = $this->user_data();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('Vrachtwagen', 'Vrachtwagen', 'trim|required');
        $this->form_validation->set_rules('Klantnummer', 'Klantnummer', 'trim|required|numeric');
        $this->form_validation->set_rules('Toegevoegd_op', 'Toegevoegd_op', 'trim|required');

        if ($this->form_validation->run() === false) {
            $data['js'] = array(
                'parsley.min',
                'bootstrap-datepicker.min',
                'jquery.maskedinput.min',
                'logiplek/forms',
            );

            $data['autos'] = $this->autos_model->get_autos();
            $data['emballage'] = $this->emballage_model->get_emballage($id);
            $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
            $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();
            $data['emballage_emballagemee'] = $this->emballage_model->get_emballage_emballageMee($id);
            $data['emballage_emballageretour'] = $this->emballage_model->get_emballage_emballageRetour($id);
            $data['title'] = 'emballage';
            $data['root'] = 'emballage';
            $data['main_content'] = 'admin/emballage/bekijken';

            $this->load->view('admin/includes/template', $data);
        } else {
            $this->emballage_model->bewerk_emballage($id);
            $this->session->set_flashdata('aangepast', true);
            redirect('/emballage/', 'refresh');
        }

    }

    public function bewerken($id)
    {
        $data = $this->user_data();

        if (($this->session->flashdata('toegevoegd'))) {
            $data['toegevoegd'] = true;
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('klantnummer', 'Klantnummer', 'trim|required|numeric');

        if ($this->form_validation->run() === false) {

            $data['autos'] = $this->autos_model->get_autos();

            $data['title'] = 'Emballage';
            $data['root'] = 'emballage';
            $data['main_content'] = 'admin/emballage/bekijken';

            $this->load->view('admin/includes/template', $data);
        } else {
            $this->emballage_model->bewerk_emballage($id);
            $this->session->set_flashdata('aangepast', true);
            redirect('/emballage/', 'refresh');
        }
    }

    public function verwijderen($id)
    {
        $this->emballage_model->delete_emballage($id);
        $this->session->set_flashdata('verwijderd', true);
        redirect('/emballage/', 'refresh');
    }

    public function printen()
    {
        $this->load->helper('print');
        $columns = array('klantnummer', 'vrachtwagen', 'toegevoegd_door', 'toegevoegd_op');
        $pdf = pdf('Emballage', $this->emballage_model->get_emballage(), $columns);
        $pdf->Output('distrivers_autos.pdf', 'I');
    }

    public function controleren()
    {
        $data = $this->user_data();

        $data['emballage'] = $this->emballage_model->get_emballage();
        $data['emballage_mee'] = $this->emballage_model->get_emballageMee();
        $data['emballage_retour'] = $this->emballage_model->get_emballageRetour();
        $data['emballage_emballagemee'] = $this->emballage_model->get_emballage_emballageMee();
        $data['emballage_emballageretour'] = $this->emballage_model->get_emballage_emballageRetour();

        $data['js'] = array(
            'DataTable/media/js/jquery.dataTables.min',
            'logiplek/datatables',
            'parsley.min',
            'jquery.maskedinput.min',
            'logiplek/forms',
        );

        $this->load->library('form_validation');
        $this->form_validation->set_rules('Klantnummer', 'Klantnummer', 'trim|required|numeric');
        $data['autos'] = $this->autos_model->get_autos();

        $data['title'] = 'Emballage';
        $data['root'] = 'emballage';

        $data['main_content'] = 'admin/emballage/controleren';

        $this->load->view('admin/includes/template', $data);
    }
}

