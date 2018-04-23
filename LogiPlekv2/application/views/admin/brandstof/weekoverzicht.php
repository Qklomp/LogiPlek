<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/brandstof/"> Brandstof</a></li>
  <li class="active">Weekoverzicht week <?php echo $week?></li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De invoer is toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De invoer is aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>De invoer is verwijderd!</div>' : '' ?>

<div class="panel panel-default">

  <div class="panel-heading">
    <ul class="list-inline ">   
      <li><h2><?php echo $title . " week " . $week ?></h2></li> 
    </ul>         
  </div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Type</th>
            <th>Kilometers</th>
            <th>Liters</th>
            <th>Koeling</th>
            <th>Adblue</th>
            <th>Gemiddeld verbruik (km/l)</th>
            <th>Zuinigste chauffeur</th>
            <th>Zuinigste auto</th>
            <th>Zuinigste verbruik (km/l)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><strong>Bus</strong></td>
            <td><?php echo $bus['kilometers'] ?></td>
            <td><?php echo $bus['liters'] ?></td>
            <td></td>
            <td></td>          
            <td><?php echo ($bus['verbruik'] / $bus['aantal'])?></td>
            <td><?php echo $bus['zuinigste_chauf'] ?></td>
            <td><?php echo $bus['zuinigste_auto'] ?></td>          
            <td><?php echo $bus['laagste_verbruik']?></td>
          </tr>
          <tr>
            <td><strong>Ding Dong</strong></td>
            <td><?php echo $dingdong['kilometers'] ?></td>
            <td><?php echo $dingdong['liters'] ?></td>
            <td></td>
            <td></td>          
            <td><?php echo ($dingdong['verbruik'] / $dingdong['aantal'])?></td>          
            <td><?php echo $dingdong['zuinigste_chauf'] ?></td>
            <td><?php echo $dingdong['zuinigste_auto'] ?></td>          
            <td><?php echo $dingdong['laagste_verbruik']?></td>
          </tr>
          <tr>
            <td><strong>Vrachtwagen</strong></td>
            <td><?php echo $vrachtwagen['kilometers'] ?></td>
            <td><?php echo $vrachtwagen['liters'] ?></td>
            <td><?php echo $vrachtwagen['koeling'] ?></td>
            <td><?php echo $vrachtwagen['adblue'] ?></td>          
            <td><?php echo ($vrachtwagen['verbruik'] / $vrachtwagen['aantal'])?></td>          
            <td><?php echo $vrachtwagen['zuinigste_chauf'] ?></td>
            <td><?php echo $vrachtwagen['zuinigste_auto'] ?></td>          
            <td><?php echo $vrachtwagen['laagste_verbruik']?></td>
          </tr>
        </tbody>
      </table>      
    </div>
  </div>
  <div class="panel-footer">
    <ul class="list-inline">          
      <li><a href="/brandstof/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</span></a></li>
    </ul>
  </div>
</div>