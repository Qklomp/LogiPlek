<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ritregistratie_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function add_rit($type)
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');

    $datum = mysql_date($this->input->post('datum'));

    /* RIT */
    $data = array(
      'datum' => $datum,
      'vervoerder' => $this->input->post('vervoerder'),
      'afstand' => $this->input->post('afstand'),
      'kosten' => str_replace(',', '.', $this->input->post('kosten')),
      'user' => $this->input->post('user'),
      'omschrijving' => $this->input->post('omschrijving'),
      'reden' => $this->input->post('reden'),
      'locatie' => $this->input->post('locatie'),
      'toegevoegd_op' => date("Y-m-d H:i:s"),
      'toegevoegd_door' => $user,
    );

    if ($type === 'intern')
    {
      $data['route'] = $this->input->post('route');
    }

    $this->db->insert('ritregistratie_' . $type, $data); 
    $id = $this->db->insert_id();

    if( $type === 'extern' )
    { 
      /* FACTUURNUMMER */
      $factuurnummer = $this->input->post('factuurnummer');   

      if($factuurnummer !== ''){     
        $this->db->insert('ritregistratie_factuurnummer', array('rit_id' => $id, 'factuurnummer' => $factuurnummer));
      }
    }

    $participanten = $this->input->post('participanten');
    for ($i = 0; $i < count($participanten['id']); $i++)
    {
      $p_id = $participanten['id'][$i];
      $stops = $participanten['stops'][$i];
      if ($stops > 0)
      {
        $this->db->insert('ritregistratie_'.$type.'_participanten', array('rit_id' => $id, 'participant_id' => $p_id, 'stops' => $stops));
      }
    }
  }

  public function add_ritten()
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');
    
    foreach($this->input->post('rit') as $rit)
    {
      if( !empty($rit['datum']) && !empty($rit['route']) && !empty($rit['ophaalpunt']) && !empty($rit['participant']) )
      {
        $data = array(
          'datum' => mysql_date($rit['datum']),
          'vervoerder' => 'Distrivers Divers',
          'afstand' => '1',
          'kosten' => str_replace(',', '.', $rit['kosten']),
          'user' => $user,
          'route' => $rit['route'],
          'omschrijving' => 'Ophaalorder ' . $rit['ophaalpunt'],
          'reden' => 'Ophaalorder',
          'locatie' => 'Hoogeveen',
          'toegevoegd_op' => date("Y-m-d H:i:s"),
          'toegevoegd_door' => $user,
        );

        $this->db->insert('ritregistratie_intern', $data); 
        $id = $this->db->insert_id();

        $this->db->insert('ritregistratie_intern_participanten', array('rit_id' => $id, 'participant_id' => $rit['participant'], 'stops' => 1));
      }
    }
  }

  public function add_standaard_rit()
  {
    $extern = $this->input->post('extern');
    $intern = $this->input->post('intern');
    if( (isset($extern)) && ($extern !== '') )
    {
      $type = 'extern';
      $vervoerder = $this->input->post('extern');
    }

    if( (isset($intern)) && ($intern !== '') )
    {
      $type = 'intern';
      $vervoerder = $this->input->post('intern');
    }

    /* STANDAARD RIT */
    $data = array(
      'participant_id' => $this->input->post('participant'),
      'omschrijving' => $this->input->post('omschrijving'),
      'kosten' => $this->input->post('kosten'),
      'type' => $type,
      'vervoerder' => $vervoerder,
    );
    $this->db->insert('ritregistratie_standaardritten', $data); 
  }

  public function delete_rit($type, $id)
  {
    $this->db->where('id', $id);
    $this->db->delete('ritregistratie_' . $type);
  }

  public function delete_standaard_rit($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('ritregistratie_standaardritten');
  }  

  public function get_factuur($factuurnummer)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_factuurnummer'); 
    $this->db->where('factuurnummer', $factuurnummer);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_kosten($type, $locatie, $start, $eind)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_' . $type);  
    if ($locatie !== '')
    {   
      $this->db->where('locatie', $locatie);
    }
    $this->db->where('datum >=', $start);
    $this->db->where('datum <=', $eind);
    $this->db->order_by('datum', 'desc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit($type, $id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_' . $type);   
    $this->db->join('ritregistratie_factuurnummer', 'ritregistratie_' . $type . '.id = ritregistratie_factuurnummer.rit_id', 'left outer'); 
    $this->db->order_by('id', 'desc'); 

    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_factuur_overzicht($factuurnummer)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_extern');   
    $this->db->join('ritregistratie_factuurnummer', 'ritregistratie_extern.id = ritregistratie_factuurnummer.rit_id', 'left outer'); 

    $this->db->where('factuurnummer', $factuurnummer);
    $this->db->order_by('id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_factuur_totalen($factuurnummer)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_extern_participanten');  
    $this->db->join('ritregistratie_extern', 'ritregistratie_extern_participanten.rit_id = ritregistratie_extern.id', 'left outer');    
    $this->db->join('ritregistratie_factuurnummer', 'ritregistratie_extern.id = ritregistratie_factuurnummer.rit_id', 'left outer');
    $this->db->where('factuurnummer', $factuurnummer);
    $this->db->order_by('id', 'desc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit_overzicht($vervoerder, $van, $tot)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_extern');
    $this->db->where('datum >=', $van);
    $this->db->where('datum <=', $tot);    
    $this->db->where('vervoerder', $vervoerder);
    $this->db->order_by('id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit_overzicht_omschrijving($omschrijving, $van, $tot, $type="extern")
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_' . $type);
    $this->db->where('datum >=', $van);
    $this->db->where('datum <=', $tot);    
    $this->db->like('omschrijving', $omschrijving);
    $this->db->order_by('id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit_overzicht_routes($route, $van, $tot)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_intern');
    $this->db->where('datum >=', $van);
    $this->db->where('datum <=', $tot);    
    $this->db->where('route', $route);
    $this->db->order_by('id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit_overzicht_participant($participant, $van, $tot, $type="extern")
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_' . $type);
    $this->db->join('ritregistratie_' . $type . '_participanten', 'ritregistratie_' . $type . '_participanten.rit_id = ritregistratie_' . $type . '.id', 'left outer');    
    $this->db->where('datum >=', $van);
    $this->db->where('datum <=', $tot);    
    $this->db->where('participant_id', $participant);
    $this->db->order_by('id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_rit_participanten($type, $id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_'.$type.'_participanten');        
    
    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('rit_id', $id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_standaard_rit($id = FALSE)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_standaardritten'); 

    if ($id === FALSE)
    {
      $query = $this->db->get();
      return $query->result_array();
    }
    
    $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_stops($type, $id)
  {
    $this->db->select('SUM(stops) as stops');
    $this->db->from('ritregistratie_' . $type . '_participanten');
    $this->db->where('rit_id', $id);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_totalen($type, $locatie, $start, $eind, $vervoerder = FALSE)
  {
    $this->db->select('*');
    $this->db->from('ritregistratie_' . $type . '_participanten');  
    $this->db->join('ritregistratie_' . $type, 'ritregistratie_' . $type . '_participanten.rit_id = ritregistratie_' . $type . '.id', 'left outer');
    $this->db->where('datum >=', $start);
    $this->db->where('datum <=', $eind);
    if ($vervoerder !== FALSE)
    {      
      $this->db->where('vervoerder', $vervoerder);
    }
    if ($locatie !== '')
    {      
      $this->db->where('locatie', $locatie);
    }
    $this->db->order_by('id', 'desc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function set_rit($type, $id)
  {
    list($d,$m,$y) = explode('-',$this->input->post('datum')); 
    $datum = "$y-$m-$d";

    /* RIT */
    $data = array(
      'datum' => $datum,
      'vervoerder' => $this->input->post('vervoerder'),
      'afstand' => $this->input->post('afstand'),
      'kosten' => $this->input->post('kosten'),
      'user' => $this->input->post('user'),
      'omschrijving' => $this->input->post('omschrijving'),
      'reden' => $this->input->post('reden'),
      'locatie' => $this->input->post('locatie'),
    );

    if ($type === 'intern')
    {
      $data['route'] = $this->input->post('route');
    }

    $this->db->where('id', $id);
    $this->db->update('ritregistratie_' . $type, $data); 

    if( $type === 'extern' )
    { 
      /* FACTUURNUMMER */
      $factuurnummer = $this->input->post('factuurnummer');   

      $query = $this->db->get_where('ritregistratie_factuurnummer', array('rit_id' => $id));
      $count = $query->num_rows();    

      if($factuurnummer !== '')
      {
        if($count === 0)
        {
          $this->db->insert('ritregistratie_factuurnummer', array('rit_id' => $id, 'factuurnummer' => $factuurnummer));
        }
        else
        {
          $this->db->update('ritregistratie_factuurnummer', array('factuurnummer' => $factuurnummer), array('rit_id' => $id));
        }
      }
      else if($count === 1)
      {
        $this->db->delete('ritregistratie_factuurnummer', array('rit_id' => $id));
      }
    }

    /* PARTICIPANTEN */
    $this->db->delete('ritregistratie_'.$type.'_participanten', array('rit_id' => $id));

    $participanten = $this->input->post('participanten');
    for ($i = 0; $i < count($participanten['id']); $i++)
    {
      $p_id = $participanten['id'][$i];
      $stops = $participanten['stops'][$i];
      if ($stops > 0)
      {
        $this->db->insert('ritregistratie_'.$type.'_participanten', array('rit_id' => $id, 'participant_id' => $p_id, 'stops' => $stops));
      }
    }
  }

  public function set_standaard_rit($jaar, $week)
  {
    $user = $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam');

    $d = $jaar . "W" . $week;  

    foreach ($this->input->post('sr') as $r)
    {
      $id = $r['id'];
      $data = $this->get_standaard_rit($id);
      $days = array();
      if(isset($r['ma']))
      {
        $days[] = date("Y-m-d", strtotime($d . '1'));
      }
      if(isset($r['di']))
      {
        $days[] = date("Y-m-d", strtotime($d . '2'));
      }
      if(isset($r['wo']))
      {
        $days[] = date("Y-m-d", strtotime($d . '3'));
      }
      if(isset($r['do']))
      {
        $days[] = date("Y-m-d", strtotime($d . '4'));
      }
      if(isset($r['vr']))
      {
        $days[] = date("Y-m-d", strtotime($d . '5'));
      }
      if(isset($r['za']))
      {
        $days[] = date("Y-m-d", strtotime($d . '6'));
      }
      if(isset($r['zo']))
      {
        $days[] = date("Y-m-d", strtotime($d . '7'));
      }

      foreach ($days as $day)
      {
        $ins = array(
          'datum' => $day,
          'vervoerder' => $data['vervoerder'],
          'afstand' => '1',
          'kosten' => $data['kosten'],
          'user' => $user,
          'omschrijving' => $data['omschrijving'],
          'reden' => '',
          'locatie' => 'Hoogeveen',
          'toegevoegd_op' => date("Y-m-d H:i:s"),
          'toegevoegd_door' => $user,
        );
        $this->db->insert('ritregistratie_' . $data['type'] , $ins); 
        $rit_id = $this->db->insert_id();

        $this->db->insert('ritregistratie_'. $data['type'] .'_participanten', array('rit_id' => $rit_id, 'participant_id' => $data['participant_id'], 'stops' => '1'));
      }
    }
  }

  public function vorige_rit($type, $id)
  {
    $this->db->select_max('id');
    $this->db->from('ritregistratie_' . $type);
    $this->db->order_by('id', 'asc');    
    $this->db->where('id <', $id);
    $this->db->limit('1');

    $query = $this->db->get();
    return $query->row_array();
  }

  public function volgende_rit($type, $id)
  {
    $this->db->select_min('id');
    $this->db->from('ritregistratie_' . $type);
    $this->db->order_by('id', 'asc');    
    $this->db->where('id >', $id);
    $this->db->limit('1');

    $query = $this->db->get();
    return $query->row_array();
  }
}