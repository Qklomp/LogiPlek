<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schadebedrijven extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['bedrijven'] = $this->cms_model->get_schadebedrijven();
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    
    $data['title'] = 'Onderhoud - Bedrijven';      
    $data['root'] = 'Onderhoud';
    $data['main_content'] = 'admin/schadebedrijven/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function aanpassen()
  {
    $this->cms_model->set_schadebedrijven();            
    $this->session->set_flashdata('toegevoegd', true);
    redirect('/onderhoud/', 'refresh');
  }

  public function verwijderen($id)
  {
    $this->cms_model->delete_schadebedrijf($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/onderhoud/bedrijven/', 'refresh');     
  }
}