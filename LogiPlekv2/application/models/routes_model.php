<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Routes_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function add_route()
  {   
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');

    /* ROUTE */
    $data = array(
      'nummer' => $this->input->post('routenummer'),
      'route_type_id' => $this->input->post('type'),
      'toegevoegd_op' => date("Y-m-d H:i:s"),
      'toegevoegd_door' => $user,
    );
    $this->db->insert('routes', $data);
    $id = $this->db->insert_id(); 

    /* TELEFOON */
    $telefoon = $this->input->post('telefoonnummer');
    $snelnummer = $this->input->post('snelnummer');

    if(($telefoon !== '') || ($snelnummer !== ''))
    {      
      $this->db->insert('route_telefoon', array('route_id' => $id, 'nummer' => $telefoon, 'snelnummer' => $snelnummer));
    }
  }

  public function delete_route($id){
    $this->db->where('id', $id);
    $this->db->delete('routes');
  }

  public function get_routes($id = FALSE, $q = FALSE)
  {
    $this->db->select('
      routes.id,
      routes.nummer AS routenummer,  
      routes.route_type_id,
      routes.toegevoegd_op, 
      routes.toegevoegd_door,  
      route_types.type, 
      route_telefoon.nummer AS telefoonnummer,
      route_telefoon.snelnummer,
    ');
    $this->db->from('routes');
    $this->db->join('route_types', 'route_types.id = routes.route_type_id', 'left outer');
    $this->db->join('route_telefoon', 'route_telefoon.route_id = routes.id', 'left outer');
    if ($q !== FALSE)
    {
      $this->db->like('routes.nummer', $q);
    }
    $this->db->order_by('routenummer', 'asc');

    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('routes.id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_routes_begintijden($id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('route_begintijden');
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('route_id', $id);
    $query = $this->db->get();
    return $query->result_array();
  } 

  public function set_route($id)
  {   
    /* ROUTE */
    $data = array(
      'nummer' => $this->input->post('routenummer'),
      'route_type_id' => $this->input->post('type'),
    );
    $this->db->where('id', $id);
    $this->db->update('routes', $data); 

    /* TELEFOON */
    $telefoon = $this->input->post('telefoonnummer');
    $snelnummer = $this->input->post('snelnummer');

    $query = $this->db->get_where('route_telefoon', array('route_id' => $id));
    $count= $query->num_rows();  

    if(($telefoon !== '') || ($snelnummer !== ''))
    {      
      if($count === 0)
      {
        $this->db->insert('route_telefoon', array('route_id' => $id, 'nummer' => $telefoon, 'snelnummer' => $snelnummer));
      }
      else
      {
        $this->db->update('route_telefoon', array('nummer' => $telefoon, 'snelnummer' => $snelnummer), array('route_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('route_telefoon', array('route_id' => $id));
    }
  }
}