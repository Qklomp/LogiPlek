<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Personeel</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <ul class="list-inline">   
      <li><h2><?php echo $title ?> <small>personeel dat in het verleden verwijderd is</small></h2></li>
    </ul>    
  </div>

  <div class="panel-body">
    
    <table class="table table-striped table-bordered table-hover table-condensed dataTable">
      <thead> 
        <tr>
          <th>Naam</th>
          <th>Adres</th>
          <th>Woonplaats</th>
          <th class="narrow text-center"></th>
          <th class="narrow text-center"></th>
        </tr>
      </thead> 
      <tbody>    
        <?php foreach ($historisch_personeel as $personeel): ?>
        <tr> 
          <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['voornaam'] . ' ' . $personeel['achternaam'] ?></a></td>     
          <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['straat'] . ' ' . $personeel['huisnummer'] ?></a></td>
          <td><a href="/personeel/<?php echo $personeel['id']?>">&nbsp;<?php echo $personeel['plaats'] ?></a></td>        
          <td class="text-center"><a href="/personeel/<?php echo $personeel['id']?>"><i class="glyphicon glyphicon-search"></i></a></td>            
          <td class="text-center"><a href="/personeel/reset/<?php echo $personeel['id']?>"><i class="fa fa-undo"></i></a></td> 
         </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  
  </div>

  <div class="panel-footer">
    <ul class="list-inline">          
      <li><a href="/personeel/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</span></a></li>
    </ul>
  </div>
</div>