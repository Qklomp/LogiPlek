<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ritregistratie extends MY_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model('cms_model');
    $this->load->model('koeriers_model');
    $this->load->model('personeel_model');
    $this->load->model('routes_model');
    $this->load->model('steunpunten_model');  
    $this->load->model('ritregistratie_model');
    $this->load->model('user_model');
  }

  public function index()
  {
    $data = $this->user_data();
    // $data['extern'] = $this->ritregistratie_model->get_rit('extern');      
    // $data['intern'] = $this->ritregistratie_model->get_rit('intern');
    $data['koeriers'] = $this->koeriers_model->get_koeriers();
    $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
    $data['vervoerder'] = array_merge($data['koeriers'], $data['steunpunten']);

    $data['last_week'] = date("Wy", strtotime("-1 week +1 day"));
    

    foreach ($data['vervoerder'] as $e) 
    {
        $naam[] = $e['naam'];
    }
    array_multisort($naam, SORT_ASC, $data['vervoerder']);

    $data['locaties'] = $this->cms_model->get_locaties();
    $data['participanten'] = $this->cms_model->get_participanten();
    $data['routes'] = $this->routes_model->get_routes();

    /* MESSAGES */
    if (($this->session->flashdata('toegevoegd')))
    {
      $data['toegevoegd'] = true;
    }
    if (($this->session->flashdata('aangepast')))
    {
      $data['aangepast'] = true;
    }
    if (($this->session->flashdata('verwijderd')))
    {
      $data['verwijderd'] = true;
    }
    if (($this->session->flashdata('niet_gevonden')))
    {
      $data['niet_gevonden'] = true;
    }

    $data['js'] = array(
      'DataTable/media/js/jquery.dataTables.min',
      'logiplek/datatables',
      'logiplek/ritregistratie/index',
      'parsley.min',
      'bootstrap-datepicker.min',
      'jquery.maskedinput.min',
      'logiplek/forms',
    );
    $data['title'] = 'Ritregistratie';
    $data['root'] = 'Ritregistratie';
    $data['main_content'] = 'admin/ritregistratie/index';

    $this->load->view('admin/includes/template', $data);
  }

  public function bekijken($type, $id)
  {
    $this->load->library('form_validation'); 
    $this->form_validation->set_rules('datum', 'Datum', 'trim|required');      
    $this->form_validation->set_rules('vervoerder', 'Vervoerder', 'trim|required');
    $this->form_validation->set_rules('afstand', 'Afstand', 'trim|required');
    $this->form_validation->set_rules('omschrijving', 'Omschrijving', 'trim|required');
    if($type === 'extern')
    {
      $this->form_validation->set_rules('reden', 'Reden', 'trim|required');     
    } 
    $this->form_validation->set_rules('participanten[]', 'Participanten', 'callback_check_participanten');

    if ($this->form_validation->run() === FALSE)
    {

      $data = $this->user_data();

      $data['rit'] = $this->ritregistratie_model->get_rit($type, $id);
      if (empty($data['rit']))
      {
        $this->session->set_flashdata('niet_gevonden', true);
        redirect('/ritregistratie/', 'refresh');
      }

      if( $type === 'extern' )
      {
        $data['koeriers'] = $this->koeriers_model->get_koeriers();
        $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
        $data['vervoerder'] = array_merge($data['koeriers'], $data['steunpunten']);
        foreach( $data['vervoerder'] as $e ) 
        {
            $naam[] = $e['naam'];
        }
        array_multisort($naam, SORT_ASC, $data['vervoerder']);
      }

      else 
      {
        $data['vervoerder'] = array();
        $data['personeel'] = $this->personeel_model->get_personeel();
        $data['routes'] = $this->routes_model->get_routes();
        foreach( $data['personeel'] as $e ) 
        {
          $data['vervoerder'][$e['id']]['naam'] = $e['voornaam'] . ' ' . $e['achternaam'];
          $data['vervoerder'][$e['id']]['id'] = $e['id'];
        }
      }

      $data['rit']['datum'] = nl_date($data['rit']['datum']);
      $data['rit_participanten'] = $this->get_participanten_array($this->ritregistratie_model->get_rit_participanten($type, $id));
      $data['vorige'] = $this->ritregistratie_model->vorige_rit($type, $id);
      $data['volgende'] = $this->ritregistratie_model->volgende_rit($type, $id);
      $data['locaties'] = $this->cms_model->get_locaties();
      $data['participanten'] = $this->cms_model->get_participanten();
      $data['redenen'] = array();
      foreach($this->cms_model->get_redenen() as $r)
      {
        $data['redenen'][] = $r['reden'];
      }
      $data['users'] = $this->personeel_model->get_personeel();
      $data['type'] = $type;
      $data['id'] = $id;
      $data['js'] = array(
        'logiplek/ritregistratie/toevoegen',
        'parsley.min',
        'bootstrap-datepicker.min',
        'logiplek/forms',
      );
      $data['title'] = 'Referentienummer ' . $id;
      $data['root'] = 'Ritregistratie';
      $data['main_content'] = 'admin/ritregistratie/bekijken';
      $this->load->view('admin/includes/template', $data);
    }
    else
    { 
      $this->ritregistratie_model->set_rit($type, $id);      
      $this->session->set_flashdata('aangepast', true);
      redirect('/ritregistratie/', 'refresh');
    }
  }

  public function check_participanten()
  {
    $participanten = $this->input->post('participanten');
    if (array_sum($participanten['stops']) == 0)
    {
      $this->form_validation->set_message('check_participanten', 'Geef minstens één participant op'); 
      return false;
    }
    return true;
  }

  public function fo()
  {
    $factuur = $this->input->post('factuurnummer');
    redirect('/ritregistratie/extern/factuuroverzicht/' . $factuur, 'refresh');
  }

  public function factuuroverzicht($factuurnummer)
  {
    $ritten = $this->ritregistratie_model->get_factuur_overzicht($factuurnummer);
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $title = 'Kosten factuur ' . $factuurnummer;    
    $pdf = $this->pdf_overzicht($title, $ritten, 'extern');
  }

  public function get_participanten_array($a)
  {
    $p = array();
    foreach ($a as $row)
    {
      $p[$row['rit_id']][$row['participant_id']] = $row['stops'];
    }
    return $p;
  }

  public function json($type)
  {
    $ritten = array();
    foreach($this->ritregistratie_model->get_rit($type) as $d)
    {
      $a = array(
        'id' => $d['id'],
        'datum' => nl_date($d['datum']),
        'vervoerder' => $d['vervoerder'],
      ); 
      $ritten[] = $a;
    }
    print json_encode($ritten);
  }

  public function koeriersoverzicht()
  {
    $vervoerder = $this->input->post('firmanaam');
    $van = $this->input->post('datum_van');
    $tot = $this->input->post('datum_tot');

    $ritten = $this->ritregistratie_model->get_rit_overzicht($vervoerder, mysql_date($van), mysql_date($tot));
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $title = $vervoerder . ', ' . $van . ' t/m ' . $tot;    
    $pdf = $this->pdf_overzicht($title, $ritten, 'extern');    
  }  

  public function omschrijvingsoverzicht($type)
  {
    $omschrijving = $this->input->post('omschrijving');
    $van = $this->input->post('datum_van');
    $tot = $this->input->post('datum_tot');

    $ritten = $this->ritregistratie_model->get_rit_overzicht_omschrijving($omschrijving, mysql_date($van), mysql_date($tot), $type);
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $title = 'Zoekterm: \'' . $omschrijving . '\', ' . $van . ' t/m ' . $tot;    
    $pdf = $this->pdf_overzicht($title, $ritten, 'extern');    
  }  

  public function routesoverzicht()
  {
    $route = $this->input->post('route');
    $van = $this->input->post('datum_van');
    $tot = $this->input->post('datum_tot');

    $ritten = $this->ritregistratie_model->get_rit_overzicht_routes($route, mysql_date($van), mysql_date($tot));
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $title = 'Route ' . $route . ', ' . $van . ' t/m ' . $tot;    
    $pdf = $this->pdf_overzicht($title, $ritten, 'intern');    
  }  

  public function participantoverzicht($type)
  {
    $participant = $this->input->post('participant');
    $van = $this->input->post('datum_van');
    $tot = $this->input->post('datum_tot');

    $ritten = $this->ritregistratie_model->get_rit_overzicht_participant($participant, mysql_date($van), mysql_date($tot), $type);
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    foreach($this->cms_model->get_participanten() as $p) {
      if($p['id'] === $participant) {
        $pname = $p['participant'];
      }
    }

    $title = ucfirst($type) . 'e ritten ' . $pname . ', ' . $van . ' t/m ' . $tot;    
    $pdf = $this->pdf_overzicht($title, $ritten, $type);    
  }  

  public function printen($type, $id)
  {
    $rit = $this->ritregistratie_model->get_rit($type, $id);
    if (empty($rit))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $this->load->helper('print');
    $pdf = ritbon($rit);

    $totalen = array();
    $totaal = 0;
    $kosten = $this->ritregistratie_model->get_rit_participanten($type, $rit['id']);
    foreach ($kosten as $k)
    {
      $stops = $this->ritregistratie_model->get_stops($type, $k['rit_id']);
      if( empty($rit['kosten']) || ($rit['kosten'] === '0,00'))
      {
        $kostenkm = 1.00;
      }
      else
      {
        $kostenkm = str_replace(',', '.', $rit['kosten']);
      }
      if(empty($rit['afstand']) || ($rit['afstand'] === '0,00') )
      {
        $afstand = 1.00;
      }
      else
      {
        $afstand = str_replace(',', '.', $rit['afstand']);
      }
      $ks = (($kostenkm * $afstand) / $stops['stops']) * $k['stops'];
      $totaal += $ks;
      if (!empty($totalen[$k['participant_id']]))
      {
        $totalen[$k['participant_id']] += $ks;
      }
      else
      {
        $totalen[$k['participant_id']] = $ks;
      }
    }

    $participanten = $this->cms_model->get_participanten();
    $pdf = print_totalen($pdf, $totalen, $totaal, $participanten);
    $pdf->Output('distrivers_ritbon_' . $id . '_.pdf', 'I');
  }

  private function pdf_overzicht($title, $ritten, $type)
  {
    $this->load->helper('print');
    $pdf = pdf_init($title);

    $columns = array('datum', 'id', 'vervoerder', 'afstand', 'kosten', 'omschrijving', 'reden', 'ingevoerd door');

    $participanten = $this->cms_model->get_participanten();

    $totalen = array();
    $totaal = 0;

    foreach ($ritten as $rit)    {
      $pdf = print_overzicht($pdf, $rit, $columns);

      $rittotalen = array();
      $rittotaal = 0;
      $kosten = $this->ritregistratie_model->get_rit_participanten($type, $rit['id']);
      foreach ($kosten as $k)
      {
        $stops = $this->ritregistratie_model->get_stops($type, $k['rit_id']);
        $kostenkm = 1.00;
        $afstand = 1.00;
        if( !empty($rit['kosten']) && ($rit['kosten'] !== '0,00') )
        {  
          $kostenkm = str_replace(',', '.', $rit['kosten']);
        }
        if( !empty($rit['afstand']) && ($rit['afstand'] !== '0,00') )
        {
          $afstand = str_replace(',', '.', $rit['afstand']);
        }

        $ks = (($kostenkm * $afstand) / $stops['stops']) * $k['stops'];

        $rittotaal += $ks;
        $totaal += $ks;

        if (!empty($rittotalen[$k['participant_id']]))
        {
          $rittotalen[$k['participant_id']] += $ks;
        }
        else
        {
          $rittotalen[$k['participant_id']] = $ks;
        }

        if (!empty($totalen[$k['participant_id']]))
        {
          $totalen[$k['participant_id']] += $ks;
        }
        else
        {
          $totalen[$k['participant_id']] = $ks;
        }
      }
      $pdf = print_rit_totalen($pdf, $rittotalen, $rittotaal, $participanten);    
    }
    $pdf = print_totalen($pdf, $totalen, $totaal, $participanten);
    $pdf->Output(str_replace(' ','_',$title) . '.pdf', 'I');
  }

  public function statistieken()
  {
    $data = $this->user_data();

    $data['js'] = array(
      'logiplek/ritregistratie/Chart.min',
      'logiplek/ritregistratie/statistieken',
    );
    $data['title'] = 'Statistieken';
    $data['root'] = 'Ritregistratie';
    $data['main_content'] = 'admin/ritregistratie/statistieken';

    $this->load->view('admin/includes/template', $data);
  }

  public function get_statistics() 
  {
    $type = 'extern';

    $startDate = strtotime('2016-12-30');
    $endDate = strtotime(date('Y-m-d'));

    $currDate  = $startDate;
    $weekArray = array();

    do {
      $week = array(
        'start' => date( 'Y-m-d' , $currDate ),
        'end' => date( 'Y-m-d', strtotime( '+6 days' , $currDate )),
      );
      $weekArray[date('o - \W\e\e\k W', $currDate)] = $week;
      $currDate = strtotime( '+7 days' , $currDate );
    } while( $currDate<=$endDate );

    
    $chartData = array(
      'labels' => array(),
      'totals' => array(),
    );

    foreach($weekArray as $weekNummer => $week) {
      $weekTotaal = 0;
      foreach ($this->ritregistratie_model->get_kosten($type, '', $week['start'], $week['end']) as $rit)    {
        $kostenkm = ( !empty($rit['kosten']) && ($rit['kosten'] !== '0,00') ) ? str_replace(',', '.', $rit['kosten']) : 1.00;
        $afstand = ( !empty($rit['afstand']) && ($rit['afstand'] !== '0,00') ) ? str_replace(',', '.', $rit['afstand']) : 1.00;
        $weekTotaal += ($kostenkm * $afstand);    
        
      } /* END FOREACH RIT */
      array_push($chartData['labels'], $weekNummer);
      array_push($chartData['totals'], number_format((float)($weekTotaal),2,'.',''));      
    } /* END FOREACH WEEKARRAY */
    print(json_encode($chartData));
  }

  public function toevoegen($type)
  {
    $this->load->library('form_validation'); 
    $this->form_validation->set_rules('datum', 'Datum', 'trim|required');      
    $this->form_validation->set_rules('vervoerder', 'Vervoerder', 'trim|required');
    $this->form_validation->set_rules('afstand', 'Afstand', 'trim|required');
    $this->form_validation->set_rules('omschrijving', 'Omschrijving', 'trim|required');
    if($type === 'extern')
    {
      $this->form_validation->set_rules('reden', 'Reden', 'trim|required');     
    } 
    $this->form_validation->set_rules('locatie', 'Locatie', 'trim|required');
    $this->form_validation->set_rules('participanten_check', 'Participanten', 'callback_check_participanten');

    # SET VALUE RULES      
    $this->form_validation->set_rules('kosten', 'Kosten per kilometer', '');
    $this->form_validation->set_rules('factuurnummer', 'Factuurnummer', '');     

    if ($this->form_validation->run() === FALSE)
    {

      $data = $this->user_data();
      if( $type === 'extern' )
      {
        $data['koeriers'] = $this->koeriers_model->get_koeriers();
        $data['steunpunten'] = $this->steunpunten_model->get_steunpunten();
        $data['vervoerder'] = array_merge($data['koeriers'], $data['steunpunten']);
        foreach( $data['vervoerder'] as $e ) 
        {
            $naam[] = $e['naam'];
        }
        array_multisort($naam, SORT_ASC, $data['vervoerder']);
      }

      else 
      {
        $data['vervoerder'] = array();
        $data['routes'] = $this->routes_model->get_routes();
        foreach( $data['personeel'] as $e ) 
        {
          $data['vervoerder'][$e['id']]['naam'] = $e['voornaam'] . ' ' . $e['achternaam'];
          $data['vervoerder'][$e['id']]['id'] = $e['id'];
        }
      }


      $data['personeel'] = $this->personeel_model->get_personeel();
      $data['locaties'] = $this->cms_model->get_locaties();
      $data['participanten'] = $this->cms_model->get_participanten();
      $data['redenen'] = $this->cms_model->get_redenen();
      $data['type'] = $type;
      $data['js'] = array(
        'logiplek/ritregistratie/toevoegen',
        'parsley.min',
        'bootstrap-datepicker.min',
        'logiplek/forms',
      );
      $data['title'] = 'Rit toevoegen';
      $data['root'] = 'Ritregistratie';
      $data['main_content'] = 'admin/ritregistratie/toevoegen';
      $this->load->view('admin/includes/template', $data);
    }
    else
    { 
      $this->ritregistratie_model->add_rit($type);      
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/ritregistratie/', 'refresh');
    }
  }

  public function sneltoevoegen()
  {
    $this->load->library('form_validation');

    $rit = $this->input->post('rit');
    if(!empty($rit))
    {
      foreach($rit as $d => $data)
      {
        $this->form_validation->set_rules('rit[' . $d . '][datum]', 'Datum', 'trim');
        $this->form_validation->set_rules('rit[' . $d . '][route]', 'Route', 'trim');
        $this->form_validation->set_rules('rit[' . $d . '][ophaalpunt]', 'Ophaalpunt', 'trim');
        $this->form_validation->set_rules('rit[' . $d . '][participant]', 'Participant', 'trim');
        $this->form_validation->set_rules('rit[' . $d . '][kosten]', 'Kosten', 'trim');
      }
    } 
    if ($this->form_validation->run() === false)
    {
      $data = $this->user_data();
      $data['js'] = array(
        'DataTable/media/js/jquery.dataTables.min',
        'DataTable/extensions/KeyTable/js/dataTables.keyTable.min',
        'parsley.min',
        'bootstrap-datepicker.min',
        'logiplek/forms',
        'logiplek/brandstof/toevoegen',
      );
      $data['ophaalpunten'] = $this->cms_model->get_ophaalpunten();
      $data['participanten'] = $this->cms_model->get_participanten();
      $data['routes'] = $this->routes_model->get_routes();
      $data['title'] = 'Interne ritten toevoegen';      
      $data['root'] = 'Ritregistratie';
      $data['main_content'] = 'admin/ritregistratie/sneltoevoegen';

      $this->load->view('admin/includes/template', $data);
    }
    else
    {
      $this->ritregistratie_model->add_ritten();
      $this->session->set_flashdata('toegevoegd', true);
      redirect('/ritregistratie/', 'refresh');
    }
  }

  public function verwijderen($type, $id)
  {
    $this->ritregistratie_model->delete_rit($type, $id);
    $this->session->set_flashdata('verwijderd', true);
    redirect('/ritregistratie/', 'refresh');
  }

  public function zoek($type)
  {
    if ($type === 'factuur')
    {
      $rit = $this->ritregistratie_model->get_factuur($this->input->post('factuurnummer'));
      if (empty($rit))
      {
        $this->session->set_flashdata('niet_gevonden', true);
        redirect('/ritregistratie/', 'refresh');
      }
      else
      {
        redirect('/ritregistratie/extern/' . $rit['rit_id']);
      }
    }
    redirect('/ritregistratie/' . $type . '/' .$this->input->post('referentienummer'));
  }

  public function wo($type)
  {
    $locatie = $this->input->post('locatie');
    $wj = $this->input->post('weeknummer');
    redirect('/ritregistratie/weekoverzicht/' . $type . '/'. $locatie . '/' . $wj, 'refresh');
  }


  public function weekoverzicht($type, $locatie, $wj)
  {
    $j = '20' . substr($wj, 2, 3);
    $w = substr($wj, 0, 2);

    $dto = new DateTime();
    $start = $dto->setISODate($j, $w)->format('Y-m-d');
    $eind = $dto->modify('+6 days')->format('Y-m-d');

    if ($locatie === 'Alles')
    {
      $locatie = '';
      $title = ucfirst($type) . 'e kosten, week ' . $w . ' ' . $j;
    }
    else
    {
      $title = ucfirst($type) . 'e kosten ' . $locatie . ', week ' . $w . ' ' . $j;
    }

    $ritten = $this->ritregistratie_model->get_kosten($type, $locatie, $start, $eind);
    if (empty($ritten))
    {
      $this->session->set_flashdata('niet_gevonden', true);
      redirect('/ritregistratie/', 'refresh');
    }

    $pdf = $this->pdf_overzicht($title, $ritten, $type);        
  }
}