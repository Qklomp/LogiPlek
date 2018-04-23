<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes extends MY_Controller {

  public function __construct()
  {
    parent::__construct();    
    $this->load->model('routes_model');
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['routes'] = $this->routes_model->get_routes();
    $data['route_tijden'] = $this->get_begintijden_array($this->routes_model->get_routes_begintijden());

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
    $data['title'] = 'Routes';
    $data['root'] = 'Routes';
    $data['main_content'] = 'admin/routes/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('routenummer', 'Routenummer', 'trim|required');
    $this->form_validation->set_rules('type', 'Type', 'trim|required');

    if ($this->form_validation->run() !== FALSE)
    {
      $this->routes_model->set_route($id);
      $this->session->set_flashdata('aangepast', true);   
      redirect('/routes/', 'refresh');
    }

    $data['route'] = $this->routes_model->get_routes($id);
    if (empty($data['route']))
    {
      show_404();
    }
    $data['js'] = array(
      'parsley.min',
      'bootstrap-datepicker.min',
      'jquery.maskedinput.min',
      'logiplek/forms',
    );
    $data['route_tijden'] = $this->get_begintijden_array($this->routes_model->get_routes_begintijden($id));
    $data['types'] = $this->cms_model->get_route_types();
    $data['title'] = 'Routes - Route ' . $data['route']['routenummer'];
    $data['root'] = 'Routes';
    $data['main_content'] = 'admin/routes/bekijken';

    $this->load->view('admin/includes/template', $data);
  }

  public function get_begintijden_array($a)
  {
    $b = array();
    foreach ($a as $bt)
    {
      if($bt['dag'] === 'ma')
      {
        $b[$bt['route_id']]['ma'] = $bt['tijd'];
      }
      if($bt['dag'] === 'di')
      {
        $b[$bt['route_id']]['di'] = $bt['tijd'];
      }
      if($bt['dag'] === 'wo')
      {
        $b[$bt['route_id']]['wo'] = $bt['tijd'];
      }
      if($bt['dag'] === 'do')
      {
        $b[$bt['route_id']]['do'] = $bt['tijd'];
      }
      if($bt['dag'] === 'vr')
      {
        $b[$bt['route_id']]['vr'] = $bt['tijd'];
      }
      if($bt['dag'] === 'za')
      {
        $b[$bt['route_id']]['za'] = $bt['tijd'];
      }
      if($bt['dag'] === 'zo')
      {
        $b[$bt['route_id']]['zo'] = $bt['tijd'];
      }
    }
    return $b;
  }

  public function printen()
  {
    $this->load->helper('print');
    $columns = array('routenummer', 'snelnummer', 'telefoonnummer', 'type');
    $pdf = pdf('Routes', $this->routes_model->get_routes(), $columns);
    $pdf->Output('distrivers_routes.pdf', 'I');
  }

  public function toevoegen()
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('routenummer', 'Routenummer', 'trim|required');
    $this->form_validation->set_rules('type', 'Type', 'trim|required');    

    if ($this->form_validation->run() === FALSE)
    {
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['types'] = $this->cms_model->get_route_types();
      $data['title'] = 'Route toevoegen';        
      $data['root'] = 'Routes';
      $data['main_content'] = 'admin/routes/toevoegen';
      $this->load->view('admin/includes/template', $data);

    }
    else
    {
      $this->routes_model->add_route();            
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/routes/', 'refresh');
    }
  }

  public function verwijderen($id)
  {
    $this->routes_model->delete_route($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/routes/', 'refresh');
  }
}