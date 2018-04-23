<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/autos/">Auto's</a></li>
  <li class="active">Auto <?php echo $auto['autonummer'] ?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Auto <?php echo $auto['autonummer'] ?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('autos/' . $auto['id'], $attributes) 
      ?>

        <fieldset> 
          
          <div class="col-lg-12">  
            
            <!-- LEFT -->
            <div class="col-lg-5">

              <!-- NAAM -->
              <div class="form-group">   
                <h3>Gegevens</h3>
                <div class="has-feedback <?php echo (form_error('autonummer') !== '') ? 'has-error' : '' ?>">
                  <label for="autonummer" class="control-label">Autonummer <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="autonummer" placeholder="Autonummer" value="<?php echo $auto['autonummer']?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('kenteken') !== '') ? 'has-error' : '' ?>">
                  <label for="kenteken" class="control-label">Kenteken <span class="text-danger">*</span></label>     
                  <input type="text" class="form-control input-sm licenseplate" name="kenteken" placeholder="Kenteken" value="<?php echo $auto['kenteken']?>" required data-parsley-required>
                </div>
                
                <label for="kmstand" class="control-label">Kilometerstand </label>
                <input type="text" class="form-control input-sm" name="kmstand" placeholder="Kilometerstand" value="<?php echo $auto['kmstand']?>">

                <label for="route" class="control-label">Route </label>
                <select class="form-control input-sm" name="route">
                  <option <?php echo set_select('route', '', FALSE); ?>></option>
                  <?php foreach ($routes as $r): ?>                    
                    <?php if ($auto['route_id'] === $r['id']): ?>
                      <option value="<?php echo $r['id'] ?>" <?php echo set_select('route', $r['id'], TRUE) ?>><?php echo $r['routenummer'] ?></option>
                    <?php else: ?>
                      <option value="<?php echo $r['id'] ?>" <?php echo set_select('route', $r['id'], FALSE) ?>><?php echo $r['routenummer'] ?></option>
                    <?php endif ?>
                  <?php endforeach ?>  
                </select>  

                <div class="has-feedback <?php echo (form_error('type') !== '') ? 'has-error' : '' ?>">
                  <label for="type" class="control-label">Type <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="type" required data-parsley-required>
                    <option <?php echo set_select('type', '', FALSE); ?>></option>
                    <?php foreach ($types as $t): ?>
                      <?php if($auto['auto_type_id'] === $t['type_id']): ?>
                        <option value="<?php echo $t['type_id']?>" <?php echo set_select('type', $t['type_id'], TRUE)?>><?php echo $t['type'] ?></option>;
                      <?php else: ?>
                        <option value="<?php echo $t['type_id'] ?>" <?php echo set_select('type', $t['type_id'], FALSE) ?>><?php echo $t['type'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>                    
                  </select>  
                </div> 
              <!-- END NAAM -->
              </div>   
            <!-- END LEFT -->
            </div>

            <!-- RIGHT -->
            <div class="col-lg-5 col-lg-offset-1">

              <!-- INFORMATIE -->
              <div class="form-group">   
                <h3>Informatie</h3>            
                  <p class="form-control-static small">Toegevoegd op <?php echo nl_text_date($auto['toegevoegd_op'])?> door <?php echo $auto['toegevoegd_door']?></p>              
              </div>  
            </div>
          <!-- END RIGHT -->  
          </div>

          <!-- BUTTONS -->
          <div class="form-group text-center">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>  
          </div>
        </fieldset>
      </form>
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/autos/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>