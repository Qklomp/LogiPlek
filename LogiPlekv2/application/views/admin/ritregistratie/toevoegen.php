<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li><?php echo $type ?></li>
  <li class="active"><?php echo $title ?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $title ?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open('ritregistratie/'. $type . '/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">
          	<!-- INVOER GEGEVENS -->
          	<div class="col-lg-5">	
              <div class="form-group">

                <div class="has-feedback <?php echo (form_error('datum') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Datum </label>
              		<div class="input-group">         
                    <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="form-control input-sm datepicker" name="datum" placeholder="Datum" required data-parsley-required="true" value="<?php echo date('d-m-Y'); ?>">
                  </div>
                </div>

                <div class="has-feedback <?php echo (form_error('vervoerder') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label"><?php echo ($type === 'extern') ? 'Koerier/Steunpunt' : 'Chauffeur' ?> </label>
                  <?php if($type === 'extern'): ?>
                		<select class="form-control input-sm vervoerder" name="vervoerder" required data-parsley-required="true" >
                      <option<?php echo set_select('vervoerder', '', TRUE); ?>></option>
                      <?php 
                        foreach ($vervoerder as $v)
                        {
                          echo '<option id="' . $v['id'] . '" data-target="kosten" value="' . $v['naam'] . '"' . set_select('vervoerder', $v['naam'], FALSE) . '>' . $v['naam'] . '</option>';
                        } 
                      ?>
                		</select>
                  <?php else: ?>
                    <input type="text" class="form-control input-sm vervoerder" name="vervoerder" required data-parsley-required="true" value="Distrivers">
                  <?php endif ?>
                </div>

                <div class="has-feedback <?php echo (form_error('afstand') !== '') ? 'has-error' : '' ?>">
            		  <label class="control-label">Afstand </label>
            		  <input class="form-control input-sm decimal" type="text" name="afstand" required data-parsley-required="true" value="<?php echo set_value('afstand'); ?>">
            		</div>

                <div class="has-feedback <?php echo (form_error('kosten') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Kosten per kilometer </label>
              		<div class="input-group">         
                    <span class="input-group-addon input-sm">€</span>
              			<input type="text" class="form-control input-sm decimal" <?php echo ($type === 'extern') ? 'id="kosten"' : '' ?> class="input-small" name="kosten" required data-parsley-required="true" value="<?php echo ($type === 'intern') ? '42,50' : set_value('kosten') ?>">
              		</div>
                </div>
            	 
                <?php if( $type === 'extern') { ?>
              		<label class="control-label">Factuurnummer </label>
              		<input class="form-control input-sm" value="" type="text" name="factuurnummer" value="<?php echo set_value('factuurnummer'); ?>">
                <?php } else { ?>
                  <div class="has-feedback <?php echo (form_error('route') !== '') ? 'has-error' : '' ?>">
                    <label class="control-label">Route </label>
                    <select class="form-control input-sm" name="route">
                      <option <?php echo set_select('route', '', FALSE); ?>></option>
                      <?php foreach ($routes as $route): ?>
                        <option value="<?php echo $route['routenummer'] ?>" <?php echo set_select('route', $route['routenummer'], FALSE) ?>><?php echo $route['routenummer'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                <?php } ?>
            	 
                <div class="has-feedback <?php echo (form_error('user') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Ingevoerd door </label>
              		<select class="form-control input-sm" name="user" required data-parsley-required="true">
              			<option <?php echo set_select('user', '', TRUE); ?>></option>
                    <?php 
                      foreach ($users as $u)
                      {
                        ($voornaam . ' ' . $achternaam) === ($u['user_first'] . ' ' . $u['user_last']) ? $s = 'selected' : $s = '';
                        echo '<option ' . $s . ' value="' . $u['user_first'] . ' ' . $u['user_last'] . '"'. set_select('user', $u['user_first'] . ' ' . $u['user_last'], FALSE) . '>' . $u['user_first'] . ' ' . $u['user_last'] . '</option>';
                      } 
                    ?>
              		</select>
                </div>

                <div class="has-feedback <?php echo (form_error('omschrijving') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Omschrijving </label>
              		<textarea class="form-control input-sm" name="omschrijving" rows="10" required data-parsley-required="true"><?php echo set_value('omschrijving'); ?></textarea>
                </div>
            		
                <div class="has-feedback <?php echo (form_error('reden') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Reden <a class="btn-link reden">zelf invoeren</a></label>
              		<select class="form-control input-sm reden-select" name="reden">
              			<option <?php echo set_select('reden', '', TRUE); ?>></option>
                    <?php 
                      foreach ($redenen as $r)
                      {
                        echo '<option value="' . $r['reden'] . '"'. set_select('reden', $r['reden'], FALSE) . '>' . $r['reden'] . '</option>';
                      } 
                    ?>
              		</select>

                  <input class="form-control input-sm hidden reden-tekst" type="text" name="" value="<?php echo set_value('reden'); ?>">
                </div>

                <div class="has-feedback <?php echo (form_error('locatie') !== '') ? 'has-error' : '' ?>">
              		<label class="control-label">Locatie </label>
            			<select class="form-control input-sm" name="locatie" required data-parsley-required="true" >
                    <?php echo ($type === 'extern') ? "<option " . set_select('locatie', '', TRUE) . "></option>" : ''?>
                    <?php 
                      foreach ($locaties as $l)
                      {
                        if( ($type === 'intern') && ($l === 'Hoogeveen') )
                        {
                        echo '<option value="' . $l['locatie'] . '"'. set_select('locatie', $l['locatie'], TRUE) . '>' . $l['locatie'] . '</option>';
                        }
                        else
                        {
                          echo '<option value="' . $l['locatie'] . '"'. set_select('locatie', $l['locatie'], FALSE) . '>' . $l['locatie'] . '</option>';
                        }
                      } 
                    ?>
              		</select>
                </div>
              </div>
          	<!-- END INVOER GEGEVENS -->	
          	</div>
          	
          	<!-- PARTICIPANTEN -->
          	<div class="col-lg-5 col-lg-offset-1">  
              <div class="<?php echo (form_error('participanten_check') !== '') ? 'text-danger' : '' ?>">
          		  <h4 class="col-lg-offset-4">Aandeel per participant</h4>
                <input type="hidden" name="participanten_check">
              </div>
          		
              <?php foreach($participanten as $p) : ?>
		<?php if($p['active'] == 1): ?>
		      <div class="col-sm-12">
		        <div class="form-group form-group-sm">
		          <label class="control-label col-sm-7"><?php echo $p['participant']; ?></label>
		          <input type="hidden" name="participanten[id][]" value="<?php echo $p['id']; ?>">
		          <div class="col-sm-4">
		            <input class="form-control input-sm" type="text" name="participanten[stops][]" value="0">
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
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</button>  
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
