<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/personeel/">Personeel</a></li>
  <li class="active"><?php echo $personeel['voornaam'] . ' ' . $personeel['achternaam'] ?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $personeel['voornaam'] . ' ' . $personeel['achternaam'] ?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('personeel/' . $personeel['id'], $attributes) 
      ?>

        <fieldset> 
          <?php echo (isset($success)) ? '
            <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              De gegevens zijn aangepast!
            </div>' : '' ?>
          <div class="col-lg-12">  
            
            <div class="col-lg-5">

              <!-- NAAM -->
              <div class="form-group">   
                <h3>Personalia</h3>
                <div class="has-feedback <?php echo (form_error('voornaam') !== '') ? 'has-error' : '' ?>">
                  <label for="voornaam" class="control-label">Voornaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm " name="voornaam" placeholder="Voornaam" value="<?php echo $personeel['voornaam']?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('achternaam') !== '') ? 'has-error' : '' ?>">
                  <label for="achternaam" class="control-label">Achternaam <span class="text-danger">*</span></label>       
                  <input type="text" class="form-control input-sm" name="achternaam" placeholder="Achternaam" value="<?php echo $personeel['achternaam']?>" required data-parsley-required>
                </div>
                
                <label for="geboortedatum" class="control-label">Geboortedatum </label>       
                <div class="input-group">             
                  <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input type="text" class="form-control input-sm datepicker" name="geboortedatum" placeholder="Geboortedatum" value="<?php echo $personeel['geboortedatum']?>">
                </div>
              </div>        

              <!-- ADRES -->
              <div class="form-group">
                <h3>Adres</h3>
                <label for="straat" class="control-label">Straat </label>        
                <input type="text" class="form-control input-sm" name="straat" placeholder="Straat" value="<?php echo $personeel['straat'] ?>">        
              
                <label for="huisnummer" class="control-label">Huisnummer </label>        
                <input type="text" class="form-control input-sm" name="huisnummer" placeholder="Huisnummer" value="<?php echo $personeel['huisnummer'] ?>">        

                <label for="postcode" class="control-label">Postcode</label>        
                <input type="text" class="form-control input-sm postcode" name="postcode" placeholder="Postcode" value="<?php echo $personeel['postcode']?>">        

                <div class="has-feedback <?php echo (form_error('woonplaats') !== '') ? 'has-error' : '' ?>">
                  <label for="woonplaats" class="control-label">Woonplaats  <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="woonplaats" placeholder="Woonplaats" value="<?php echo $personeel['plaats']?>" required data-parsley-required>
                </div>
              </div>
            </div>       

            <div class="col-lg-5 col-lg-offset-1">

              <!-- CONTACT -->      
              <div class="form-group">   
                <h3>Contact</h3>      

                <label for="telefoonnummer" class="control-label">Telefoonnummer </label>        
                <input type="text" class="form-control input-sm telefoon" name="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo $personeel_telefoon[$personeel['id']]['vast']?>">  
                <p class="telefoon-error"></p>        
                
                <div class="has-feedback <?php echo (form_error('mobiel') !== '') ? 'has-error' : '' ?>">
                  <label for="mobiel" class="control-label">Mobiel <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo $personeel_telefoon[$personeel['id']]['mobiel'] ?>" required data-parsley-required>
                  <p class="telefoon-error"></p>
                </div>
                
                <label for="email" class="control-label">E-mail </label>        
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $personeel['email'] ?>" data-parsley-type="email">
              </div>   

              <!-- INFORMATIE -->
              <div class="form-group">   
                <h3>Informatie</h3>   

                <p class="form-control-static small">Toegevoegd op <?php echo nl_text_date($personeel['toegevoegd_op'])?> door <?php echo $personeel['toegevoegd_door']?></p>   
                
                <div class="has-feedback <?php echo (form_error('functie') !== '') ? 'has-error' : '' ?>">
                  <label for="functie" class="control-label">Functie </label>
                  <select class="form-control input-sm" name="functie" required data-parsley-required>
                    <option <?php echo set_select('functie', '', FALSE); ?>></option>
                    <?php foreach ($functies as $f): ?>
                      <?php if ($personeel['functie_id'] === $f['functie_id']): ?>
                        <option value="<?php echo $f['functie_id'] ?>" <?php echo set_select('functie', $f['functie_id'], TRUE) ?>><?php echo $f['functie'] ?></option>
                      <?php else: ?>
                        <option value="<?php echo $f['functie_id'] ?>" <?php echo set_select('functie', $f['functie_id'], FALSE) ?>><?php echo $f['functie'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select> 
                </div>

                <div class="has-feedback <?php echo (form_error('locatie') !== '') ? 'has-error' : '' ?>">
                  <label for="locatie" class="control-label">Locatie </label>
                  <select class="form-control input-sm" name="locatie" required data-parsley-required>
                    <option <?php echo set_select('locatie', '', FALSE); ?>></option>
                    <?php foreach ($locaties as $l): ?>
                      <?php if ($personeel['locatie_id'] === $l['id']): ?>
                        <option value="<?php echo $l['id'] ?>" <?php echo set_select('locatie', $l['id'], TRUE) ?>><?php echo $l['locatie'] ?></option>
                      <?php else: ?>
                        <option value="<?php echo $l['id'] ?>" <?php echo set_select('locatie', $l['id'], FALSE) ?>><?php echo $l['locatie'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select> 
                </div>                     
                          
              </div>  
            </div> 
          </div>

          <div class="form-group text-center">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>  
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