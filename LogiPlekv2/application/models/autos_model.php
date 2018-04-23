<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autos_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

  public function add_auto()
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
   
    /* AUTO */
    $data = array(
      'kenteken' => $this->input->post('kenteken'),
      'nummer' => $this->input->post('autonummer'),
      'kmstand' => $this->input->post('kmstand'),
      'auto_type_id' => $this->input->post('type'),
      'toegevoegd_op' => date("Y-m-d H:i:s"),
      'toegevoegd_door' => $user,
    );
    $this->db->insert('autos', $data);
    $id = $this->db->insert_id(); 

    /* ROUTE */
    $route = $this->input->post('route');

    if($route !== '')
    {      
      $this->db->insert('auto_route', array('auto_id' => $id, 'route_id' => $route));
    }
  }

  public function delete_auto($id){
    $this->db->where('id', $id);
    $this->db->delete('autos');
  }

	public function get_autos($id = FALSE, $q = FALSE)
	{
		$this->db->select('
      autos.id, 
      autos.kenteken, 
      autos.nummer AS autonummer, 
      autos.kmstand, 
      autos.auto_type_id,
      autos.toegevoegd_op, 
      autos.toegevoegd_door,  
      auto_types.type, 
      auto_route.route_id,      
      routes.nummer AS routenummer'
    );
		$this->db->from('autos');
		$this->db->join('auto_types', 'auto_types.type_id = autos.auto_type_id', 'left outer');
    $this->db->join('auto_route', 'auto_route.auto_id = autos.id', 'left outer');
    $this->db->join('routes', 'auto_route.route_id = routes.id', 'left outer');
    if ($q !== FALSE)
    {
      $this->db->like('autos.nummer', $q);
    }
    $this->db->order_by('autonummer', 'asc');

		if ($id === FALSE)
		{
			$query = $this->db->get();
			return $query->result_array();
		}
		
		$this->db->where('autos.id', $id);
		$query = $this->db->get();
		return $query->row_array();
	}

  public function get_auto_type($autonummer)
  {
    $this->db->select('type');
    $this->db->from('autos');
    $this->db->join('auto_types', 'auto_types.type_id = autos.auto_type_id', 'left outer');
    $this->db->where('nummer', $autonummer);

    $query = $this->db->get();
    return $query->row_array();
  }

	public function set_auto($id)
	{
   
		/* AUTO */
    $data = array(
      'kenteken' => $this->input->post('kenteken'),
      'nummer' => $this->input->post('autonummer'),      
      'kmstand' => $this->input->post('kmstand'),
      'auto_type_id' => $this->input->post('type'),
    );
    $this->db->where('id', $id);
    $this->db->update('autos', $data); 

    /* ROUTE */
    $route = $this->input->post('route');

    $query = $this->db->get_where('auto_route', array('auto_id' => $id));
    $count= $query->num_rows();    

    if($route !== '')
    {
      if($count === 0)
      {
        $this->db->insert('auto_route', array('auto_id' => $id, 'route_id' => $route));
      }
      else
      {
        $this->db->update('auto_route', array('route_id' => $route), array('auto_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('auto_route', array('auto_id' => $id));
    }
	}
}