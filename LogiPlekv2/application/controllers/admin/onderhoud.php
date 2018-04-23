<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Onderhoud extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('autos_model');
    $this->load->model('onderhoud_model');
    $this->load->model('personeel_model');
    $this->load->model('user_model');
  }

  public function index()
  {
    $data = $this->user_data();
    
    /* MESSAGES */
    if (($this->session->flashdata('toegevoegd')))
    {
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
    if (($this->session->flashdata('niet_gevonden')))
    {
      $data['niet_gevonden'] = true;
    }

    $data['onderhoud'] = $this->onderhoud_model->get_onderhoud();
    $data['schade'] = $this->onderhoud_model->get_schade();

    $data['title'] = 'Onderhoud & Schade';
    $data['root'] = 'Onderhoud';
    $data['main_content'] = 'admin/onderhoud/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    
    $data['onderhoud'] = $this->onderhoud_model->get_onderhoud($id);

    $data['autos'] = $this->autos_model->get_autos();
    $data['personeel'] = $this->personeel_model->get_personeel();
    $data['users'] = $this->user_model->get_users();

    $data['action'] = 'bekijken';
    $data['title'] = 'Onderhoud of schade bekijken';
    $data['root'] = 'Onderhoud';
    $data['main_content'] = 'admin/onderhoud/toevoegen';

    $this->load->view('admin/includes/template', $data);
  }

  public function toevoegen()
  {
    $this->load->library('form_validation'); 
    $this->form_validation->set_rules('datum', 'Datum', 'required');      
    $this->form_validation->set_rules('autonummer', 'Auto', 'required');
    $this->form_validation->set_rules('kenteken', 'Kenteken', 'required');
    $this->form_validation->set_rules('chauffeur', 'Chauffeur', 'required');
    $this->form_validation->set_rules('omschrijving', 'Omschrijving', 'required');
    $this->form_validation->set_rules('user', 'Ingevoerd door', 'required');

    # SET VALUE RULES      
    $this->form_validation->set_rules('plaats', 'Plaats per kilometer', '');
    $this->form_validation->set_rules('kosten', 'Kosten', '');     

    if ($this->form_validation->run() === FALSE)
    {
      $data = $this->user_data();
      
      $data['autos'] = $this->autos_model->get_autos();
      $data['personeel'] = $this->personeel_model->get_personeel();
      $data['users'] = $this->user_model->get_users();

      $data['action'] = 'toevoegen';
      $data['title'] = 'Onderhoud of schade toevoegen';
      $data['root'] = 'Onderhoud';
      $data['main_content'] = 'admin/onderhoud/toevoegen';

      $this->load->view('admin/includes/template', $data);
    }
    else
    {
      $this->onderhoud_model->add_onderhoud();      
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/onderhoud/', 'refresh');
    }
  }

  public function verwijderen($id)
  {
    $this->onderhoud_model->delete_onderhoud($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/onderhoud/', 'refresh');
  }
}