<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
    $this->load->library('SimpleLoginSecure');
  }

  public function logout()
  {
    $this->simpleloginsecure->logout();
    redirect('login', 'refresh');
  }

  public function index()
  {
    $data = $this->user_data();

    if (($this->session->flashdata('aangepast')))
    {
      $data['aangepast'] = true;
    }

    if (($this->session->flashdata('fout')))
    {
      $data['fout'] = true;
    }

    $data['js'] = array(
      'parsley.min',
      'bootstrap-datepicker.min',
      'logiplek/forms',
      'logiplek/gebruiker/index',
    );
    $data['title'] = 'Gebruiker - instellingen';
    $data['root'] = 'Gebruiker';
    $data['main_content'] = 'admin/gebruiker/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function reset_password()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('huidig', 'Huidig wachtwoord', 'required|xss_clean');
    $this->form_validation->set_rules('nieuw', 'Nieuw wachtwoord', 'required|xss_clean');
    $this->form_validation->set_rules('herhaal', 'Herhaal wachtwoord', 'required|xss_clean|matches[nieuw]');

    if( ($this->form_validation->run() === false) )
    {      
      $this->session->set_flashdata('fout', true);
      redirect('gebruiker/instellingen', 'refresh');
    }
    else
    {
      if($this->simpleloginsecure->edit_password($this->session->userdata('user'), $this->input->post('huidig'), $this->input->post('nieuw')))
      {   
        $this->session->set_flashdata('aangepast', true);
        redirect('gebruiker/instellingen', 'refresh');
      }
      else 
      {
        $this->session->set_flashdata('fout', true);
        redirect('gebruiker/instellingen', 'refresh');
      }
    }
  }
}