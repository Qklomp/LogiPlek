<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li><?php echo $type; ?></li>
  <li class="active"><?php echo $title; ?></li>
</ol>

<!-- DELETE ALERT -->
<div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <p>Weet je zeker dat je deze rit wilt verwijderen? </p>
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
        <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
      </div>
    </div>
  </div>
</div>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $title?></h2></li>
        <li>
          <a class="btn btn-primary btn-xs" <?php echo (!isset($vorige['id'])) ? 'disabled' : '' ?> href="/ritregistratie/<?php echo $type ?>/<?php echo $vorige['id'] ?>" name="vorige" title="Vorige"><i class="glyphicon glyphicon-step-backward"></i></a>
          <a class="btn btn-link btn-xs" href="/ritregistratie/<?php echo $type ?>/print/<?php echo $rit['id'] ?>" name="Printen" title="Printen" target="_blank"><i class="glyphicon glyphicon-print"></i></a>
          <a class="btn btn-link btn-xs open-deleteAlert" href="" data-id="<?php echo $rit['id']?>" data-type="ritregistratie/<?php echo $type ?>" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a></td>              
          <a class="btn btn-primary btn-xs" <?php echo (!isset($volgende['id'])) ? 'disabled' : '' ?> href="/ritregistratie/<?php echo $type ?>/<?php echo $volgende['id'] ?>" name="volgende" title="Volgende"><i class="glyphicon glyphicon-step-forward"></i></a>        
        </li>
      </ul>         
    </div>

    <div class="panel-body">
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('ritregistratie/'. $type . '/' . $rit['id'], $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">

            <h4>Informatie <small>Toegevoegd op <?php echo nl_text_date($rit['toegevoegd_op'])?> door <?php echo $rit['toegevoegd_door']?></small></h4> 

            <!-- INVOER GEGEVENS -->
            <div class="col-lg-5">  
              <div class="form-group">

                <div class="has-feedback <?php echo (form_error('datum') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Datum </label>
                  <div class="input-group">         
                    <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="form-control input-sm datepicker" name="datum" placeholder="Datum" required data-parsley-required="true" value="<?php echo $rit['datum']; ?>">
                  </div>
                </div>

                <div class="has-feedback <?php echo (form_error('vervoerder') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label"><?php echo ($type === 'extern') ? 'Koerier/Steunpunt' : 'Chauffeur' ?> </label>
                  <?php if($type === 'extern'): ?>
                    <select class="form-control input-sm vervoerder" name="vervoerder" required data-parsley-required="true" >
                      <option <?php echo set_select('vervoerder', '', FALSE); ?>></option>
                      <?php foreach ($vervoerder as $v): ?>
                        <?php if ($rit['vervoerder'] === $v['naam']): ?>
                          <option id="<?php echo $v['id']?>" data-target="kosten" value="<?php echo $v['naam'] ?>" <?php echo set_select('vervoerder', $v['naam'], TRUE) ?>><?php echo $v['naam'] ?></option>
                        <?php else: ?>                              
                          <option id="<?php echo $v['id']?>" data-target="kosten" value="<?php echo $v['naam'] ?>" <?php echo set_select('vervoerder', $v['naam'], FALSE) ?>><?php echo $v['naam'] ?></option>
                        <?php endif?>
                      <?php endforeach ?>
                    </select>
                  <?php else: ?>
                    <input type="text" class="form-control input-sm vervoerder" name="vervoerder" required data-parsley-required="true" value="<?php echo $rit['vervoerder']?>">
                  <?php endif ?>
                </div>

                <div class="has-feedback <?php echo (form_error('afstand') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Afstand </label>
                  <input class="form-control input-sm decimal" type="text" name="afstand" required data-parsley-required="true" value="<?php echo $rit['afstand']; ?>">
                </div>

                <div class="has-feedback <?php echo (form_error('kosten') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Kosten per kilometer </label>
                  <div class="input-group">         
                    <span class="input-group-addon input-sm">€</span>
                    <input type="text" class="form-control input-sm decimal" id="kosten" class="input-small" name="kosten" required data-parsley-required="true" value="<?php echo $rit['kosten']; ?>">
                  </div>
                </div>
               
                <?php if($type === 'extern'): ?>
                  <label class="control-label">Factuurnummer </label>
                  <input class="form-control input-sm" type="text" name="factuurnummer" value="<?php echo $rit['factuurnummer']; ?>"/>
                <?php else: ?>
                  <div class="has-feedback <?php echo (form_error('route') !== '') ? 'has-error' : '' ?>">
                    <label class="control-label">Route </label>
                    <select class="form-control input-sm" name="route">
                      <option <?php echo set_select('route', '', FALSE); ?>></option>
                      <?php foreach ($routes as $route): ?>
                        <?php if ($rit['route'] === ($route['routenummer'])): ?>
                          <option value="<?php echo $route['routenummer'] ?>" <?php echo set_select('route', $route['routenummer'], TRUE) ?>><?php echo $route['routenummer'] ?></option>
                        <?php else: ?>
                          <option value="<?php echo $route['routenummer'] ?>" <?php echo set_select('route', $route['routenummer'], FALSE) ?>><?php echo $route['routenummer'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                <?php endif ?>
               
                <div class="has-feedback <?php echo (form_error('user') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Ingevoerd door </label>
                  <select class="form-control input-sm" name="user" required data-parsley-required="true">
                    <option <?php echo set_select('user', '', FALSE); ?>></option>
                    <?php foreach ($users as $u): ?>
                      <?php if ($rit['user'] === ($u['user_first'] . ' ' . $u['user_last'])): ?>
                        <option value="<?php echo $u['user_first'] . ' ' . $u['user_last'] ?>" <?php echo set_select('user', $u['user_first'] . ' ' . $u['user_last'], TRUE) ?>><?php echo $u['user_first'] . ' ' . $u['user_last'] ?></option>
                      <?php else: ?>
                        <option value="<?php echo $u['user_first'] . ' ' . $u['user_last'] ?>" <?php echo set_select('user', $u['user_first'] . ' ' . $u['user_last'], FALSE) ?>><?php echo $u['user_first'] . ' ' . $u['user_last'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="has-feedback <?php echo (form_error('omschrijving') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Omschrijving </label>
                  <textarea class="form-control input-sm" name="omschrijving" rows="10" required data-parsley-required="true"><?php echo $rit['omschrijving']; ?></textarea>
                </div>
                
                <div class="has-feedback <?php echo (form_error('reden') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Reden <a class="btn-link reden"><?php echo in_array($rit['reden'], $redenen) ? 'zelf invoeren' : 'selecteren' ?></a></label>
                  <select class="form-control input-sm <?php echo in_array($rit['reden'], $redenen) ? '' : 'hidden' ?> reden-select" name="<?php echo in_array($rit['reden'], $redenen) ? 'reden' : '' ?>">
                    <option <?php echo set_select('reden', '', FALSE); ?>></option>
                    <?php foreach ($redenen as $r): ?>
                      <?php if ($rit['reden'] === $r): ?>
                        <option value="<?php echo $r ?>" <?php echo set_select('reden', $r, TRUE) ?>><?php echo $r ?></option>
                      <?php else: ?>
                        <option value="<?php echo $r ?>" <?php echo set_select('reden', $r, FALSE) ?>><?php echo $r ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                  <input class="form-control input-sm <?php echo in_array($rit['reden'], $redenen) ? 'hidden' : '' ?> reden-tekst" type="text" name="<?php echo in_array($rit['reden'], $redenen) ? '' : 'reden' ?>" value="<?php echo in_array($rit['reden'], $redenen) ? '' : $rit["reden"] ?>">
                </div>

                <div class="has-feedback <?php echo (form_error('locatie') !== '') ? 'has-error' : '' ?>">
                  <label class="control-label">Locatie </label>
                  <select class="form-control input-sm" name="locatie" required data-parsley-required="true">
                    <option <?php echo set_select('locatie', '', FALSE); ?>></option>
                    <?php foreach ($locaties as $l): ?>
                      <?php if ($rit['locatie'] === $l['locatie']): ?>
                        <option value="<?php echo $l['locatie'] ?>" <?php echo set_select('locatie', $l['locatie'], TRUE) ?>><?php echo $l['locatie'] ?></option>
                      <?php else: ?>
                        <option value="<?php echo $l['locatie'] ?>" <?php echo set_select('locatie', $l['locatie'], FALSE) ?>><?php echo $l['locatie'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </div>

              </div>
            <!-- END INVOER GEGEVENS -->  
            </div>
            
            <!-- PARTICIPANTEN -->
            <div class="col-lg-5 col-lg-offset-1">  
              <div class="has-feedback <?php echo (form_error('participant[]') !== '') ? 'has-error' : '' ?>">
                <h4 class="col-lg-offset-4">Aandeel per participant</h4>
              </div>

              <?php foreach($participanten as $p) : ?>
	        <?php if( ($p['active'] == 1) || isset($rit_participanten[$id][$p['id']]) ): ?>
		      <div class="col-sm-12">
		        <div class="form-group form-group-sm">
		          <label class="control-label col-sm-7"><?php echo $p['participant']; ?></label>
		          <input type="hidden" name="participanten[id][]" value="<?php echo $p['id']; ?>">
		          <div class="col-sm-4">
		            <input class="form-control input-sm" type="text" name="participanten[stops][]" value="<?php echo (isset($rit_participanten[$id][$p['id']])) ? $rit_participanten[$id][$p['id']] : '0' ?>">
		          </div>
		        </div>
		      </div>
                <?php endif ?>
              <?php endforeach ?>  
            <!-- END PARTICIPANTEN -->
            </div>                  
      
          </div>

          <div class="form-group text-center col-lg-12">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>  
          </div>     
        </fieldset> 
      </form> 
    <!-- END PANEL BODY -->
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/ritregistratie/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  <!-- END PANEL -->  
  </div>
</div>
