<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Personeel extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('personeel_model');
    $this->load->model('cms_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['personeel'] = $this->personeel_model->get_personeel();
    $data['personeel_telefoon'] = $this->get_telefoon_array($this->personeel_model->get_personeel_telefoonnummers());

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
    if (($this->session->flashdata('teruggezet')))
    {
      $data['teruggezet'] = true;
    }

    $data['js'] = array(
      'DataTable/media/js/jquery.dataTables.min',
      'logiplek/datatables',
    );
    $data['title'] = 'Personeel';
    $data['root'] = 'Personeel';
    $data['main_content'] = 'admin/personeel/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($id)
  {
    $data = $this->user_data();
    $this->load->library('form_validation');    

    $this->form_validation->set_rules('voornaam', 'Voornaam', 'trim|required');
    $this->form_validation->set_rules('achternaam', 'Achternaam', 'trim|required');
    $this->form_validation->set_rules('mobiel', 'Mobiel', 'trim|required');
    $this->form_validation->set_rules('woonplaats', 'Woonplaats', 'trim|required');  
    $this->form_validation->set_rules('locatie', 'Locatie', 'trim|required');
    $this->form_validation->set_rules('functie', 'Functie', 'trim|required'); 

    if ($this->form_validation->run() !== FALSE)
    {
      $this->personeel_model->set_personeel($id);  
      $this->session->set_flashdata('aangepast', true); 
      redirect('/personeel/', 'refresh');
    }

    $data['personeel'] = $this->personeel_model->get_personeel($id);
    if (empty($data['personeel']))
    {
      show_404();
    }
    $data['js'] = array(
      'parsley.min',
      'bootstrap-datepicker.min',
      'jquery.maskedinput.min',
      'logiplek/forms',
    );
    $data['functies'] = $this->cms_model->get_functies();
    $data['locaties'] = $this->cms_model->get_locaties();
    $data['personeel_telefoon'] = $this->get_telefoon_array($this->personeel_model->get_personeel_telefoonnummers($id));    
    $data['title'] = 'Personeel - ' . $data['personeel']['voornaam'] . ' ' . $data['personeel']['achternaam'];
    $data['root'] = 'Personeel';
    $data['main_content'] = 'admin/personeel/bekijken';  

    $this->load->view('admin/includes/template', $data);
  }

  private function get_telefoon_array($a)
  {
    $t = array();
    foreach ($a as $tel)
    {
      if(!isset($t[$tel['personeel_id']]['vast']))
      {
        $t[$tel['personeel_id']]['vast'] = '';
      }
      if(!isset($t[$tel['personeel_id']]['mobiel']))
      {
        $t[$tel['personeel_id']]['mobiel'] = '';
      }

      if($tel['telefoon_type'] === 'Vast')
      {
        $t[$tel['personeel_id']]['vast'] = $tel['nummer'];
      }
      else if($tel['telefoon_type'] === 'Mobiel')
      {
         $t[$tel['personeel_id']]['mobiel'] = $tel['nummer'];
      }
    }
    return $t;
  }

  public function historie()
  {
    $data = $this->user_data();
    $data['historisch_personeel'] = $this->personeel_model->get_personeel(FALSE, FALSE, TRUE);
    $data['historisch_personeel_telefoon'] = $this->get_telefoon_array($this->personeel_model->get_personeel_telefoonnummers());

    $data['js'] = array(
      'DataTable/media/js/jquery.dataTables.min',
      'logiplek/datatables',
    );
    $data['title'] = 'Personeel - historie';
    $data['root'] = 'Personeel';
    $data['main_content'] = 'admin/personeel/historie';

    $this->load->view('admin/includes/template', $data);
  }

  public function printen()
  {
    $personeel = array();
    $pt = $this->get_telefoon_array($this->personeel_model->get_personeel_telefoonnummers());
    foreach ($this->personeel_model->get_personeel() as $p)
    {
      $personeel[$p['id']]['naam'] = $p['voornaam'] . ' ' . $p['achternaam'];
      $personeel[$p['id']]['vast'] = $pt[$p['id']]['vast'];
      $personeel[$p['id']]['mobiel'] = $pt[$p['id']]['mobiel'];
      $personeel[$p['id']]['adres'] = $p['straat'] . ' ' . $p['huisnummer'];
      $personeel[$p['id']]['plaats'] = $p['plaats'];
    }

    $this->load->helper('print');
    $columns = array('naam', 'vast', 'mobiel', 'adres', 'plaats');
    $pdf = pdf('Personeel', $personeel, $columns);
    $pdf->Output('distrivers_personeel.pdf', 'I');
  }

  public function reset($id)
  {
    $this->personeel_model->reset_personeel($id);
    $this->session->set_flashdata('teruggezet', true);
    redirect('/personeel/', 'refresh');
  }

  public function toevoegen()
  {
    $data = $this->user_data();
    $this->load->library('form_validation'); 

    $this->form_validation->set_rules('voornaam', 'Voornaam', 'trim|required');
    $this->form_validation->set_rules('achternaam', 'Achternaam', 'trim|required');
    $this->form_validation->set_rules('mobiel', 'Mobiel', 'trim|required');
    $this->form_validation->set_rules('woonplaats', 'Woonplaats', 'trim|required');
    $this->form_validation->set_rules('locatie', 'Locatie', 'trim|required');
    $this->form_validation->set_rules('functie', 'Functie', 'trim|required');
    $this->form_validation->set_rules('email', 'email', 'trim|required');

    if ($this->form_validation->run() === FALSE)
    {
      $data['js'] = array(
        'parsley.min',
        'bootstrap-datepicker.min',
        'jquery.maskedinput.min',
        'logiplek/forms',
      );
      $data['functies'] = $this->cms_model->get_functies();
      $data['locaties'] = $this->cms_model->get_locaties();
      $data['title'] = 'Personeel toevoegen';
      $data['root'] = 'Personeel';
      $data['main_content'] = 'admin/personeel/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    { 
      $this->personeel_model->add_personeel();      
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/personeel/', 'refresh');
    }
  } 

  public function verwijderen($id)
  {
    $this->personeel_model->delete_personeel($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/personeel/', 'refresh');
  }
}