<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autos extends MY_Controller {

  public function __construct()
  {
    parent::__construct();    
    $this->load->model('autos_model');    
    $this->load->model('routes_model');
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['autos'] = $this->autos_model->get_autos();

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
    
    $data['js'] = array(
      'DataTable/media/js/jquery.dataTables.min',
      'logiplek/datatables',
    );
    $data['title'] = 'Auto\'s';
    $data['root'] = 'Auto\'s';
    $data['main_content'] = 'admin/autos/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('autonummer', 'Autonummer', 'trim|required');
    $this->form_validation->set_rules('kenteken', 'Kenteken', 'trim|required');
    $this->form_validation->set_rules('type', 'Type', 'trim|required');

    if ($this->form_validation->run() === false)
    {
      $data['auto'] = $this->autos_model->get_autos($id);
      if (empty($data['auto']))
      {
        show_404();
      }

      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['routes'] = $this->routes_model->get_routes();
      $data['types'] = $this->cms_model->get_auto_types();
      $data['title'] = 'Auto\'s - Auto ' . $data['auto']['autonummer'];      
      $data['root'] = 'Auto\'s';
      $data['main_content'] = 'admin/autos/bekijken';

      $this->load->view('admin/includes/template', $data);
    }
    else
    {
      $this->autos_model->set_auto($id); 
      $this->session->set_flashdata('aangepast', true);
      redirect('/autos/', 'refresh');
    }
  }

  public function get_kmstand($id)
  {
    $r = $this->autos_model->get_autos($id);
    $km = $r['kmstand'];
    print json_encode($km);
  }

  public function get_kenteken($id)
  {
    $r = $this->autos_model->get_autos($id);
    $kenteken = $r['kenteken'];
    print json_encode($kenteken);
  }

  public function printen()
  {
    $this->load->helper('print');
    $columns = array('autonummer', 'kenteken', 'kmstand', 'routenummer', 'type');
    $pdf = pdf('Auto\'s', $this->autos_model->get_autos(), $columns);
    $pdf->Output('distrivers_autos.pdf', 'I');
  }

  public function toevoegen()
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('autonummer', 'Autonummer', 'trim|required');
    $this->form_validation->set_rules('kenteken', 'Kenteken', 'trim|required');
    $this->form_validation->set_rules('type', 'Type', 'trim|required');     

    if ($this->form_validation->run() === false)
    {
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['routes'] = $this->routes_model->get_routes();
      $data['types'] = $this->cms_model->get_auto_types();
      $data['title'] = 'Auto toevoegen';
      $data['root'] = 'Auto\'s';
      $data['main_content'] = 'admin/autos/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    {
      $this->autos_model->add_auto();      
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/autos/', 'refresh');
    }
  }

  public function verwijderen($id)
  {
    $this->autos_model->delete_auto($id);    
    $this->session->set_flashdata('verwijderd', true);
    redirect('/autos/', 'refresh');
  }
}