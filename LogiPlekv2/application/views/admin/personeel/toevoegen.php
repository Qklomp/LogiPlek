<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/personeel/">Personeel</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Personeel toevoegen</h2></li>
      </ul>    
    </div>

    <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('personeel/toevoegen', $attributes) 
      ?>

        <fieldset>     
          <div class="col-lg-12">  
            
            <div class="col-lg-5">

              <!-- NAAM -->
              <div class="form-group">   
                <h3>Persoon</h3>
                <div class="has-feedback <?php echo (form_error('voornaam') !== '') ? 'has-error' : '' ?>">
                  <label for="voornaam" class="control-label">Voornaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm " name="voornaam" placeholder="Voornaam" value="<?php echo set_value('voornaam'); ?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('achternaam') !== '') ? 'has-error' : '' ?>">
                  <label for="achternaam" class="control-label">Achternaam <span class="text-danger">*</span></label>       
                  <input type="text" class="form-control input-sm" name="achternaam" placeholder="Achternaam" value="<?php echo set_value('achternaam'); ?>" required data-parsley-required>
                </div>
                
                <label for="geboortedatum" class="control-label">Geboortedatum </label>       
                <div class="input-group">              
                  <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input type="text" class="form-control input-sm datepicker" name="geboortedatum" placeholder="Geboortedatum" value="<?php echo set_value('geboortedatum'); ?>">
                </div>
              </div>        

              <!-- ADRES -->
              <div class="form-group">
                <h3>Adres</h3>
                <label for="straat" class="control-label">Straat </label>        
                <input type="text" class="form-control input-sm" name="straat" placeholder="Straat" value="<?php echo set_value('straat'); ?>">        
              
                <label for="huisnummer" class="control-label">Huisnummer </label>        
                <input type="text" class="form-control input-sm" name="huisnummer" placeholder="Huisnummer" value="<?php echo set_value('huisnummer'); ?>">        

                <label for="postcode" class="control-label">Postcode</label>        
                <input type="text" class="form-control input-sm" name="postcode" placeholder="Postcode" value="<?php echo set_value('postcode'); ?>">        

                <div class="has-feedback <?php echo (form_error('woonplaats') !== '') ? 'has-error' : '' ?>">
                  <label for="woonplaats" class="control-label">Woonplaats <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="woonplaats" placeholder="Woonplaats" value="<?php echo set_value('woonplaats'); ?>" required data-parsley-required>
                </div>
              </div>
            </div>       

            <div class="col-lg-5 col-lg-offset-1">

              <!-- CONTACT -->      
              <div class="form-group">   
                <h3>Contact</h3>           
                <label for="telefoonnummer" class="control-label">Telefoonnummer </label>        
                <input type="text" class="form-control input-sm telefoon" name="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo set_value('telefoonnummer'); ?>">
                <p class="telefoon-error"></p>
                
                <div class="has-feedback <?php echo (form_error('mobiel') !== '') ? 'has-error' : '' ?>">
                  <label for="mobiel" class="control-label">Mobiel <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo set_value('mobiel'); ?>" required data-parsley-required>
                  <p class="telefoon-error"></p>
                </div>
                
                <label for="email" class="control-label">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo set_value('email'); ?>" data-parsley-type="email" required data-parsley-required>
              </div> 

              <!-- OVERIG -->      
              <div class="form-group">   
                <h3>Overig</h3>      

                <div class="has-feedback <?php echo (form_error('functie') !== '') ? 'has-error' : '' ?>">   
                  <label for="functie" class="control-label">Functie <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="functie" required data-parsley-required>
                    <option <?php echo set_select('functie', '', TRUE); ?>></option>
                    <?php foreach ($functies as $f): ?>
                      <option value="<?php echo $f['functie_id'] ?>" <?php echo set_select('functie', $f['functie_id'], FALSE) ?>><?php echo $f['functie'] ?></option>
                    <?php endforeach ?>
                  </select> 
                </div>

                <div class="has-feedback <?php echo (form_error('mobiel') !== '') ? 'has-error' : '' ?>">
                  <label for="locatie" class="control-label">Locatie <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="locatie" required data-parsley-required>
                    <option <?php echo set_select('locatie', '', TRUE); ?>></option>
                    <?php foreach ($locaties as $l): ?>
                      <option value="<?php echo $l['id'] ?>" <?php echo set_select('locatie', $l['id'], FALSE) ?>><?php echo $l['locatie'] ?></option>
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
        <li><a href="/personeel/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>