<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/autos/">Auto's</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $title?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('autos/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">  

            <div class="col-lg-5">

              <!-- AUTO -->
              <div class="form-group"> 
                <div class="has-feedback <?php echo (form_error('autonummer') !== '') ? 'has-error' : '' ?>">
                  <label for="autonummer" class="control-label">Autonummer <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="autonummer" placeholder="Autonummer" value="<?php echo set_value('autonummer'); ?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('kenteken') !== '') ? 'has-error' : '' ?>">
                  <label for="kenteken" class="control-label">Kenteken <span class="text-danger">*</span></label>     
                  <input type="text" class="form-control input-sm licenseplate" name="kenteken" placeholder="Kenteken" value="<?php echo set_value('kenteken'); ?>" required data-parsley-required>
                </div>
                
                <label for="kmstand" class="control-label">Kilometerstand </label>
                <input type="text" class="form-control input-sm" name="kmstand" placeholder="Kilometerstand" value="<?php echo set_value('kmstand'); ?>">

                <label for="route" class="control-label">Route </label>
                <select class="form-control input-sm" name="route">
                  <option <?php echo set_select('route', '', TRUE); ?>></option>
                  <?php foreach ($routes as $r): ?>
                    <option value="<?php echo $r['id'] ?>" <?php echo set_select('route', $r['id'], FALSE) ?>><?php echo $r['routenummer'] ?></option>
                  <?php endforeach ?>
                </select>  

                <div class="has-feedback <?php echo (form_error('type') !== '') ? 'has-error' : '' ?>">
                  <label for="type" class="control-label">Type <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="type" required data-parsley-required>
                    <option <?php echo set_select('type', '', TRUE); ?>></option>
                    <?php foreach ($types as $t): ?>
                      <option value="<?php echo $t['type_id'] ?>" <?php echo set_select('type', $t['type_id'], FALSE) ?>><?php echo $t['type'] ?></option>
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
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/autos/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>