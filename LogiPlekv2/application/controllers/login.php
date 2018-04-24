<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model');
  }

  public function index()
  {
    if ($this->session->userdata('logged_in'))
    {
      redirect('admin/dashboard', 'refresh');
    }
    if (($this->session->flashdata('fout')))
    {
      $data['fout'] = true;
    }

    $this->load->library('SimpleLoginSecure');
    $this->simpleloginsecure->create('miechelwachtmeester@distrivers.nl', '12345', false);

    $data['title'] = 'Login';
    $this->load->helper('form');
    $this->load->view('login_form', $data);
  }

  public function validate()
  {
    $this->load->library('SimpleLoginSecure');
    if($this->simpleloginsecure->login($this->input->post('email'), $this->input->post('wachtwoord'))) {
      redirect('admin/dashboard', 'refresh');
    }
    else
    {
      $this->session->set_flashdata('fout', true);
      redirect('login/', 'refresh');
    }
  }
}

?>
