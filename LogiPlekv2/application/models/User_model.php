<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class User_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
  }
  
  public function get_users()
  {
    $this->db->select('user_first, user_last');
    $this->db->from('users'); 
    $this->db->order_by('user_first', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }
}
?>
