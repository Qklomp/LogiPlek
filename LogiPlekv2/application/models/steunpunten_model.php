<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Steunpunten_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function add_steunpunt()
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');

    /* STEUNPUNT */
    $data = array(
      'naam' => $this->input->post('firmanaam'),
      'toegevoegd_op' => date("Y-m-d H:i:s"),
      'toegevoegd_door' => $user,
    );
    $this->db->insert('steunpunten', $data); 
    $id = $this->db->insert_id();

    /* ADRES */
    $data = array(
      'straat' => $this->input->post('straat'),
      'huisnummer' => $this->input->post('huisnummer'),
      'postcode' => $this->input->post('postcode'),
      'plaats' => $this->input->post('plaats'),
      'steunpunt_id' => $id,
    );
    $this->db->insert('steunpunt_adres', $data);   

    /* TELEFOON */
    $telefoon = $this->input->post('telefoon');   
    $this->db->insert('steunpunt_telefoon', array('steunpunt_id' => $id, 'nummer' => $telefoon, 'telefoon_type' => 'Vast'));

    /* E-MAIL */
    $email = $this->input->post('email');   

    if($email !== '')
    {
      $this->db->insert('steunpunt_email', array('steunpunt_id' => $id, '[e-mail]' => $email));
    }

    /* CONTACT */
    $contact = $this->input->post('contact');
    
    if($contact !== '')
    {
      $this->db->insert('steunpunt_contact', array('steunpunt_id' => $id, 'contact' => $contact));
    }

    $mobiel = $this->input->post('mobiel');

    if($mobiel !== '')
    {
      $this->db->insert('steunpunt_telefoon', array('steunpunt_id' => $id, 'nummer' => $mobiel, 'telefoon_type' => 'Mobiel'));
    }  

    $assortiment = $this->input->post('assortiment');
    for($i=0;$i<sizeof($assortiment);$i++)
    {
      $this->db->insert('steunpunt_assortiment', array('steunpunt_id' => $id, 'assortiment_id' => $assortiment[$i]));
    }    
  }

  public function delete_steunpunt($id){
    $this->db->where('id', $id);
    $this->db->delete('steunpunten');
  }

  public function get_steunpunten($id = FALSE, $q = FALSE)
  {
    $this->db->from('steunpunten');
    $this->db->join('steunpunt_adres', 'steunpunt_adres.steunpunt_id = steunpunten.id', 'left outer');
    $this->db->join('steunpunt_contact', 'steunpunt_contact.steunpunt_id = steunpunten.id', 'left outer');
    $this->db->join('steunpunt_email', 'steunpunt_email.steunpunt_id = steunpunten.id', 'left outer');
    if ($q !== FALSE)
    {
      $this->db->like('naam', $q);
      $this->db->or_like('plaats', $q);
    }
    $this->db->order_by('naam', 'asc');
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('steunpunten.id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_steunpunten_telefoonnummers($id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('steunpunt_telefoon');
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('steunpunt_id', $id);
    $query = $this->db->get();
    return $query->result_array();
  }  

  public function get_steunpunten_assortiment($id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('steunpunt_assortiment');
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('steunpunt_id', $id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_steunpunt($id)
  {   
    /* STEUNPUNT */
    $data = array(
      'naam' => $this->input->post('firmanaam'),
    );
    $this->db->where('id', $id);
    $this->db->update('steunpunten', $data);

    /* ADRES */
    $data = array(
      'straat' => $this->input->post('straat'),
      'huisnummer' => $this->input->post('huisnummer'),
      'postcode' => $this->input->post('postcode'),
      'plaats' => $this->input->post('plaats'),
    );
    $this->db->where('steunpunt_id', $id);
    $this->db->update('steunpunt_adres', $data);   

    /* TELEFOON */
    $telefoon = $this->input->post('telefoon'); 
    $this->db->where(array('steunpunt_id' => $id, 'telefoon_type' => 'Vast'));  
    $this->db->update('steunpunt_telefoon', array('nummer' => $telefoon));

    /* E-MAIL */
    $email = $this->input->post('email');   

    $query = $this->db->get_where('steunpunt_email', array('steunpunt_id' => $id));
    $count= $query->num_rows();    

    if($email !== '')
    {
      if($count === 0)
      {
        $this->db->insert('steunpunt_email', array('steunpunt_id' => $id, '[e-mail]' => $email));
      }
      else
      {
        $this->db->update('steunpunt_email', array('[e-mail]' => $email), array('steunpunt_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('steunpunt_email', array('steunpunt_id' => $id));
    }

    /* CONTACT */
    $contact = $this->input->post('contact');
    
    $query = $this->db->get_where('steunpunt_contact', array('steunpunt_id' => $id));
    $count= $query->num_rows();    

    if($contact !== '')
    {
      if($count === 0)
      {
        $this->db->insert('steunpunt_contact', array('steunpunt_id' => $id, 'contact' => $contact));
      }
      else
      {
        $this->db->update('steunpunt_contact', array('contact' => $contact), array('steunpunt_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('steunpunt_contact', array('steunpunt_id' => $id));
    }

    $mobiel = $this->input->post('mobiel');

    $query = $this->db->get_where('steunpunt_telefoon', array('steunpunt_id' => $id, 'telefoon_type' => 'Mobiel'));
    $count= $query->num_rows();    

    if($mobiel !== '')
    {
      if($count === 0)
      {
        $this->db->insert('steunpunt_telefoon', array('steunpunt_id' => $id, 'nummer' => $mobiel, 'telefoon_type' => 'Mobiel'));
      }
      else
      {
        $this->db->update('steunpunt_telefoon', array('nummer' => $mobiel), array('steunpunt_id' => $id, 'telefoon_type' => 'Mobiel'));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('steunpunt_telefoon', array('steunpunt_id' => $id, 'telefoon_type' => 'Mobiel'));
    }

    $this->db->delete('steunpunt_assortiment', array('steunpunt_id' => $id));
    $assortiment = $this->input->post('assortiment');
    for($i=0;$i<sizeof($assortiment);$i++)
    {
      $this->db->insert('steunpunt_assortiment', array('steunpunt_id' => $id, 'assortiment_id' => $assortiment[$i]));
    }
  }
}