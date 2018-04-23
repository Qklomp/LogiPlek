<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assortiment extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['assortimenten'] = $this->cms_model->get_assortimenten();
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    
    $data['title'] = 'Steunpunten - Assortiment';      
    $data['root'] = 'Steunpunten';
    $data['main_content'] = 'admin/assortiment/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function aanpassen()
  {
    $this->cms_model->set_assortiment();            
    $this->session->set_flashdata('toegevoegd', true);
    redirect('/steunpunten/', 'refresh');
  }

  public function verwijderen($id)
  {
    $this->cms_model->delete_assortiment($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('steunpunten/assortiment/', 'refresh');     
  }
}