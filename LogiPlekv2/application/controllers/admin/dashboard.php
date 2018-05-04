<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('autos_model');    
    $this->load->model('koeriers_model');
    $this->load->model('personeel_model');
    $this->load->model('routes_model');
    $this->load->model('steunpunten_model');
    $this->load->model('update_model');
  }

  public function index()
  {
    $data = $this->user_data();

    $data['autos'] = $this->autos_model->get_autos();
    $data['koeriers'] = $this->koeriers_model->get_koeriers();
    $data['personeel'] = $this->personeel_model->get_personeel();
    $data['routes'] = $this->routes_model->get_routes();
    $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
    $data['updates'] = $this->update_model->get_updates(2);
    $data['title'] = 'Dashboard';
    $data['root'] = 'Dashboard';



    if($this->session->userdata('functie_id')==0)
    {
        $data['main_content'] = 'admin/pages/dashboard';
    }
    else if($this->session->userdata('functie_id')==3)
    {
        $data['main_content'] = 'admin/pages/planner_Dashboard';
    }
    else{
        $data['main_content'] = 'admin/pages/chauffeur_Dashboard';
    }

      $this->load->view('admin/includes/template', $data);
  }
  public function updates()
  {
    $data = $this->user_data();   
    $data['updates'] = $this->update_model->get_updates();
    $data['title'] = 'Dashboard - updates';
    $data['root'] = 'Dashboard';
    $data['main_content'] = 'admin/pages/updates'; 
    $this->load->view('admin/includes/template', $data);
  }
}