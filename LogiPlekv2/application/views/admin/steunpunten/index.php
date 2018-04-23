<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Steunpunten</li>
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
            <p>Weet je zeker dat je dit steunpunt wilt verwijderen? </p>
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
          </div>
        </div>
      </div>
    </div>
    
    <table class="table table-striped table-bordered table-hover table-condensed dataTable">
      <thead> 
        <tr>
          <th>Naam</th>
          <th>Contact</th>
          <th>Telefoonnummer</th>
          <th>Mobiel</th>
          <th>Adres</th>
          <th>Plaats</th> 
          <th>Assortiment</th>       
          <th class="narrow text-center"></th>
          <th class="narrow text-center"></th>
        </tr>
      </thead> 

      <tbody>
        <?php foreach ($steunpunten as $steunpunt): ?>
        <tr>
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['naam'] ?></a></td>        
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['contact'] ?></a></td>
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunten_telefoon[$steunpunt['id']]['vast'] ?></a></td>
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunten_telefoon[$steunpunt['id']]['mobiel'] ?></a></td>
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['straat'] . ' ' . $steunpunt['huisnummer'] ?></a></td>
          <td><a href="/steunpunten/<?php echo $steunpunt['id']?>">&nbsp;<?php echo $steunpunt['plaats'] ?></a></td>
          <td class="text-center assortiment">
            <?php foreach ($assortimenten as $a): ?> 
              <?php if(isset($steunpunt_assortiment[$steunpunt['id']][$a['id']])): ?>
                <span class="label label-success" id="<?php echo $a['id'] ?>"><?php echo $a['type']?></span>
              <?php endif ?>
            <?php endforeach ?>
          </td>
          <td class="text-center"><a href="/steunpunten/<?php echo $steunpunt['id']?>"><i class="glyphicon glyphicon-search"></i></a></td> 
          <td class="text-center"><a href="" class="open-deleteAlert" data-id="<?php echo $steunpunt['id']?>" data-type="steunpunten" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a></td> 
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  
  <div class="panel-footer">
    <ul class="list-inline">        
      <li><a href="/steunpunten/toevoegen/" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
      <li><a href="/steunpunten/printen/" target="_blank" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>   
      <li><a href="/steunpunten/assortiment/" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i> Assortiment beheren</span></a></li>   
    </ul>
  </div>
</div>