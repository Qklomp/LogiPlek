<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/brandstof/"> Brandstof</a></li>
  <li class="active">
    <?php echo $title ?>
  </li>
</ol>

<div class="panel panel-default">
  <div class="panel-heading">
    <ul class="list-inline ">   
      <li>
        <h2><?php echo $title ?></h2>
      </li> 
    </ul>         
  </div>

  <div class="panel-body">
   Het gemiddelde verbruik van auto <?php echo $autonummer?> in de periode van <?php echo $start ?> tot en met <?php echo $eind?> was <strong><?php echo $gemiddelde_verbruik ?></strong>. Er is in deze periode door deze auto <strong><?php echo $totaal_km?></strong>km gereden en <strong><?php echo $totaal_diesel?></strong> diesel getankt.
  </div>

  <div class="panel-footer">
    <ul class="list-inline">          
      <li><a href="/brandstof/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</span></a></li>
    </ul>
  </div>
</div>