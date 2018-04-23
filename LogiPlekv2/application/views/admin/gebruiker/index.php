<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a class="active"><?php echo $voornaam ?></a></li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>Het wachtwoord is aangepast!</div>' : '' ?>
<?php echo (isset($fout)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Er ging iets mis!</div>' : '' ?>

<div class="col-lg-4 col-lg-offset-4">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Instellingen</h2></li>
      </ul>    
    </div>

    <div class="panel-body">
      <?php 
        $attributes = array('class' => 'form-horizontal parsley');
        echo form_open('gebruiker/pw', $attributes) 
      ?>

        <fieldset> 

          <!-- WACHTWOORD -->
          <div class="form-group"> 
            <div class="has-feedback <?php echo (form_error('huidig') !== '') ? 'has-error' : '' ?>">
              <label for="huidig" class="control-label">Huidig wachtwoord <span class="text-danger">*</span></label>
              <input type="password" class="form-control input-sm" name="huidig" placeholder="Huidig wachtwoord" value="<?php echo set_value('huidig'); ?>" required data-parsley-required>
            </div>

            <div class="has-feedback <?php echo (form_error('nieuw') !== '') ? 'has-error' : '' ?>">
              <label for="nieuw" class="control-label">Nieuw wachtwoord <span class="text-danger">*</span></label>     
              <input type="password" class="form-control input-sm password" name="nieuw" placeholder="Nieuw wachtwoord" value="<?php echo set_value('nieuw'); ?>" required data-parsley-required>
            </div>
            
            <div class="has-feedback <?php echo (form_error('herhaal') !== '') ? 'has-error' : '' ?>">
              <label for="herhaal" class="control-label">Herhaal wachtwoord <span class="text-danger">*</span></label>     
              <input type="password" class="form-control input-sm" name="herhaal" placeholder="Herhaal wachtwoord" value="<?php echo set_value('herhaal'); ?>" required data-parsley-required>
            </div>            
                                       
          </div> 

          <div class="form-group text-center">
            <legend></legend>
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Opslaan</button>  
          </div>
        </fieldset>
      </form>
    </div>
    <div class="panel-footer">
      Je nieuwe wachtwoord is <span class="" id="verdict"></span>
    </div>
  </div>
</div>