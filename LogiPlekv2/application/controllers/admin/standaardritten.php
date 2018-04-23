<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Standaardritten extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cms_model');
    $this->load->model('koeriers_model');
    $this->load->model('personeel_model');
    $this->load->model('steunpunten_model');  
    $this->load->model('ritregistratie_model');
  }

  public function index()
  {
    $data = $this->user_data();
    $data['standaardritten'] = $this->ritregistratie_model->get_standaard_rit();
    $data['participanten'] = $this->cms_model->get_participanten();
    $data['vervoerder'] = array();
    $data['personeel'] = $this->personeel_model->get_personeel();
    foreach( $data['personeel'] as $e ) 
    {
      $data['vervoerder'][$e['id']]['naam'] = $e['voornaam'] . ' ' . $e['achternaam'];
      $data['vervoerder'][$e['id']]['id'] = $e['id'];
    }
    /* MESSAGES */
    if (($this->session->flashdata('toegevoegd')))
    {
      $data['toegevoegd'] = true;
    }
    if (($this->session->flashdata('fout')))
    {
      $data['fout'] = true;
    }
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    $data['title'] = 'Standaardritten opslaan';
    $data['root'] = 'Ritregistratie';
    $data['main_content'] = 'admin/standaardritten/index';
    $this->load->view('admin/includes/template', $data);
  }

  public function opslaan()
  {
    $wj = $this->input->post('week');
    $j = '20' . substr($wj, 2, 3);
    $w = substr($wj, 0, 2);

    if( empty($wj) || ($w > 52) || ($w < 1) )
    {
      $this->session->set_flashdata('fout', true);
      redirect('/ritregistratie/standaardritten/', 'refresh');
    }
    $this->ritregistratie_model->set_standaard_rit($j,$w);
    $this->session->set_flashdata('toegevoegd', true);
    redirect('/ritregistratie/', 'refresh');  
  }

  public function toevoegen()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('participant', 'Participant', 'trim|required');
    $this->form_validation->set_rules('kosten', 'Kosten', 'trim|required');
    $this->form_validation->set_rules('omschrijving', 'Omschrijving', 'trim|required');

    if ($this->form_validation->run() === false)
    {

      $data = $this->user_data();
      $data['participanten'] = $this->cms_model->get_participanten();
      $data['intern'] = array();
      $data['personeel'] = $this->personeel_model->get_personeel();
      foreach( $data['personeel'] as $e ) 
      {
        $data['intern'][$e['id']]['naam'] = $e['voornaam'] . ' ' . $e['achternaam'];
        $data['intern'][$e['id']]['id'] = $e['id'];
      }
      $data['koeriers'] = $this->koeriers_model->get_koeriers();
      $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
      $data['extern'] = array_merge($data['koeriers'], $data['steunpunten']);
      $data['title'] = 'Standaardritten toevoegen';
      $data['root'] = 'Ritregistratie';
      $data['main_content'] = 'admin/standaardritten/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    {
      $this->ritregistratie_model->add_standaard_rit(); 
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/ritregistratie/standaardritten/', 'refresh');
    }
  }

  public function verwijderen($id)
  {
    $this->ritregistratie_model->delete_standaard_rit($id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/ritregistratie/standaardritten/', 'refresh');     
  }
}