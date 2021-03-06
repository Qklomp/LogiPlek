<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li class="active">Participanten beheren</li>
</ol>

<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning col-lg-8 col-lg-offset-2"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>

<!-- DELETE ALERT -->
<div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <p>Weet je zeker dat je deze participant wilt verwijderen? </p>
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
        <li><h2>Participanten beheren</h2></li>
      </ul>    
    </div>

     <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal');
        echo form_open('ritregistratie/participanten/aanpassen', $attributes) 
      ?>
        <fieldset> 
          <div class="col-lg-12">
            <?php foreach ($participanten as $participant): ?> 
	      <?php if($participant['active'] == 1): ?> 
		    <div class="col-lg-4">
		      <div class="input-group input-group-sm"> 
		        <input type="hidden" class="form-control" name="participant[id][]" value="<?php echo $participant['id'] ?>">  
		        <input type="text" class="form-control" name="participant[type][]" value="<?php echo $participant['participant'] ?>">
		        <span class="input-group-addon">   
		          <a href="" class="open-deleteAlert" data-id="<?php echo $participant['id']?>" data-type="participanten" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a> 
		        </span>
		      </div>
		    </div>
              <?php endif ?>
            <?php endforeach ?>
            <div id="participant_append">   
              <div class="col-lg-4" id="participant">   
                <div class="input-group input-group-sm"> 
                  <input type="text" class="form-control" name="participant[type][]" value=""> 
                  <span class="input-group-addon">   
                    <i class="glyphicon glyphicon-tag"></i> 
                  </span>
                </div>
              </div>                           
            </div> 
            <a href="#" class="pull-right btn btn-link btn-xs clone_it" data-target="participant"><i class="glyphicon glyphicon-plus"></i> Voeg nog een type toe</a>
          </div>
          <div class="form-group text-center col-lg-12">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>  
          </div>
        </fieldset>
      </form>
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/ritregistratie/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>
