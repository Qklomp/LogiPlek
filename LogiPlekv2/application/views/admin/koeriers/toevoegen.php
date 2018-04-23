<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/koeriers/">Koeriers</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Koerier toevoegen</h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('koeriers/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">  

            <!-- LEFT -->
            <div class="col-lg-5">

              <div class="form-group">
                <h3>Gegevens</h3>
                <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
                  <label for="firmanaam" class="control-label">Firmanaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="firmanaam" placeholder="Firmanaam" value="<?php echo set_value('firmanaam'); ?>" required data-parsley-required>
                </div>
          
                <label for="telefoonnummer" class="control-label">Telefoonnummer</label>
                <input type="text" class="form-control input-sm telefoon" name="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo set_value('telefoonnummer'); ?>">
                <p class="telefoon-error"></p>

                <label for="email" class="control-label">E-mail</label>
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo set_value('email'); ?>" data-parsley-type="email">

                <div class="has-feedback <?php echo (form_error('omgeving') !== '') ? 'has-error' : '' ?>">
                  <label for="omgeving" class="control-label">Omgeving <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="omgeving" placeholder="Omgeving" value="<?php echo set_value('omgeving'); ?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('kosten_km') !== '') ? 'has-error' : '' ?>">
                  <label for="kosten_km" class="control-label">Kosten per kilometer <span class="text-danger">*</span></label>
                  <div class="input-group">             
                    <span class="input-group-addon input-sm">€</span>
                    <input type="text" class="form-control input-sm decimal" name="kosten_km" placeholder="Kosten per kilometer" value="<?php echo set_value('kosten_km'); ?>" required data-parsley-required> 
                  </div>
                </div>
                
                <div class="has-feedback <?php echo (form_error('koeling') !== '') ? 'has-error' : '' ?>"> 
                  <label for="koeling" class="control-label">Koeling <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="koeling" required data-parsley-required>
                    <option <?php echo set_select('koeling', '', TRUE); ?>></option>
                    <option <?php echo set_select('koeling', 'Ja') ?> >Ja</option>
                    <option <?php echo set_select('koeling', 'Nee') ?> >Nee</option>
                  </select>  
                </div>
              </div>

            <!-- END LEFT -->   
            </div>

            <!-- RIGHT -->
            <div class="col-lg-5 col-lg-offset-1">

              <!-- CONTACTEN -->
              <div class="form-group">   
                <h3>Contactpersoon</h3>  
                <label for="contact" class="control-label">Naam contact</label>
                <input type="text" class="form-control input-sm" name="contact" placeholder="Contact" value="<?php echo set_value('contact'); ?>">     

                <label for="mobiel" class="control-label">Mobiel</label>
                <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo set_value('mobiel'); ?>">  
                <p class="telefoon-error"></p>     
              </div>
             
            </div> 

          <!-- END RIGHT -->
          </div>  

          <!-- BUTTONS -->   
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
        <li><a href="/koeriers/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>