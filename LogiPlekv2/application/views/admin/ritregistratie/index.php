<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Ritregistratie</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>
<?php echo (isset($niet_gevonden)) ? '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>De opgevraagde gegevens zijn niet aanwezig</div>' : '' ?>

<!-- EXTERNE RITTEN -->
<div class="col-lg-6">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Externe ritten</h2></li>
        <li><a href="/ritregistratie/extern/toevoegen" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> Toevoegen</a></li>
        <li><a href="/ritregistratie/extern/statistieken" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-stats"></i> Statistieken</a></li>
      </ul>    
    </div>

    <div class="panel-body"> 

      <!-- DELETE ALERT -->
      <div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <p>Weet je zeker dat je deze rit wilt verwijderen? </p>
              <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
              <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed" id="dataTable_extern">
          <thead> 
            <tr>
              <th>Referentienummer</th>
              <th>Datum</th>
              <th>Koerier/Steunpunt</th>
              <th class="narrow text-center"></th>
              <th class="narrow text-center"></th>
              <th class="narrow text-center"></th>
            </tr>
          </thead> 
          <tbody>    

          </tbody>
        </table>  
      </div>

      <legend></legend>   

      <!-- WEKELIJKSE KOSTEN AFDRUKKEN -->
      <div class="col-lg-7 has-feedback <?php echo (form_error('weeknummer') !== '') ? 'has-error' : '' ?>">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/wo/extern', $attributes) 
        ?>
          <h4>Wekelijkse kosten afdrukken</h4>  
          <div class="form-group">
            <input type="text" class="form-control input-sm col-lg-5" maxlength="4" name="weeknummer" Placeholder="Week" required data-parsley-required>
            <div class="input-group input-group-sm col-lg-5">  
              <select name="locatie" class="form-control">
                <option <?php echo set_select('locatie', 'Alles', TRUE); ?>>Alles</option>
                <?php foreach ($locaties as $l): ?>
                  <option value="<?php echo $l['locatie'] ?>" <?php echo set_select('locatie', $l['locatie'], FALSE) ?>><?php echo $l['locatie'] ?></option>
                <?php endforeach ?>
              </select>
              <span class="input-group-btn">          
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-print"></i> Druk af</button>
              </span>   
            </div>     
          </div>   
        </form>
      </div>

      <!-- FACTUUR ZOEKEN -->
      <div class="col-lg-5 has-feedback <?php echo (form_error('factuurnummer') !== '') ? 'has-error' : '' ?>">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/extern/fo', $attributes) 
        ?>  
          <h4>Zoek op factuurnummer</h4> 
          <div class="input-group input-group-sm">   
            <input type="text" class="form-control input-sm" name="factuurnummer" Placeholder="Factuurnummer" required data-parsley-required>
            <span class="input-group-btn">
              <button class="btn btn-xs btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>   
            </span>
          </div>                   
        </form>
      </div>

      <!-- WEKELIJKSE KOSTEN AFDRUKKEN -->
      <div class="col-lg-7">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/wo/extern', $attributes) 
        ?>
          <h4> </h4>
          <div class="form-group">
            <input type="hidden" class="form-control input-sm col-lg-5" maxlength="4" name="weeknummer" value="<?php echo $last_week ?>">
            <input type="hidden" class="form-control input-sm col-lg-5" maxlength="4" name="locatie" value="Alles">                    
            <button class="btn btn-default btn-sm" type="submit"><i class="glyphicon glyphicon-print"></i> Vorige week</button>      
          </div>   
        </form>
      </div>

      <!-- GEGEVENS PER KOERIER/STEUNPUNT ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/extern/koeriersoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per koerier of steunpunt</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('firmanaam') !== '') ? 'has-error' : '' ?>">
              <label for="firmanaam" class="control-label col-lg-2">Firmanaam</label>
              <div class="input-group input-group-sm col-lg-10">
                <select name="firmanaam" class="form-control" required data-parsley-required>
                  <option <?php echo set_select('firmanaam', '', TRUE); ?>></option>
                  <?php foreach ($vervoerder as $v): ?>
                    <option value="<?php echo $v['naam'] ?>" <?php echo set_select('firmanaam', $v['naam'], FALSE) ?>><?php echo $v['naam'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>  

      <!-- GEGEVENS PER PARTICIPANT ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/extern/participantoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per participant</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('participant') !== '') ? 'has-error' : '' ?>">
              <label for="participant" class="control-label col-lg-2">Participant</label>
              <div class="input-group input-group-sm col-lg-10">
                <select name="participant" class="form-control" required data-parsley-required>
                  <option <?php echo set_select('participant', '', TRUE); ?>></option>
                  <?php foreach ($participanten as $p): ?>
                    <option value="<?php echo $p['id'] ?>" <?php echo set_select('participant', $p['id'], FALSE) ?>><?php echo $p['participant'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>   

      <!-- GEGEVENS PER PARTICIPANT ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/extern/omschrijvingsoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per zoekterm</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('omschrijving') !== '') ? 'has-error' : '' ?>">
              <label for="omschrijving" class="control-label col-lg-2">Zoekterm</label>
              <div class="input-group input-group-sm col-lg-10">
                <input class="form-control" type="text" name="omschrijving" value="" placeholder="Zoekterm">
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>      
      
    </div>
  <!-- END PANEL -->
  </div>
  <!-- END NALEVERINGEN -->
