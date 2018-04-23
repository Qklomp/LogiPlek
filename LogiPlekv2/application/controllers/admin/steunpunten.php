<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Steunpunten extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('steunpunten_model');
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
    $data['steunpunten_telefoon'] = $this->get_telefoon_array($this->steunpunten_model->get_steunpunten_telefoonnummers());

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
    $data['assortimenten'] = $this->cms_model->get_assortimenten();
    $data['steunpunt_assortiment'] = $this->steunpunten_model->get_steunpunten_assortiment();
    foreach ($data['steunpunt_assortiment'] as $s)
    {
      $data['steunpunt_assortiment'][$s['steunpunt_id']][$s['assortiment_id']] = true;
    }

    $data['title'] = 'Steunpunten';      
    $data['root'] = 'Steunpunten';
    $data['main_content'] = 'admin/steunpunten/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    $this->load->library('form_validation');

    $this->form_validation->set_rules('firmanaam', 'Firmanaam', 'trim|required');
    $this->form_validation->set_rules('telefoon', 'Telefoon', 'trim|required');
    $this->form_validation->set_rules('straat', 'Straat', 'trim|required');    
    $this->form_validation->set_rules('huisnummer', 'Huisnummer', 'trim|required');
    $this->form_validation->set_rules('plaats', 'Plaats', 'trim|required');

    if ($this->form_validation->run() !== false)
    {
      $this->steunpunten_model->set_steunpunt($id); 
      $this->session->set_flashdata('aangepast', true);  
      redirect('/steunpunten/', 'refresh');
    }

    else
    {
      $data['steunpunt'] = $this->steunpunten_model->get_steunpunten($id);
      if (empty($data['steunpunt']))
      {
        show_404();
      }
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['steunpunt_telefoon'] = $this->get_telefoon_array($this->steunpunten_model->get_steunpunten_telefoonnummers($id));
      $data['assortimenten'] = $this->cms_model->get_assortimenten();
      $data['steunpunt_assortiment'] = $this->steunpunten_model->get_steunpunten_assortiment($id);
      foreach ($data['steunpunt_assortiment'] as $s)
      {
        $data['steunpunt_assortiment'][$s['steunpunt_id']][$s['assortiment_id']] = true;
      }
      $data['title'] = 'Steunpunten - ' . $data['steunpunt']['naam'];      
      $data['root'] = 'Steunpunten';
      $data['main_content'] = 'admin/steunpunten/bekijken';

      $this->load->view('admin/includes/template', $data);
    }
  }

  public function get_telefoon_array($a)
  {
    $t = array();
    foreach ($a as $tel)
    {
      if(!isset($t[$tel['steunpunt_id']]['vast']))
      {
        $t[$tel['steunpunt_id']]['vast'] = '';
      }
      if(!isset($t[$tel['steunpunt_id']]['mobiel']))
      {
        $t[$tel['steunpunt_id']]['mobiel'] = '';
      }
      if($tel['telefoon_type'] === 'Vast')
      {
        $t[$tel['steunpunt_id']]['vast'] = $tel['nummer'];
      }
      else if($tel['telefoon_type'] === 'Mobiel')
      {
         $t[$tel['steunpunt_id']]['mobiel'] = $tel['nummer'];
      }
    }
    return $t;
  }

  public function printen()
  {
    $steunpunten = array();
    $st = $this->get_telefoon_array($this->steunpunten_model->get_steunpunten_telefoonnummers());
    foreach ($this->steunpunten_model->get_steunpunten() as $s)
    {
      $steunpunten[$s['id']]['naam'] = $s['naam'];
      $steunpunten[$s['id']]['vast'] = $st[$s['id']]['vast'];
      $steunpunten[$s['id']]['mobiel'] = $st[$s['id']]['mobiel'];
      $steunpunten[$s['id']]['adres'] = $s['straat'] . ' ' . $s['huisnummer'];
      $steunpunten[$s['id']]['plaats'] = $s['plaats'];
    }

    $this->load->helper('print');
    $columns = array('naam', 'vast', 'mobiel', 'adres', 'plaats');
    $pdf = pdf('Steunpunten', $steunpunten, $columns);
    $pdf->Output('distrivers_steunpunten.pdf', 'I');
  }

  public function toevoegen()
  {
    $data = $this->user_data();
    $this->load->library('form_validation'); 

    $this->form_validation->set_rules('firmanaam', 'Firmanaam', 'trim|required');
    $this->form_validation->set_rules('telefoon', 'Telefoon', 'trim|required');
    $this->form_validation->set_rules('straat', 'Straat', 'trim|required');    
    $this->form_validation->set_rules('huisnummer', 'Huisnummer', 'trim|required');
    $this->form_validation->set_rules('plaats', 'Plaats', 'trim|required');

    if ($this->form_validation->run() === false)
    {
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['assortimenten'] = $this->cms_model->get_assortimenten();
      $data['title'] = 'Steunpunten - Toevoegen';        
      $data['root'] = 'Steunpunten';
      $data['main_content'] = 'admin/steunpunten/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    { 
      $this->steunpunten_model->add_steunpunt();            
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/steunpunten/', 'refresh');
    }
  } 

  public function verwijderen($id)
  {
    $this->steunpunten_model->delete_steunpunt($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/steunpunten/', 'refresh');     
  }
}