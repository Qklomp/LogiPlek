<ol class="breadcrumb">
  <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
  <li><a href="/ritregistratie/">Ritregistratie</a></li>
  <li>Intern</li>
  <li class="active">Snel toevoegen</li>
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
        echo form_open('ritregistratie/intern/sneltoevoegen', $attributes) 
      ?>

        <fieldset> 
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed inputTable">
              <thead> 
                  <tr>
                    <th>Datum <span class="text-danger">*</span></th>
                    <th>Route <span class="text-danger">*</span></th>
                    <th>Ophaalpunt <span class="text-danger">*</span></th>
                    <th>Participant <span class="text-danger">*</span></th>
                    <th>Kosten</th>
                  </tr>
              </thead>
              <tbody>

              <?php for($i=0;$i<10;$i++): ?>               
                <tr>                
                  <td>
                    <input class="form-control input-sm datepicker" type="text" name="rit[<?php echo $i ?>][datum]" value="<?php echo date('d-m-Y') ?>">
                  </td>
                  <td> 
                    <select class="form-control input-sm" name="rit[<?php echo $i ?>][route]" >

                      <option <?php echo set_select('rit[<?php echo $i ?>][route]', '', TRUE); ?>></option>

                      <?php foreach ($routes as $v): ?>
                        <option 
                          value="<?php echo $v['routenummer']?>" 
                          <?php set_select('rit[' . $i . '][route]', $v['routenummer'], FALSE)?>
                        >
                          <?php echo $v['routenummer'] ?>
                        </option>
                      <?php endforeach ?>

                    </select>             
                  </td>
                  <td>
                    <select class="form-control input-sm ophaalpunt" name="rit[<?php echo $i ?>][ophaalpunt]">

                      <option <?php echo set_select('rit[<?php echo $i ?>][ophaalpunt]', '', TRUE); ?>></option>

                      <?php foreach($ophaalpunten as $o): ?>
                        <?php if ($o['active']): ?>
                          <option 
                            id="<?php echo $o['id'] ?>" 
                            data-target="kosten<?php echo $i ?>" 
                            value="<?php echo $o['ophaalpunt']?>" 
                            <?php set_select('rit[' . $i . '][ophaalpunt]', $o['ophaalpunt'], FALSE)?>
                          >
                            <?php echo $o['ophaalpunt'] ?>
                          </option> 
                        <?php endif ?>
                      <?php endforeach ?>

                    </select>
                  </td>
                  <td>
                    <select class="form-control input-sm" name="rit[<?php echo $i ?>][participant]">

                      <option <?php echo set_select('rit[<?php echo $i ?>][participant]', '', TRUE); ?>></option>

                      <?php foreach($participanten as $p): ?>
                        <?php if ($p['active']): ?>
                          <option 
                            id="<?php echo $p['id'] ?>" 
                            value="<?php echo $p['id']?>" 
                            <?php set_select('rit[' . $i . '][participant]', $p['id'], FALSE)?>
                          >
                            <?php echo $p['participant'] ?>
                          </option> 
                        <?php endif ?>
                      <?php endforeach ?>

                    </select>
                  </td>
                  <td>        
                    <input class="form-control input-sm kosten" id="kosten<?php echo $i?>" data-id="<?php echo $i?>" type="text" name="rit[<?php echo $i ?>][kosten]" value="">
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
      <li><a href="/ritregistratie/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
    </ul>
  </div>
</div>
                  