<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  public function __construct()
  {
    parent::__construct();


      $handle = fopen('D://login.txt', 'a');
      fwrite($handle, $this->session->userdata('logged_in').' Hi');
      fclose($handle);

      if (!$this->session->userdata("logged_in"))
      {
          redirect('login', 'refresh');
      }
  }

  public function user_data()
  {
    $data['email'] = $this->session->userdata('email');
    $data['voornaam'] = $this->session->userdata('voornaam');
    $data['achternaam'] = $this->session->userdata('achternaam');
    return $data;
  }
  
}