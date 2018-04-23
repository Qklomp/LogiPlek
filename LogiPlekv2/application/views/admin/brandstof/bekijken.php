<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/brandstof/">Brandstof</a></li>
  <li class="active"><?php echo $dagrapport['id']?></li>
</ol>

<div class="panel panel-default table-responsive">

  <div class="panel-heading">
    <ul class="list-inline ">   
      <li><h2><?php echo $title ?></h2></li>   
    </ul>         
  </div>

  <div class="panel-body">
    <div class="col-lg-12 table-responsive">
      <?php 
        $attributes = array('class' => 'parsley');
        echo form_open('brandstof/' . $dagrapport['id'], $attributes) 
      ?>

        <fieldset> 

          <table class="table table-striped table-bordered table-condensed inputTable">
            <thead> 
                <tr>
                  <th>Datum <span class="text-danger">*</span></th>
                  <th>Autonr. <span class="text-danger">*</span></th>
                  <th>Chauffeur <span class="text-danger">*</span></th>
                  <th>Beginstand <span class="text-danger">*</span></th>
                  <th>Eindstand</th>
                  <th>Liters</th>
                  <th>Verbruik</th>
                  <th>Koeling</th>
                  <th>Adblue</th>
                </tr>
            </thead>
            <tbody>
                           
              <tr>                
                <td>
                  <input class="form-control input-sm datepicker" type="text" name="datum" value="<?php echo nl_date($dagrapport['datum']) ?>">
                </td>
                <td>
                  <select class="form-control input-sm autonummer auto_verbruik" type="text" name="autonummer" value="">
                    <option<?php echo set_select('autonummer', '', FALSE); ?>></option>
                    <?php foreach ($autos as $v): ?>
                      <?php if($v['autonummer'] === $dagrapport['autonummer']): ?>
                        <option selected id="<?php echo $v['id'] ?>" data-target="beginstand" value="<?php echo $v['autonummer']?>" <?php set_select('autonummer', $v['autonummer'], TRUE)?>><?php echo $v['autonummer'] ?></option> 
                      <?php else: ?>
                        <option id="<?php echo $v['id'] ?>" data-target="beginstand" value="<?php echo $v['autonummer']?>" <?php set_select('autonummer', $v['autonummer'], FALSE)?>><?php echo $v['autonummer'] ?></option> 
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>
                </td>
                <td> 
                  <select class="form-control input-sm" name="chauffeur" >
                    <option<?php echo set_select('chauffeur', '', FALSE); ?>></option>
                    <?php foreach ($personeel as $v): ?>
                      <?php if( ($v['voornaam'] . ' ' . $v['achternaam']) === $dagrapport['chauffeur']): ?>
                        <option selected value="<?php echo $v['voornaam'] . ' ' . $v['achternaam']?>" <?php set_select('chauffeur', $v['voornaam'] . ' ' . $v['achternaam'], TRUE)?>><?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?></option>
                      <?php else: ?>
                        <option value="<?php echo $v['voornaam'] . ' ' . $v['achternaam']?>" <?php set_select('chauffeur', $v['voornaam'] . ' ' . $v['achternaam'], FALSE)?>><?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?></option>
                      <?php endif ?>
                    <?php endforeach ?>
                  </select>             
                </td>
                <td>        
                  <input class="form-control input-sm verbruik" id="beginstand" data-id="" type="text" name="beginstand" value="<?php echo $dagrapport['beginstand'] ?>">
                </td>
                <td>
                  <input class="form-control input-sm verbruik" id="eindstand" data-id="" type="text" name="eindstand" value="<?php echo $dagrapport['eindstand'] ?>">
                </td>
                <td>
                  <input class="form-control input-sm verbruik" id="liters" data-id="" type="text" name="liters" value="<?php echo $dagrapport['liters'] ?>">
                </td>
                <td>
                  <input class="form-control input-sm" id="verbruik" type="text" name="verbruik" value="<?php echo $dagrapport['verbruik'] ?>">
                </td>
                <td>
                  <input class="form-control input-sm" type="text" name="koeling" value="<?php echo $dagrapport['koeling'] ?>">
                </td>
                <td>
                  <input class="form-control input-sm" type="text" name="adblue" value="<?php echo $dagrapport['adblue'] ?>">
                </td>
              </tr>   

            </tbody>
          </table>
       
          <div class="form-group text-center">  
          <?php if(!empty($dagrapport['toegevoegd_door'])): ?>
            <h4>Informatie <small>Toegevoegd op <?php echo nl_text_date($dagrapport['toegevoegd_op'])?> door <?php echo $dagrapport['toegevoegd_door']?></small> </h4>                         
          <?php endif ?>             
            <legend></legend>             
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>  
          </div>
        </fieldset>
      </form>
    </div>
  </div>
  <div class="panel-footer">
    <ul class="list-inline">          
      <li><a href="/brandstof/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
    </ul>
  </div>
</div>
                  