<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participanten extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['participanten'] = $this->cms_model->get_participanten();
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    
    $data['title'] = 'Ritregistratie - Participanten';      
    $data['root'] = 'Ritregistratie';
    $data['main_content'] = 'admin/participanten/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function aanpassen()
  {
    $this->cms_model->set_participanten();            
    $this->session->set_flashdata('toegevoegd', true);
    redirect('/ritregistratie/', 'refresh');
  }

  public function verwijderen($id)
  {
    $this->cms_model->delete_participant($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/ritregistratie/participanten/', 'refresh');     
  }
}