</div>

<!-- INTERNE RITTEN -->
<div class="col-lg-6">
  <div class="panel panel-default">

    <div class="panel-heading">
      <ul class="list-inline">   
        <li><h2>Interne ritten</h2></li>
        <li><a href="/ritregistratie/intern/toevoegen" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> Toevoegen</a></li>
        <li><a href="/ritregistratie/intern/sneltoevoegen" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i> Snel toevoegen</a></li>
      </ul>    
    </div>

    <div class="panel-body"> 

      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed" id="dataTable_intern">
          <thead> 
            <tr>
              <th>Referentienummer</th>
              <th>Datum</th>
              <th>Chauffeur</th>
              <th class="narrow text-center"></th>
              <th class="narrow text-center"></th>
              <th class="narrow text-center"></th>
            </tr>
          </thead> 
          <tbody>    
            
          </tbody>
        </table>   
      </div>

      <legend></legend>

      <!-- WEKELIJKSE KOSTEN AFDRUKKEN -->
      <div class="col-lg-7 has-feedback <?php echo (form_error('weeknummer') !== '') ? 'has-error' : '' ?>">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/wo/intern', $attributes) 
        ?>
          <h4>Wekelijkse kosten afdrukken</h4>  
          <div class="form-group">
            <input type="text" class="form-control input-sm col-lg-5" maxlength="4" name="weeknummer" Placeholder="Week" required data-parsley-required>
            <div class="input-group input-group-sm col-lg-5">  
              <select name="locatie" class="form-control">
                <option <?php echo set_select('locatie', 'Alles', TRUE); ?>>Alles</option>
                <?php foreach ($locaties as $l): ?>
                  <option value="<?php echo $l['id'] ?>" <?php echo set_select('locatie', $l['id'], FALSE) ?>><?php echo $l['locatie'] ?></option>
                <?php endforeach ?>
              </select>
              <span class="input-group-btn">          
                <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-print"></i> Druk af</button>
              </span>   
            </div>     
          </div>   
        </form>
      </div>

      <div class="col-lg-7">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/wo/intern', $attributes) 
        ?>
          <h4> </h4>
          <div class="form-group">
            <input type="hidden" class="form-control input-sm col-lg-5" maxlength="4" name="weeknummer" value="<?php echo $last_week ?>">
            <input type="hidden" class="form-control input-sm col-lg-5" maxlength="4" name="locatie" value="Alles">                    
            <button class="btn btn-default btn-sm" type="submit"><i class="glyphicon glyphicon-print"></i> Vorige week</button>      
          </div>   
        </form>
      </div>

      <!-- GEGEVENS PER ROUTE ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/intern/routesoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per route</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('route') !== '') ? 'has-error' : '' ?>">
              <label for="route" class="control-label col-lg-2">Route</label>
              <div class="input-group input-group-sm col-lg-10">
                <select name="route" class="form-control" required data-parsley-required>
                  <option <?php echo set_select('route', '', TRUE); ?>></option>
                  <?php foreach ($routes as $route): ?>
                    <option value="<?php echo $route['routenummer'] ?>" <?php echo set_select('route', $route['routenummer'], FALSE) ?>><?php echo $route['routenummer'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>  

      <!-- GEGEVENS PER PARTICIPANT ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/intern/participantoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per participant</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('participant') !== '') ? 'has-error' : '' ?>">
              <label for="participant" class="control-label col-lg-2">Participant</label>
              <div class="input-group input-group-sm col-lg-10">
                <select name="participant" class="form-control" required data-parsley-required>
                  <option <?php echo set_select('participant', '', TRUE); ?>></option>
                  <?php foreach ($participanten as $p): ?>
                    <option value="<?php echo $p['id'] ?>" <?php echo set_select('participant', $p['id'], FALSE) ?>><?php echo $p['participant'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>

      <!-- GEGEVENS PER PARTICIPANT ZOEKEN -->    
      <div class="col-lg-12">
        <?php 
          $attributes = array('class' => 'form-inline parsley', 'target' => '_blank');
          echo form_open('ritregistratie/intern/omschrijvingsoverzicht', $attributes) 
        ?>  

          <h4>Gegevens per zoekterm</h4>
          <div class="form-group">
            <div class="has-feedback <?php echo (form_error('omschrijving') !== '') ? 'has-error' : '' ?>">
              <label for="omschrijving" class="control-label col-lg-2">Zoekterm</label>
              <div class="input-group input-group-sm col-lg-10">
                <input class="form-control" type="text" name="omschrijving" value="" placeholder="Zoekterm">
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_van') !== '') ? 'has-error' : '' ?>">
              <label for="datum_van" class="control-label col-lg-2">Van</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_van" placeholder="Van" value="<?php echo set_value('datum_van'); ?>" required data-parsley-required>
              </div>
            </div>

            <div class="has-feedback <?php echo (form_error('datum_tot') !== '') ? 'has-error' : '' ?>">
              <label for="datum_tot" class="control-label col-lg-2">Tot</label>
              <div class="input-group input-group-sm col-lg-10">         
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input type="text" class="form-control datepicker" name="datum_tot" placeholder="Tot" value="<?php echo set_value('datum_tot'); ?>" required data-parsley-required>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Zoek</button>
                </span>
              </div>
            </div>
          </div>
        </form> 
      </div>  

    <!-- END PANEL-BODY -->     
    </div>
  <!-- END PANEL -->
  </div>
<!-- END INTERNE RITTEN -->
</div>

<div class="col-lg-12">
  <!-- STANDAARD RITTEN -->
  <div class="col-lg-6">
    <div class="panel panel-default">

      <div class="panel-heading">
        <ul class="list-inline">   
          <li><h2>Wekelijkse ritten</h2></li>
          <li><a href="/ritregistratie/standaardritten" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Beheren</a></li>
        </ul>    
      </div>      
    </div>
  </div>

  <!-- PARTICIPANTEN -->
  <div class="col-lg-6">
    <div class="panel panel-default">

      <div class="panel-heading">
        <ul class="list-inline">   
          <li><h2>Participanten</h2></li>
          <li><a href="/ritregistratie/participanten" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Beheren</a></li>
        </ul>    
      </div>      
    </div>
  </div>

  <!-- OPHAALPUNTEN -->
  <div class="col-lg-6">
    <div class="panel panel-default">

      <div class="panel-heading">
        <ul class="list-inline">   
          <li><h2>Ophaalpunten</h2></li>
          <li><a href="/ritregistratie/ophaalpunten" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i> Beheren</a></li>
        </ul>    
      </div>      
    </div>
  </div>
</div>


        

