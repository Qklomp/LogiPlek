<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CMS_model extends CI_Model {

  /* ========== ASSORTIMENT ========== */
  public function delete_assortiment($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('steunpunt_assortimenten');
  }

  public function get_assortimenten()
  {
    $this->db->select('*');
    $this->db->from('steunpunt_assortimenten'); 
    $this->db->order_by('type', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_assortiment()
  {
    $a = $this->input->post('assortiment');
    for ($i = 0; $i < count($a['type']); $i++)
    {
      if(isset($a['id'][$i]))
      {
        if($a['type'][$i] !== '')
        {
          $this->db->update('steunpunt_assortimenten', array('type' => ucfirst($a['type'][$i])), array('id' => $a['id'][$i]));
        }
        else 
        {
          $this->db->where('id', $a['id'][$i]);
          $this->db->delete('steunpunt_assortimenten');
        }
      }
  
      else if($a['type'][$i] !== '')
      {
        $this->db->insert('steunpunt_assortimenten', array('type' => ucfirst($a['type'][$i])));
      }
    }
  }

  /* ========== AUTO TYPES ========== */
  public function get_auto_types()
  {
    $this->db->select('*');
    $this->db->from('auto_types'); 
    $this->db->order_by('type', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  /* ========== FUNCTIES ========== */
  public function get_functies()
  {
    $this->db->select('*');
    $this->db->from('personeel_functies'); 
    $this->db->order_by('functie', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  /* ========== LOCATIES ========== */
  public function get_locaties()
  {
    $this->db->select('*');
    $this->db->from('cms_locaties'); 
    $this->db->order_by('locatie', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  /* ========== PARTICIPANTEN ========== */
  public function delete_participant($id)
  {
    $this->db->update('ritregistratie_participanten', array(
	'active' => 0,
    ), array(
	'id' => $id
    ));
  }

  public function get_participanten()
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_participanten');
    $this->db->order_by('participant', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_redenen()
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_redenen'); 
    $this->db->order_by('reden', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_route_types()
  {
    $this->db->select('*');
    $this->db->from('route_types'); 
    $this->db->order_by('type', 'asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_participanten()
  {
    $a = $this->input->post('participant');
    for ($i = 0; $i < count($a['type']); $i++)
    {
      if(isset($a['id'][$i]))
      {
        if($a['type'][$i] !== '')
        {
          $this->db->update('ritregistratie_participanten', array('participant' => ucfirst($a['type'][$i])), array('id' => $a['id'][$i]));
        }
        else 
        {
          $this->db->where('id', $a['id'][$i]);
          $this->db->delete('ritregistratie_participanten');
        }
      }
  
      else if($a['type'][$i] !== '')
      {
        $this->db->insert('ritregistratie_participanten', array('participant' => ucfirst($a['type'][$i])));
      }
    }
  }

  /* ========== PARTICIPANTEN ========== */
  public function delete_ophaalpunt($id)
  {
    $this->db->update('ritregistratie_ophaalpunten', array(
    'active' => 0,
      ), array(
    'id' => $id
    ));
  }

  public function get_ophaalpunten($id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_ophaalpunten');
    $this->db->order_by('ophaalpunt', 'asc');

    if ($id !== FALSE) 
    {
      $this->db->where('id', $id);
      $query = $this->db->get();
      return $query->row_array();
    }
    else
    {
      $query = $this->db->get();
      return $query->result_array();
    }
  }

  public function set_ophaalpunten()
  {
    $a = $this->input->post('ophaalpunt');
    for ($i = 0; $i < count($a['type']); $i++)
    {
      if(isset($a['id'][$i]))
      {
        if($a['type'][$i] !== '')
        {
          $this->db->update('ritregistratie_ophaalpunten', array('ophaalpunt' => ucfirst($a['type'][$i]), 'prijs' => $a['prijs'][$i]), array('id' => $a['id'][$i]));
        }
        else 
        {
          $this->db->where('id', $a['id'][$i]);
          $this->db->delete('ritregistratie_ophaalpunten');
        }
      }
  
      else if($a['type'][$i] !== '')
      {
        $this->db->insert('ritregistratie_ophaalpunten', array('ophaalpunt' => ucfirst($a['type'][$i]), 'prijs' => $a['prijs'][$i]));
      }
    }
  }
}
