<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li><a href="/emballage/">emballage</a></li>
    <li class="active">Emballage <?php echo $emballage['id'] ?></li>
</ol>

<div class="col-lg-8 col-lg-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="list-inline">
                <li><h2><?php echo "Info" ?></h2></li>
            </ul>
        </div>

        <div class="panel-body">
            <?php
            $attributes = array('class' => 'form-horizontal parsley');
            echo form_open('emballage/' . $emballage['id'], $attributes);
            ?>

            <fieldset>
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-8 col-xs-12">
                        <h3>Algemene informatie</h3>
                        <div>
                            <label for="Vrachtwagen" class="control-label">Vrachtwagen <span class="text-danger">*</span></label>
                            <select class="form-control input-sm" onchange="Toggle()" type="text" name="Vrachtwagen"
                                    id="Vrachtwagen">
                                <option <?php echo set_select('kenteken', '', FALSE); ?>>Selecteer vrachtwagen
                                </option>
                                <?php foreach ($autos as $r): ?>
                                    <?php if ($emballage['vrachtwagen'] === $r['kenteken']): ?>
                                        <option value="<?php echo $r['kenteken'] ?>" <?php echo set_select('auto', $r['id'], TRUE) ?>><?php echo $r['kenteken'] ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $r['kenteken'] ?>" <?php echo set_select('auto', $r['id'], FALSE) ?>><?php echo $r['kenteken'] ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <option value="999">Bus</option>
                                <option value="998">Vrachtwagen</option>
                            </select>
                        </div>

                        <div>
                            <label for="klantnummer" class="control-label">Klantnummer <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-sm" name="Klantnummer"
                                   placeholder="Klantnummer"
                                   value="<?php echo $emballage['klantnummer'] ?>">
                        </div>

                        <div>
                            <label for="Toegevoegd op" class="control-label">Toegevoegd op </label>
                            <div class="input-group">
                            <span class="input-group-addon input-sm"><i
                                        class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" class="form-control input-sm datepicker" name="Toegevoegd_op"
                                       placeholder="Toegevoegd op"
                                       value="<?php echo $emballage['toegevoegd_op'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-8">
                        <h3>Emballage mee</h3>

                        <?php foreach ($emballage_mee as $em): ?>
                            <?php $tempName = str_replace('_', '', $em['emballage']) ?>
                            <?php $tempName = str_replace(' ', '', $tempName) ?>

                            <div>
                                <label for="<?php echo $tempName; ?>_mee" class="control-label"><?php echo $em['emballage'] ?></label>
                                <input type="number" class="form-control input-sm"
                                       name="<?php echo $tempName; ?>_mee"
                                       value="<?php
                                       $bool = false;
                                       foreach ($emballage_emballagemee as $eem) {
                                           if ($eem['emballagemee_id'] === $em['id']) {
                                               $bool = true;
                                               echo $eem['aantal'];
                                           }
                                       }
                                       if (!$bool)
                                           echo '0';
                                       ?>"/>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-lg-5 col-md-5 col-md-offset-1 col-sm-8">
                        <h3>Emballage retour</h3>

                        <?php foreach ($emballage_retour as $er): ?>
                            <?php $tempName = str_replace('_', '', $er['emballage']) ?>
                            <?php $tempName = str_replace(' ', '', $tempName) ?>

                            <div>
                                <label for="<?php echo $tempName; ?>_retour" class="control-label"><?php echo $er['emballage'] ?></label>
                                <input type="number" class="form-control input-sm"
                                       name="<?php echo $tempName; ?>_retour"
                                       value="<?php
                                       $bool = false;
                                       foreach ($emballage_emballageretour as $eer) {
                                           if ($eer['emballageretour_id'] === $er['id']) {
                                               $bool = true;
                                               echo $eer['aantal'];
                                           }
                                       }
                                       if (!$bool) {
                                           echo '0';
                                       }
                                       ?>"/>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </fieldset>
            <br>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen
                </button>
            </div>
            </form>
        </div>
        <div class="panel-footer">
            <ul class="list-inline">
                <li><a href="/emballage/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i>
                        Terug</a></li>
            </ul>
        </div>
    </div>
</div>

