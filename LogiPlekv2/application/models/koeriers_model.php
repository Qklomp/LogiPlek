<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Koeriers_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

  public function add_koerier()
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
    
    /* KOERIER */
    $data = array(
      'naam' => $this->input->post('firmanaam'),
      'omgeving' => $this->input->post('omgeving'),      
      'kosten_km' => str_replace(',', '.', $this->input->post('kosten_km')),
      'koeling' => $this->input->post('koeling'),
      'toegevoegd_op' => date("Y-m-d H:i:s"),
      'toegevoegd_door' => $user,
    );
    $this->db->insert('koeriers', $data); 
    $id = $this->db->insert_id();

    /* E-MAIL */
    $email = $this->input->post('email');

    if($email !== '')
    {      
      $this->db->insert('koerier_email', array('koerier_id' => $id, '[e-mail]' => $email));      
    }

    /* TELEFOON */
    $telefoon = $this->input->post('telefoonnummer');

    if($telefoon !== '')
    {      
      $this->db->insert('koerier_telefoon', array('koerier_id' => $id, 'nummer' => $telefoon));
    }     

    /* CONTACT */
    $mobiel = $this->input->post('mobiel');
    $contact = $this->input->post('contact');
  

    if(($mobiel !== '') || ($contact !== ''))
    {
      $this->db->insert('koerier_contact', array('koerier_id' => $id, 'contact' => $contact, 'contact_nummer' => $mobiel));    
    } 
  }
  
  public function delete_koerier($id){
    $this->db->where('id', $id);
    $this->db->delete('koeriers');
  }
  
	public function get_koeriers($id = FALSE, $q = FALSE)
	{
    $this->db->from('koeriers');
    $this->db->join('koerier_adres', 'koerier_adres.koerier_id = koeriers.id', 'left outer');
    $this->db->join('koerier_contact', 'koerier_contact.koerier_id = koeriers.id', 'left outer');
    $this->db->join('koerier_email', 'koerier_email.koerier_id = koeriers.id', 'left outer');
    $this->db->join('koerier_telefoon', 'koerier_telefoon.koerier_id = koeriers.id', 'left outer');
    if ($q !== FALSE)
    {
      $this->db->like('naam', $q);
      $this->db->or_like('omgeving', $q);
    }
    $this->db->order_by('naam', 'asc');

		if ($id === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
		}
		
		$this->db->where('koeriers.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

  public function get_koerier_contacten($id)
  {
    $query = $this->db->get_where('koerier_contact', array('koerier_id' => $id));
    return $query->result_array();
  }
  
  public function set_koerier($id)
  {   
    /* KOERIER */
    $data = array(
      'naam' => $this->input->post('firmanaam'),
      'omgeving' => $this->input->post('omgeving'),      
      'kosten_km' => $this->input->post('kosten_km'),
      'koeling' => $this->input->post('koeling'),
    );
    $this->db->where('id', $id);
    $this->db->update('koeriers', $data); 

    /* E-MAIL */
    $email = $this->input->post('email');

    $query = $this->db->get_where('koerier_email', array('koerier_id' => $id));
    $count= $query->num_rows();    

    if($email !== '')
    {
      if($count === 0)
      {
        $this->db->insert('koerier_email', array('koerier_id' => $id, 'e-mail' => $email));
      }
      else
      {
        $this->db->update('koerier_email', array('e-mail' => $email), array('koerier_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('koerier_email', array('koerier_id' => $id));
    }

    /* TELEFOON */
    $telefoon = $this->input->post('telefoonnummer');

    $query = $this->db->get_where('koerier_telefoon', array('koerier_id' => $id));
    $count= $query->num_rows();    

    if($telefoon !== '')
    {
      if($count === 0)
      {
        $this->db->insert('koerier_telefoon', array('koerier_id' => $id, 'nummer' => $telefoon));
      }
      else
      {
        $this->db->update('koerier_telefoon', array('nummer' => $telefoon), array('koerier_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('koerier_telefoon', array('koerier_id' => $id));
    }

    /* CONTACT */
    $mobiel = $this->input->post('mobiel');
    $contact = $this->input->post('contact');

    $query = $this->db->get_where('koerier_contact', array('koerier_id' => $id));
    $count= $query->num_rows();    

    if(($mobiel !== '') || ($contact !== ''))
    {
      if($count === 0)
      {
        $this->db->insert('koerier_contact', array('koerier_id' => $id, 'contact' => $contact, 'contact_nummer' => $mobiel));
      }
      else
      {
        $this->db->update('koerier_contact', array('contact' => $contact, 'contact_nummer' => $mobiel), array('koerier_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('koerier_contact', array('koerier_id' => $id));
    }
  }
}