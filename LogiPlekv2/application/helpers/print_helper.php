<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  define('EURO',chr(128));

  function init($c = 4)
  {
    $config = array(
      'xdef' => 0,
      'ydef' => 10,
      'xplus' => 22,
      'yplus' => 4,
      'height' => 4,
      'width' => 190/$c,
    );

    return $config;
  }

  function pdf_init($title = 'Distrivers')
  {
    $CI =& get_instance();
    $CI->load->library('fpdf');

    $pdf = new fpdf();
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',14);
    $pdf->Image(asset_url() . "img/distr/logo.jpg", $pdf->GetX(), $pdf->GetY()-5, 33.78);   

    # TITLE
    $config = init();
    $pdf->Cell(0,0,$title,0,0,'C');
    $pdf->SetY($pdf->getY() + $config['yplus']*2); 

    return $pdf;
  }

  # VOOR STANDAARD OVERZICHTEN VAN OA PERSONEEL, AUTO, ETC.
  function pdf($title, $rows, $columns)
  {
    $pdf = pdf_init($title);
    $config = init(count($columns));

    # COLUMN HEADERS
    $pdf->SetFont('Arial', 'B', 10);
    foreach ($columns as $c)
    {
      $pdf->Cell($config['width'],$config['height'],ucfirst($c),1,0,'L');
    }

    $pdf->SetX($config['xdef']);
    $pdf->SetY($pdf->getY() + $config['yplus']);  

    # CONTENT
    $pdf->SetFont('Arial', '', 7);

    foreach ($rows as $r)
    {
      foreach ($columns as $c)
      {
        $s = html_entity_decode(iconv('UTF-8', 'windows-1252', $r[$c]));
        if (strlen($r[$c]) > 22)
        {
          $s = substr($r[$c], 0, 19) . '...';
        }
        $pdf->Cell($config['width'],$config['height'],$s,1,0,'L');
      }

      $pdf->SetX($config['xdef']);
      $pdf->SetY($pdf->getY() + $config['yplus']);        

      if ($pdf->getY() > '270')
      {
        $pdf->AddPage();
        $pdf->SetY($config['ydef']);
      }
    }
    return $pdf;
  }

  # VOOR HET MAKEN VAN COMPACTE OVERZICHTEN DIE ALLES BEVATTEN
  function print_overzicht($pdf, $rit, $columns)
  {
    $config = init();
    $rit['datum'] = nl_date($rit['datum']);
    $rit['ingevoerd door'] = $rit['user'];

    # CONTENT
    $pdf->SetFont('Arial', '', 7);    
    $pdf->Line(10,$pdf->getY(),200,$pdf->getY());
    $pdf->SetY($pdf->getY() + $config['yplus']);  

    foreach ($columns as $c)
    {
      $pdf->Cell($config['width'],$config['height'],ucfirst($c),0,0,'L');
      $pdf->SetX($config['width']);
    
      if( ($c === 'afstand') && empty($rit[$c]) )
      {
        $s = '1,00';
      }
      else if( ($c === 'kosten') && empty($rit[$c]) )
      {
        $s = '1,00';
      }        
      else
      {
        $s = html_entity_decode(iconv('UTF-8', 'windows-1252', $rit[$c]));
      }
      $pdf->Multicell($config['width']*3,$config['height'],$s);
    }

    $pdf->SetY($pdf->getY() + $config['yplus']);  
    $pdf->SetX($config['xdef']);

    if ($pdf->getY() > '270')
    {
      $pdf->AddPage();
      $pdf->SetY($config['ydef']);
    }

    return $pdf;
  }

  function print_totalen($pdf, $totalen, $totaal, $participanten)
  {
    $config = init();

    $pdf->SetY($pdf->getY() + $config['yplus'] * 2);
    $pdf->Line(10,$pdf->getY(),200,$pdf->getY());
    $pdf->SetY($pdf->getY() + $config['yplus']);

    $pdf->SetFont('Arial','B',9);     

    foreach ($participanten as $p)
    {
      if (isset($totalen[$p['id']]))
      {
        $pdf->Cell($config['width'],$config['height'],html_entity_decode(iconv('UTF-8', 'windows-1252', $p['participant'])),0,0,'L');
        $pdf->Cell($config['width'],$config['height'],EURO . number_format((float)$totalen[$p['id']],2, ',', '.'),0,0,'L');
      }
      else if($p['active'] == 1)
      {
        $pdf->Cell($config['width'],$config['height'],html_entity_decode(iconv('UTF-8', 'windows-1252', $p['participant'])),0,0,'L');
        $pdf->Cell($config['width'],4,EURO . '0',0,0,'L');
      }
      $pdf->SetX($config['xdef']);
      $pdf->SetY($pdf->getY() + $config['yplus']);  
    }

    $pdf->SetX($config['xdef']);
    $pdf->SetY($pdf->getY() + $config['yplus']); 
    $pdf->Line(10,$pdf->getY(),200,$pdf->getY());     
    $pdf->SetY($pdf->getY() + 1);
    $pdf->Line(10,$pdf->getY(),200,$pdf->getY());    
    $pdf->SetY($pdf->getY() + $config['yplus']);

    $pdf->SetFont('Arial','B',14);    
    $pdf->Cell($config['width'],$config['height'],'Totaal',0,0,'L');
    $pdf->Cell($config['width'],$config['height'], EURO . ' ' . number_format((float)($totaal),2, ',', '.'),0,0,'L');

    return $pdf;
  }

  function print_rit_totalen($pdf, $totalen, $totaal, $participanten)
  {
    $config = init();
    $pdf->SetY($pdf->getY() + $config['yplus']);

    $pdf->SetFont('Arial','B',7);     

    foreach ($participanten as $p)
    {      
      if (isset($totalen[$p['id']]))
      {
        $pdf->Cell($config['width'],$config['height'],html_entity_decode(iconv('UTF-8', 'windows-1252', $p['participant'])),0,0,'L');
        $pdf->Cell($config['width'],$config['height'],EURO . number_format((float)$totalen[$p['id']],2, ',', '.'),0,0,'L');
        $pdf->SetX($config['xdef']);
        $pdf->SetY($pdf->getY() + $config['yplus']); 
      }      
    }

    $pdf->SetFont('Arial','B',9);    
    $pdf->Cell($config['width'],$config['height'],'Totaal',0,0,'L');
    $pdf->Cell($config['width'],$config['height'], EURO . ' ' . number_format((float)($totaal),2, ',', '.'),0,0,'L');
    $pdf->SetY($pdf->getY() + $config['yplus']); 

    return $pdf;
  }

  function ritbon($rit, $multi = false)
  {
    $pdf = pdf_init('Externe rit, referentienummer: ' . $rit['id']);
    $config = init();
  
    $pdf->SetY($pdf->getY() + $config['yplus']); 
    $pdf->Line(10,$pdf->getY(),200,$pdf->getY());
    $pdf->SetY($pdf->getY() + $config['yplus']); 

    # TABLE HEADER
    $pdf->SetFont('Arial','B',9); 
    $columns = array('vervoerder', 'datum', 'afstand', 'kosten', 'ingevoerd door', 'omschrijving', 'reden', 'totaal');
    $rit['datum'] = nl_date($rit['datum']);
    $rit['ingevoerd door'] = $rit['user'];
    $rit['totaal'] = $rit['afstand'] * $rit['kosten'];
    foreach ($columns as $c)
    {
      $pdf->Cell($config['width'],$config['height'],ucfirst($c));      
      $pdf->SetX($pdf->getX() + $config['xplus']/4);
      if (in_array($c, array('kosten', 'totaal')))
      {
        $pdf->MultiCell($config['width']*3,$config['height'], EURO . number_format((float)$rit[$c],2, ',', '.'));
      }
      else
      {
        $pdf->MultiCell($config['width']*3,$config['height'], html_entity_decode(iconv('UTF-8', 'windows-1252', $rit[$c])));
      }
      $pdf->SetX($config['xdef']);
      $pdf->SetY($pdf->getY() + $config['yplus']); 
    }

    return $pdf;
  }
?>
