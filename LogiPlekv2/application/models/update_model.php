<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_updates($n = FALSE)
  {
    $this->db->select('*');
    $this->db->from('updates');
    if ($n !== FALSE)
    {
      $this->db->limit($n);
    }
    $this->db->order_by('datum', 'desc');

    $query = $this->db->get();
    return $query->result_array();
  }
}