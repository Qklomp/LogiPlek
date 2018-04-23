<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li class="active">Standaard ritten</li>
</ol>

<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-success col-lg-8 col-lg-offset-2"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>
<?php echo (isset($fout)) ? '<div class="alert alert-dismissable alert-warning col-lg-8 col-lg-offset-2"><button type="button" class="close" data-dismiss="alert">×</button>Er ging iets mis, probeer het opnieuw!</div>' : '' ?>
<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success col-lg-8 col-lg-offset-2"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>

<!-- DELETE ALERT -->
<div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <p>Weet je zeker dat je deze standaard rit wilt verwijderen? </p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
        <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default table-responsive">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Standaard ritten</h2></li>
      </ul>    
    </div>

     <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal');
        echo form_open('ritregistratie/standaardritten/opslaan', $attributes) 
      ?>
        <fieldset> 
          <div class="col-lg-12 table-responsive">
            <table class="table table-striped table-bordered table-condensed">
              <thead> 
                <tr>
                  <th>Participant</th>
                  <th>Omschrijving</th>
                  <th>Kosten</th>
                  <th>Vervoerder</th>
                  <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za') as $dag): ?>
                    <th class="narrow text-center"><?php echo $dag ?></th>
                  <?php endforeach ?>  
                  <th class="narrow text-center">alles</th>
                  <th class="text-center"></th>
                </tr>
              </thead> 
              <tbody>                   
                <?php foreach ($standaardritten as $s): ?>
                   <tr>
                    <input type="hidden" name="sr[<?php echo $s['id']?>][id]" value="<?php echo $s['id']?>">
                    <td>
                      <?php foreach ($participanten as $p): ?>
                        <?php if ($p['id'] === $s['participant_id']): ?>                      
                          <?php echo $p['participant']; ?>                      
                        <?php endif ?>
                      <?php endforeach ?>
                    </td>
                    <td><?php echo $s['omschrijving'] ?></td>    
                    <td><?php echo $s['kosten'] ?></td> 
                    <td><?php echo $s['vervoerder'] ?></td>   
                    <?php foreach (array('ma', 'di', 'wo', 'do', 'vr', 'za') as $dag): ?>
                      <td class="text-center"><input type="checkbox" name="sr[<?php echo $s['id'] ?>][<?php echo $dag ?>]" value=""></td>
                    <?php endforeach ?> 
                    <td class="text-center"><input type="checkbox" class="checkall"></td>
                    <td class="text-center"><a href="" class="open-deleteAlert" data-id="<?php echo $s['id']?>" data-type="standaardritten" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a></td> 
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>  
          </div>          
          <div class="form-group text-center col-lg-12">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Opslaan voor week... </button>               
            <input type="text" class="srdweek input-lg" name="week" Placeholder="Bv. <?php echo date('Wy') ?>" required>
        </div>
        </fieldset>
      </form>
    </div>
    <div class="panel-footer">
      <ul class="list-inline">      
        <li><a href="/ritregistratie/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</span></a></li>
        <li><a href="/ritregistratie/standaardritten/toevoegen" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li> 
      </ul>
    </div>
  </div>
</div>