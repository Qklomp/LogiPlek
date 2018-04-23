<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandstof_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function add_dagrapporten()
  {  
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');

    foreach($this->input->post('dagrapport') as $d)
    {
      if( (!empty($d['datum'])) && (!empty($d['autonummer'])) && (!empty($d['chauffeur'])) && (($d['beginstand']) >= 0) )
      {
        if(empty($d['eindstand']))
        {
          $d['eindstand'] = $d['beginstand'];
        }
        $data = array(
          'datum' => mysql_date($d['datum']),
          'autonummer' => $d['autonummer'],
          'chauffeur' => $d['chauffeur'],
          'beginstand' => $d['beginstand'],
          'eindstand' => $d['eindstand'],
          'toegevoegd_op' => date("Y-m-d H:i:s"),
          'toegevoegd_door' => $user,
        );
        $this->db->insert('auto_dagrapport', $data);
        $id = $this->db->insert_id(); 

        if(!empty($d['eindstand']))
        {
           $this->db->update('autos', array('kmstand' => $d['eindstand']), array('nummer' => $d['autonummer']));
        }

        if( (!empty($d['liters'])) && (!empty($d['verbruik'])) )
        {
           $data = array(
            'dagrapport_id' => $id,
            'liters' => $d['liters'],
            'verbruik' => $d['verbruik'],
          );
          $this->db->insert('auto_dagrapport_verbruik', $data);
        }

        if( (!empty($d['koeling'])) )
        {
           $data = array(
            'dagrapport_id' => $id,
            'koeling' => $d['koeling'],
          );
          $this->db->insert('auto_dagrapport_koeling', $data);
        }

        if( (!empty($d['adblue'])) )
        {
           $data = array(
            'dagrapport_id' => $id,
            'adblue' => $d['adblue'],
          );
          $this->db->insert('auto_dagrapport_adblue', $data);
        }
      }
    }
  }

  public function delete_invoer($id){
    $this->db->select('autonummer');
    $this->db->from('auto_dagrapport');
    $this->db->where('id', $id);
    $result = $this->db->get()->row_array();

    $this->db->where('id', $id);
    $this->db->delete('auto_dagrapport');

    $this->db->select_max('id');
    $this->db->from('auto_dagrapport');
    $this->db->where('autonummer', $result['autonummer']);    
    $max = $this->db->get()->row_array();

    $this->db->select('*');
    $this->db->from('auto_dagrapport');
    $this->db->where('id', $max['id']);    
    $km = $this->db->get()->row_array();

    if(isset($km['eindstand']))
    {
      $this->db->update('autos', array('kmstand' => $km['eindstand']), array('nummer' => $result['autonummer']));
    }
    else
    {      
      $this->db->update('autos', array('kmstand' => $km['beginstand']), array('nummer' => $result['autonummer']));
    }
  }

  public function get_dagrapport($id = FALSE, $start = FALSE, $eind = FALSE, $autonummer = FALSE)
  {
    $this->db->select('*');
    $this->db->from('auto_dagrapport');
    $this->db->join('auto_dagrapport_adblue', 'auto_dagrapport_adblue.dagrapport_id = auto_dagrapport.id', 'left outer');
    $this->db->join('auto_dagrapport_koeling', 'auto_dagrapport_koeling.dagrapport_id = auto_dagrapport.id', 'left outer');
    $this->db->join('auto_dagrapport_verbruik', 'auto_dagrapport_verbruik.dagrapport_id = auto_dagrapport.id', 'left outer');
    $this->db->order_by('datum', 'desc');
    $this->db->order_by('toegevoegd_op', 'desc');

    if($start !== FALSE)
    {
      $this->db->where('datum >=', $start);
      $this->db->where('datum <=', $eind);
    }

    if ($autonummer !== FALSE)
    {
      $this->db->where('auto_dagrapport.autonummer', $autonummer);
    }
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('auto_dagrapport.id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function set_dagrapport($id)
  {
    $data = array(
      'datum' => mysql_date($this->input->post('datum')),
      'autonummer' => $this->input->post('autonummer'),
      'chauffeur' => $this->input->post('chauffeur'),
      'beginstand' => $this->input->post('beginstand'),
      'eindstand' => $this->input->post('eindstand'),
    );
    $this->db->where('id', $id);
    $this->db->update('auto_dagrapport', $data);  

    if(!empty($d['eindstand']))
    {
       $this->db->update('autos', array('kmstand' => $d['eindstand']), array('nummer' => $d['autonummer']));
    }

    /* VERBRUIK */
    $liters = $this->input->post('liters');
    $verbruik = $this->input->post('verbruik');

    $query = $this->db->get_where('auto_dagrapport_verbruik', array('dagrapport_id' => $id));
    $count= $query->num_rows();    

    if( (!empty($liters)) && (!empty($verbruik) ) )
    {
      if($count === 0)
      {       
        $data = array(
          'dagrapport_id' => $id,
          'liters' => $liters,
          'verbruik' => $verbruik,
        );
        $this->db->insert('auto_dagrapport_verbruik', $data);
      }
      else
      {
        $this->db->update('auto_dagrapport_verbruik', array('liters' => $liters, 'verbruik' => $verbruik), array('dagrapport_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('auto_dagrapport_verbruik', array('dagrapport_id' => $id));
    }

    /* KOELING */
    $koeling = $this->input->post('koeling');

    $query = $this->db->get_where('auto_dagrapport_koeling', array('dagrapport_id' => $id));
    $count= $query->num_rows();    

    if( (!empty($koeling)) )
    {
      if($count === 0)
      {           
        $this->db->insert('auto_dagrapport_koeling', array('dagrapport_id' => $id, 'koeling' => $koeling));
      }
      else
      {
        $this->db->update('auto_dagrapport_koeling', array('koeling' => $koeling), array('dagrapport_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('auto_dagrapport_koeling', array('dagrapport_id' => $id));
    }

    /* ADBLUE */
    $adblue = $this->input->post('adblue');

    $query = $this->db->get_where('auto_dagrapport_adblue', array('dagrapport_id' => $id));
    $count= $query->num_rows();    

    if( (!empty($adblue)) )
    {
      if($count === 0)
      {           
        $this->db->insert('auto_dagrapport_adblue', array('dagrapport_id' => $id, 'adblue' => $adblue));
      }
      else
      {
        $this->db->update('auto_dagrapport_adblue', array('adblue' => $adblue), array('dagrapport_id' => $id));
      }
    }
    else if($count === 1)
    {
      $this->db->delete('auto_dagrapport_adblue', array('dagrapport_id' => $id));
    }
   
  }
}