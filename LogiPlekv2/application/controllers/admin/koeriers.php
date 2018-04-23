<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koeriers extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('koeriers_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['koeriers'] = $this->koeriers_model->get_koeriers();

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
    $data['title'] = 'Koeriers';
    $data['root'] = 'Koeriers';
    $data['main_content'] = 'admin/koeriers/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('firmanaam', 'Firmanaam', 'trim|required');
    $this->form_validation->set_rules('telefoonnummer', 'Telefoonnummer', 'trim');
    $this->form_validation->set_rules('email', 'E-mail', 'trim');
    $this->form_validation->set_rules('omgeving', 'Omgeving', 'trim|required');
    $this->form_validation->set_rules('kosten_km', 'Kosten per kilometer', 'trim|required');    
    $this->form_validation->set_rules('koeling', 'Koeling', 'trim|required');
    $this->form_validation->set_rules('contact', 'Contact', 'trim');
    $this->form_validation->set_rules('mobiel', 'Mobiel', 'trim');

    if ($this->form_validation->run() !== FALSE)
    {
      $this->koeriers_model->set_koerier($id);   
      $this->session->set_flashdata('aangepast', true);
      redirect('/koeriers/', 'refresh');
    }

    $data['koerier'] = $this->koeriers_model->get_koeriers($id);

    if (empty($data['koerier']))
    {
      show_404();
    }
    $data['js'] = array(
      'parsley.min',
      'bootstrap-datepicker.min',
      'jquery.maskedinput.min',
      'logiplek/forms',
    );
    $data['contacten'] = $this->koeriers_model->get_koerier_contacten($id);
    $data['title'] = 'Koeriers - ' . $data['koerier']['naam'];
    $data['root'] = 'Koeriers';
    $data['main_content'] = 'admin/koeriers/bekijken';

    $this->load->view('admin/includes/template', $data);
  }

  public function get_kosten($id)
  {
    $k = $this->koeriers_model->get_koeriers($id);       
    if(!empty($k))
    {
      print json_encode($k['kosten_km']);
      return true;
    }
    return false;
  }

  public function printen()
  {
    $this->load->helper('print');
    $columns = array('naam', 'contact', 'nummer', 'contact_nummer', 'omgeving');
    $pdf = pdf('Koeriers', $this->koeriers_model->get_koeriers(), $columns);
    $pdf->Output('distrivers_koeriers.pdf', 'I');
  }

  public function toevoegen()
  {
    $data = $this->user_data();
    $this->load->library('form_validation'); 

    $this->form_validation->set_rules('firmanaam', 'Firmanaam', 'trim|required');
    $this->form_validation->set_rules('telefoonnummer', 'Telefoonnummer', 'trim');
    $this->form_validation->set_rules('email', 'E-mail', 'trim');
    $this->form_validation->set_rules('omgeving', 'Omgeving', 'trim|required');
    $this->form_validation->set_rules('kosten_km', 'Kosten per kilometer', 'trim|required');    
    $this->form_validation->set_rules('koeling', 'Koeling', 'trim|required');
    $this->form_validation->set_rules('contact', 'Contact', 'trim');
    $this->form_validation->set_rules('mobiel', 'Mobiel', 'trim');

    if ($this->form_validation->run() === FALSE)
    {
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['title'] = 'Koerier toevoegen';
      $data['root'] = 'Koeriers';
      $data['main_content'] = 'admin/koeriers/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    { 
      $this->koeriers_model->add_koerier();      
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/koeriers/', 'refresh');
    }
  } 

  public function verwijderen($id)
  {
    $this->koeriers_model->delete_koerier($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/koeriers/', 'refresh');
  }
}