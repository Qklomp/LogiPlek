<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/steunpunten/">Steunpunten</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Steunpunt toevoegen</h2></li>
      </ul>    
    </div>

    <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('steunpunten/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">  
            
            <div class="col-lg-5">

              <!-- NAAM -->
              <div class="form-group">   
                <h3>Gegevens</h3>
                <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
                  <label for="firmanaam" class="control-label">Firmanaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="firmanaam" placeholder="Firmanaam" value="<?php echo set_value('firmanaam'); ?>" required data-parsley-required>
                </div>              

                <div class="has-feedback <?php echo (form_error('telefoon') !== '') ? 'has-error' : '' ?>">
                  <label for="telefoon" class="control-label">Telefoon <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm telefoon" name="telefoon" placeholder="Telefoon" value="<?php echo set_value('telefoon'); ?>" required data-parsley-required>
                  <p class="telefoon-error"></p>
                </div>

                <label for="email" class="control-label">E-mail </label>       
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo set_value('email'); ?>" data-parsley-type="email">
              </div>        

              <!-- ADRES -->
              <div class="form-group">
                <h3>Adres</h3>

                <div class="has-feedback <?php echo (form_error('straat') !== '') ? 'has-error' : '' ?>">
                  <label for="straat" class="control-label">Straat <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="straat" placeholder="Straat" value="<?php echo set_value('straat'); ?>" required data-parsley-required>    
                </div>    
                
                <div class="has-feedback <?php echo (form_error('huisnummer') !== '') ? 'has-error' : '' ?>">
                  <label for="huisnummer" class="control-label">Huisnummer <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="huisnummer" placeholder="Huisnummer" value="<?php echo set_value('huisnummer'); ?>" required data-parsley-required>
                </div>        

                <label for="postcode" class="control-label">Postcode</label>        
                <input type="text" class="form-control input-sm postcode" name="postcode" placeholder="Postcode" value="<?php echo set_value('postcode'); ?>">        

                <div class="has-feedback <?php echo (form_error('plaats') !== '') ? 'has-error' : '' ?>">
                  <label for="plaats" class="control-label">Plaats  <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="plaats" placeholder="Plaats" value="<?php echo set_value('plaats'); ?>" required data-parsley-required>
                </div>
              </div>
            </div>       

            <div class="col-lg-5 col-lg-offset-1">  

              <!-- CONTACTPERSOON -->
              <div class="form-group">
                <h3>Contactpersoon</h3>

                <label for="contact" class="control-label">Contactpersoon </label>       
                <input type="text" class="form-control input-sm" name="contact" placeholder="Contactpersoon" value="<?php echo set_value('contact'); ?>">
                
                <label for="mobiel" class="control-label">Mobiel </label>
                <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo set_value('mobiel'); ?>">
                <p class="telefoon-error"></p>
              </div>

              <!-- ASSORTIMENT -->
              <div class="form-group">
                <h3>Assortiment</h3>

                <?php foreach ($assortimenten as $a) : ?>
                  <div class="checkbox col-lg-6">
                    <label>
                      <input type="checkbox" name="assortiment[]" value="<?php echo $a['id']?>"> <?php echo $a['type'] ?>
                    </label>
                  </div>
                <?php endforeach ?>
                
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
        <li><a href="/steunpunten/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>