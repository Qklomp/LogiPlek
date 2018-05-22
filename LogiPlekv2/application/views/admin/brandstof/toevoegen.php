<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/brandstof/">Brandstof</a></li>
  <li class="active">Toevoegen</li>
</ol>

<div class="panel panel-default table-responsive">

  <div class="panel-heading">
    <ul class="list-inline ">   
      <li><h2><?php echo $title ?></h2></li>   
    </ul>         
  </div>

  <div class="panel-body">
    <div class="col-lg-12"S>
      <?php 
        $attributes = array('class' => 'parsley');
        echo form_open('brandstof/toevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="table-responsive">
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

              <?php for($i=0;$i<10;$i++): ?>
                <tr>                
                  <td>
                    <input class="form-control input-sm datepicker" type="text" name="dagrapport[<?php echo $i ?>][datum]" value="<?php echo date('d-m-Y') ?>">
                  </td>
                  <td>
                    <select class="form-control input-sm autonummer" type="text" name="dagrapport[<?php echo $i ?>][autonummer]" value="">
                      <option <?php echo set_select('dagrapport[<?php echo $i ?>][autonummer]', '', TRUE); ?>></option>
                      <?php foreach($autos as $v): ?>
                        <option id="<?php echo $v['id'] ?>" data-target="beginstand<?php echo $i ?>" value="<?php echo $v['autonummer']?>" <?php set_select('dagrapport[' . $i . '][autonummer]', $v['autonummer'], FALSE)?>><?php echo $v['autonummer'] ?></option> 
                      <?php endforeach ?>
                    </select>
                  </td>
                  <td> 
                    <select class="form-control input-sm" name="dagrapport[<?php echo $i ?>][chauffeur]" >
                      <option <?php echo set_select('dagrapport[<?php echo $i ?>][chauffeur]', '', TRUE); ?>></option>
                      <?php foreach ($personeel as $v): ?>
                        <option value="<?php echo $v['voornaam'] . ' ' . $v['achternaam']?>" <?php set_select('dagrapport[' . $i . '][chauffeur]', $v['voornaam'] . ' ' . $v['achternaam'], FALSE)?>><?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?></option>
                      <?php endforeach ?>
                    </select>             
                  </td>
                  <td>        
                    <input class="form-control input-sm verbruik" id="beginstand<?php echo $i?>" data-id="<?php echo $i?>" type="text" name="dagrapport[<?php echo $i ?>][beginstand]" value="" >
                  </td>
                  <td>
                    <input class="form-control input-sm verbruik" id="eindstand<?php echo $i?>" data-id="<?php echo $i?>" type="text" name="dagrapport[<?php echo $i ?>][eindstand]" value="">
                  </td>
                  <td>
                    <input class="form-control input-sm verbruik" id="liters<?php echo $i?>" data-id="<?php echo $i?>" type="text" name="dagrapport[<?php echo $i ?>][liters]" value="">
                  </td>
                  <td>
                    <input class="form-control input-sm" id="verbruik<?php echo $i?>" type="text" name="dagrapport[<?php echo $i ?>][verbruik]" value="">
                  </td>
                  <td>
                    <input class="form-control input-sm" type="text" name="dagrapport[<?php echo $i ?>][koeling]" value="">
                  </td>
                  <td>
                    <input class="form-control input-sm" type="text" name="dagrapport[<?php echo $i ?>][adblue]" value="">
                  </td>
                </tr>   
              <?php endfor ?>

              </tbody>
            </table>
          </div>

          <div class="form-group text-center">
            <legend></legend>      
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen</button>  
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
                  