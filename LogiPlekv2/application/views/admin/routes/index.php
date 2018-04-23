<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Routes</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>

<div class="panel panel-default">

  <div class="panel-heading">
    <ul class="list-inline">   
      <li><h2><?php echo $title ?></h2></li>
    </ul>    
  </div>

  <div class="panel-body">

    <!-- DELETE ALERT -->
    <div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p>Weet je zeker dat je deze route wilt verwijderen? </p>
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
          </div>
        </div>
      </div>
    </div>
    
    <table class="table table-striped table-bordered table-hover table-condensed dataTable">
      <thead> 
        <tr>
          <th>Route</th>
          <th>Snelnummer</th>
          <th>Telefoonnummer</th>
          <th>Type</th>  
          <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za', 'zo') as $dag) {
            echo '<th class="narrow">' . $dag . '</th>';
          }?>  
          <th class="narrow text-center"></th>
          <th class="narrow text-center"></th>
        </tr>
      </thead>  

      <tbody>
        <?php foreach ($routes as $route): ?>
        <tr> 
          <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['routenummer'] ?></a></a></td>        
          <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['snelnummer'] ?></a></td>
          <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['telefoonnummer'] ?></a></td>
          <td><a href="/routes/<?php echo $route['id']?>">&nbsp;<?php echo $route['type'] ?></a></td>
          <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za', 'zo') as $dag): ?>
            <td class="text-center"><a href="/routes/<?php echo $route['id']?>"><?php echo isset($route_tijden[$route['id']][$dag]) ? $route_tijden[$route['id']][$dag] : '&nbsp;' ?></a></td>
          <?php endforeach ?>       
          <td class="text-center"><a href="/routes/<?php echo $route['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
          <td class="text-center"><a href="" class="open-deleteAlert" data-id="<?php echo $route['id']?>" data-type="routes" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a></td> 
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  
  <div class="panel-footer">
    <ul class="list-inline">          
      <li><a href="/routes/toevoegen/" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</a></li>
      <li><a href="/routes/printen" target="_blank" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-print"></i> Printen</a></li>   
    </ul>
  </div>
</div>