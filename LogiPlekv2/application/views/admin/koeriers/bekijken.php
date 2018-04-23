<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/koeriers/">Koeriers</a></li>
  <li class="active"><?php echo $koerier['naam']?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2><?php echo $koerier['naam']?></h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('koeriers/' . $koerier['id'], $attributes) 
      ?>

        <fieldset> 
          <?php echo (isset($success)) ? '
            <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              De gegevens zijn aangepast!
            </div>' : '' ?>
          <div class="col-lg-12">  

            <!-- LEFT -->
            <div class="col-lg-5">

              <div class="form-group">
                <h3>Gegevens</h3>
                <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
                  <label for="firmanaam" class="control-label">Firmanaam <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="firmanaam" placeholder="Firmanaam" value="<?php echo $koerier['naam']?>" required data-parsley-required>
                </div>   
          
                <label for="telefoonnummer" class="control-label">Telefoonnummer</label>
                <input type="text" class="form-control input-sm telefoon" name="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo $koerier['nummer']?>">
                <p class="telefoon-error"></p>

                <label for="email" class="control-label">E-mail</label>
                <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $koerier['e-mail']?>" data-parsley-type="email">

                <div class="has-feedback <?php echo (form_error('omgeving') !== '') ? 'has-error' : '' ?>">
                  <label for="omgeving" class="control-label">Omgeving <span class="text-danger">*</span></label>
                  <input type="text" class="form-control input-sm" name="omgeving" placeholder="Omgeving" value="<?php echo $koerier['omgeving']?>" required data-parsley-required>
                </div>

                <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
                  <label for="kosten_km" class="control-label">Kosten per kilometer <span class="text-danger">*</span></label>
                  <div class="input-group">             
                    <span class="input-group-addon input-sm">€</span>
                    <input type="text" class="form-control input-sm decimal" name="kosten_km" placeholder="Kosten per kilometer" value="<?php echo $koerier['kosten_km']?>" required data-parsley-required>
                  </div>
                </div>
                
                <div class="has-feedback <?php echo (form_error('koeling') !== '') ? 'has-error' : '' ?>"> 
                  <label for="koeling" class="control-label">Koeling <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="koeling" required data-parsley-required>
                    <option <?php echo set_select('koeling', '', FALSE); ?>></option>
                    <option <?php echo ($koerier['koeling'] === 'Ja')  ? 'selected' : '' ?> >Ja</option>
                    <option <?php echo ($koerier['koeling'] === 'Nee') ? 'selected' : '' ?> >Nee</option>
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
                <?php if(empty($contacten)): ?>              
                  <label for="contact" class="control-label">Naam contact</label>
                  <input type="text" class="form-control input-sm" name="contact" placeholder="Contact" value="">     

                  <label for="mobiel" class="control-label">Mobiel</label>
                  <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value=""> 
                  <p class="telefoon-error"></p>      
                <?php else: ?>
                  <?php foreach($contacten as $contact): ?>                   
                    <label for="contact" class="control-label">Naam contact</label>
                    <input type="text" class="form-control input-sm" name="contact" placeholder="Contact" value="<?php echo $contact['contact'] ?>">            
             
                    <label for="mobiel" class="control-label">Mobiel</label>
                    <input type="text" class="form-control input-sm telefoon" name="mobiel" placeholder="Mobiel" value="<?php echo $contact['contact_nummer'] ?>">   
                    <p class="telefoon-error"></p>    
                  <?php endforeach ?>
                <?php endif ?>
              </div>

              <!-- INFORMATIE -->
              <div class="form-group">   
                <h3>Informatie</h3>       
                  <p class="form-control-static small">Toegevoegd op <?php echo nl_text_date($koerier['toegevoegd_op'])?> door <?php echo $koerier['toegevoegd_door']?></p>                          
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
    <!-- END PANEL-BODY -->
    </div>
    <div class="panel-footer">
      <ul class="list-inline">          
        <li><a href="/koeriers/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
      </ul>
    </div>
  </div>
</div>