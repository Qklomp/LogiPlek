<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_users()
    {
        $this->db->select('email');
        $this->db->from('gebruiker');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
