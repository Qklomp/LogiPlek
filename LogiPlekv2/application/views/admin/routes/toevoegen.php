<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/routes/">Routes</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Route toevoegen</h2></li>
      </ul>    
    </div>

    <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('routes/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">  

            <div class="col-lg-5">

              <!-- ROUTE -->
              <div class="form-group">   
                <h3>Route</h3>
                <div class="has-feedback <?php echo (form_error('routenummer') !== '') ? 'has-error' : '' ?>">
                  <label for="routenummer" class="control-label">Routenummer <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="routenummer" placeholder="Routenummer" value="<?php echo set_value('routenummer'); ?>" required data-parsley-required>
                </div>

                <label for="telefoonnummer" class="control-label">Telefoonnummer </label>     
                <input type="text" class="form-control input-sm telefoon" name="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo set_value('telefoonnummer'); ?>">
                <p class="telefoon-error"></p>
                
                <label for="snelnummer" class="control-label">Snelnummer </label>
                <input type="text" class="form-control input-sm" name="snelnummer" placeholder="Snelnummer" value="<?php echo set_value('snelnummer'); ?>">

                <div class="has-feedback <?php echo (form_error('type') !== '') ? 'has-error' : '' ?>">  
                  <label for="type" class="control-label">Type <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="type" required data-parsley-required>
                    <option <?php echo set_select('type', '', TRUE); ?>></option>
                    <?php foreach ($types as $t): ?>
                      <option value="<?php echo $t['id'] ?>" <?php echo set_select('type', $t['id'], FALSE) ?>><?php echo $t['type'] ?></option>
                    <?php endforeach ?>
                  </select>  
                </div>                         
              </div>  
          
            </div>
          </div>

          <div class="form-group text-center">
            <legend></legend>
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</button>  
          </div>
        </fieldset>
      </form>
    <!-- END PANEL-BODY -->
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/routes/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>