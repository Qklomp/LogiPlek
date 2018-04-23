<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li><a href="/ritregistratie/standaardritten">Standaard ritten</a></li>
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
        echo form_open('ritregistratie/standaardritten/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="col-lg-12">  

            <div class="col-lg-8 col-lg-offset-2">
            
              <div class="form-group"> 

                <div class="col-lg-8 has-feedback <?php echo (form_error('participant') !== '') ? 'has-error' : '' ?>">
                  <label for="participant" class="control-label">Participant <span class="text-danger">*</span></label>
                  <select class="form-control input-sm" name="participant" required data-parsley-required>
                    <option <?php echo set_select('participant', '', TRUE); ?>></option>
                    <?php foreach ($participanten as $p): ?>
                      <option value="<?php echo $p['id'] ?>" <?php echo set_select('participant', $p['id'], FALSE) ?>><?php echo $p['participant'] ?></option>
                    <?php endforeach ?>
                  </select>  
                </div>

                <div class="col-lg-4 has-feedback <?php echo (form_error('kosten') !== '') ? 'has-error' : '' ?>">
                  <label for="kosten" class="control-label">Kosten <span class="text-danger">*</span></label>
                  <div class="input-group">         
                    <span class="input-group-addon input-sm">€</span>
                    <input type="text" class="form-control input-sm decimal" name="kosten" placeholder="Kosten" value="<?php echo set_value('kosten'); ?>" required data-parsley-required>
                  </div> 
                </div>   

                <div class="col-lg-12 has-feedback <?php echo (form_error('omschrijving') !== '') ? 'has-error' : '' ?>">
                  <label for="omschrijving" class="control-label">Omschrijving <span class="text-danger">*</span></label>     
                  <textarea type="text" rows="3" class="form-control input-sm" name="omschrijving" placeholder="Omschrijving" value="<?php echo set_value('omschrijving'); ?>" required data-parsley-required></textarea>
                </div>       

                <div class="col-lg-4 col-lg-offset-1 has-feedback <?php echo (form_error('intern') !== '') ? 'has-error' : '' ?>">
                  <label for="intern" class="control-label">Intern </label>
                  <select class="form-control input-sm" name="intern">
                    <option<?php echo set_select('intern', '', TRUE); ?>></option>
                    <?php foreach ($intern as $v): ?>
                      <option value="<?php echo $v['naam'] ?>" <?php echo set_select('intern', $v['naam'], FALSE) ?>><?php echo $v['naam'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>   
                <div class="col-lg-2 text-center">
                  <h3>Of</h3>
                </div>
                <div class="col-lg-4 has-feedback <?php echo (form_error('extern') !== '') ? 'has-error' : '' ?>">
                  <label for="extern" class="control-label">Extern </label>
                  <select class="form-control input-sm" name="extern">
                    <option<?php echo set_select('extern', '', TRUE); ?>></option>
                    <?php foreach ($extern as $v): ?>
                      <option value="<?php echo $v['naam'] ?>" <?php echo set_select('extern', $v['naam'], FALSE) ?>><?php echo $v['naam'] ?></option>
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
          <li><a href="/ritregistratie/standaardritten" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
        </ul>
      </div>
  </div>
</div>