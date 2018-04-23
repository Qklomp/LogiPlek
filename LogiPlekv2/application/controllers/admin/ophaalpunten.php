<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ophaalpunten extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['ophaalpunten'] = $this->cms_model->get_ophaalpunten();
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    
    $data['title'] = 'Ritregistratie - Ophaalpunten';      
    $data['root'] = 'Ritregistratie';
    $data['main_content'] = 'admin/ophaalpunten/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function aanpassen()
  {
    $this->cms_model->set_ophaalpunten();            
    $this->session->set_flashdata('toegevoegd', true);
    redirect('/ritregistratie/', 'refresh');
  }

  public function get_kosten($id)
  {
    $r = $this->cms_model->get_ophaalpunten($id);
    $km = $r['prijs'];
    print json_encode($km);
  }

  public function verwijderen($id)
  {
    $this->cms_model->delete_ophaalpunt($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/ritregistratie/ophaalpunten/', 'refresh');     
  }
}