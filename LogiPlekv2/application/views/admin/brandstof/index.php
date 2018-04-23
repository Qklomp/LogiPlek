<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li class="active">Brandstof</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De dagrapporten zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>Het dagrapport is aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Het dagrapport is verwijderd!</div>' : '' ?>
<?php echo (isset($niet_gevonden)) ? '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>De opgevraagde gegevens zijn niet aanwezig</div>' : '' ?>

<div class="panel panel-default">

  <div class="panel-heading">
    <ul class="list-inline ">   
      <li><h2><?php echo $title ?></h2></li>
      <li><a href="/brandstof/toevoegen/" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Brandstof toevoegen</a></li>    
    </ul>         
  </div>

  <div class="panel-body">

    <!-- DELETE ALERT -->
    <div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p>Weet je zeker dat je deze invoer wilt verwijderen? </p>
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
          </div>
        </div>
      </div>
    </div>    
    
    <table class="table table-striped table-bordered table-hover table-condensed dateTable">
      <thead> 
        <tr>
          <th>Datum</th>
          <th>Autonummer</th>
          <th>Chauffeur</th>
          <th>Beginstand</th>
          <th>Eindstand</th>
          <th>Liters</th>
          <!--<th>Kilometers</th>-->
          <th>Verbruik</th>
          <th class="narrow text-center">Koeling</th>
          <th class="narrow text-center">Adblue</th>          
          <th class="narrow text-center"></th>
          <th class="narrow text-center"></th>
        </tr> 
      </thead>
      <tbody>

      </tbody>
    </table>
    
  </div>

  <div class="panel-footer">
    <?php 
        $attributes = array('class' => 'parsley col-lg-3');
        echo form_open('brandstof/wo', $attributes) 
      ?>
        <div class="input-group input-group-sm">             
          <input type="text" class="form-control" maxlength="4" name="weeknr" id="weeknr" Placeholder="Week" required data-parsley-required>  
          <span class="input-group-btn">       
            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Verbruik per week opvragen</button>        
          </span>   
        </div> 
      </form>

      <?php 
        $attributes = array('class' => 'parsley col-lg-9');
        echo form_open('brandstof/autooverzicht', $attributes) 
      ?>
        <div class="input-group input-group-sm">             
          <input type="text" class="form-control datepicker" maxlength="4" name="start" id="start" Placeholder="Start datum" required data-parsley-required>  

          <input type="text" class="form-control datepicker" maxlength="4" name="eind" id="eind" Placeholder="Eind datum" required data-parsley-required>  

          <select class="form-control" type="text" name="autonummer" id="autonummer">
            <option <?php echo set_select('autonummer', '', TRUE); ?>>Selecteer autonummer</option>
            <?php foreach($autos as $v): ?>
              <option value="<?php echo $v['autonummer']?>"
                <?php set_select('autonummer', $v['autonummer'], FALSE)?>>
                <?php echo $v['autonummer'] ?>
              </option> 
            <?php endforeach ?>
          </select>

          <span class="input-group-btn">       
            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i> Gemiddelde verbruik opvragen</button>
          </span>   
        </div> 
      </form>
    
      <div class="clearfix"></div>
    
    </div>
</div>