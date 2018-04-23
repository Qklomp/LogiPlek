<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/steunpunten/">Steunpunten</a></li>
  <li class="active"><?php echo $steunpunt['naam'] ?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $steunpunt['naam'] ?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">

      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('steunpunten/' . $steunpunt['id'], $attributes) 
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
                <h3>Gegevens</h3>
                <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
                  <label for="firmanaam" class="control-label">Firmanaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="firmanaam" placeholder="Firmanaam" value="<?php echo $steunpunt['naam']?>" required data-parsley-required>
                </div>              

                <div class="has-feedback <?php echo (form_error('telefoon') !== '') ? 'has-error' : '' ?>">
                  <label for="telefoon" class="control-label">Telefoon <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm telefoon" name="telefoon" placeholder="Telefoon" value="<?php echo $steunpunt_telefoon[$steunpunt['id']]['vast']?>" required data-parsley-required>
                  <p class="telefoon-error"></p>
                </div>

                <label for="email" class="control-label">E-mail </label>       
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $steunpunt['e-mail']?>" data-parsley-type="email">
              </div>        

              <!-- ADRES -->
              <div class="form-group">
                <h3>Adres</h3>

                <div class="has-feedback <?php echo (form_error('straat') !== '') ? 'has-error' : '' ?>">
                  <label for="straat" class="control-label">Straat <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="straat" placeholder="Straat" value="<?php echo $steunpunt['straat'] ?>" required data-parsley-required>    
                </div>    
                
                <div class="has-feedback <?php echo (form_error('huisnummer') !== '') ? 'has-error' : '' ?>">
                  <label for="huisnummer" class="control-label">Huisnummer <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="huisnummer" placeholder="Huisnummer" value="<?php echo $steunpunt['huisnummer'] ?>" required data-parsley-required>
                </div>        

                <label for="postcode" class="control-label">Postcode</label>        
                <input type="text" class="form-control input-sm postcode" name="postcode" placeholder="Postcode" value="<?php echo $steunpunt['postcode']?>">        

                <div class="has-feedback <?php echo (form_error('plaats') !== '') ? 'has-error' : '' ?>">
                  <label for="plaats" class="control-label">Plaats  <span class="text-danger">*</span></label>        
                  <input type="text" class="form-control input-sm" name="plaats" placeholder="Plaats" value="<?php echo $steunpunt['plaats']?>" required data-parsley-required>
                </div>
              </div>

              <!-- CONTACTPERSOON -->
              <div class="form-group">
                <h3>Contactpersoon</h3>

                <label for="contact" class="control-label">Contactpersoon </label>       
                <input type="text" class="form-control input-sm" name="contact" placeholder="Contactpersoon" value="<?php echo $steunpunt['contact']?>">
                
                <label for="mobiel" class="control-label">Mobiel </label>
                <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo $steunpunt_telefoon[$steunpunt['id']]['mobiel']?>">
                <p class="telefoon-error"></p>
              </div>

            </div>       

            <div class="col-lg-5 col-lg-offset-1">  

              <!-- ASSORTIMENT -->
              <div class="form-group">
                <h3>Assortiment</h3>

                <?php foreach ($assortimenten as $a) : ?>
                  <div class="checkbox col-lg-6">
                    <label>
                      <input type="checkbox" name="assortiment[]" value="<?php echo $a['id']?>" <?php echo (isset($steunpunt_assortiment[$steunpunt['id']][$a['id']])) ? 'checked' : '' ?>><?php echo $a['type'] ?>
                    </label>
                  </div>
                <?php endforeach ?>
                
              </div>

              <!-- INFORMATIE -->
              <div class="form-group">   
                <h3>Informatie</h3>                   
                  <p class="form-control-static small">Toegevoegd op <?php echo nl_text_date($steunpunt['toegevoegd_op'])?> door <?php echo $steunpunt['toegevoegd_door']?></p>
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
        <li><a href="/steunpunten/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>