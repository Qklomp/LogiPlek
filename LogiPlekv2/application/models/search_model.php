<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_results()
  {
    $query = $this->input->post('query');

    $this->db->like('autos.nummer', $query);
    $this->db->or_like('koeriers.naam', $query);     
    $this->db->or_like('koeriers.omgeving', $query);      
    $this->db->or_like('personeel.voornaam', $query);
    $this->db->or_like('personeel.achternaam', $query);
    $this->db->or_like('CONCAT(personeel.voornaam,\' \',personeel.achternaam)', $query);
    $this->db->or_like('personeel.plaats', $query);
    $this->db->or_like('routes.nummer', $query);
    $this->db->or_like('steunpunten.naam', $query);
    $this->db->from('autos, koeriers, personeel, routes, steunpunten');
    
    $query = $this->db->get();
    return $query->result_array();
  }
}