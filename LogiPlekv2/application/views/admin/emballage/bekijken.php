<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li><a href="/emballage/">emballage</a></li>
</ol>

<?php
$attributes = array('class' => 'form-horizontal parsley');
echo form_open('emballage/bewerken/'. $emballage['id'], $attributes)
?>

<div class="col-lg-8 col-lg-offset-2">
    <div class="panel panel-default">

        <div class="panel-heading">
            <ul class="list-inline">
                <li><h2><?php echo "Info" ?></h2></li>
            </ul>
        </div>
        <br>

        <div>
            <label>Klantnummer</label>
            <input type="number" class="form-control input-sm" name="klantnummer" placeholder="Klantnummer"
                   value="<?php echo $emballage['klantnummer'] ?>">
        </div>

        <div>
            <label>Vrachtwagen</label>
            <select class="form-control" onchange="Toggle()" type="text" name="Vrachtwagen"
                    id="Vrachtwagen" >
                <option <?php echo set_select('kenteken', '', FALSE); ?>>Selecteer vrachtwagen</option>
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

        <label for="Toegevoegd op" class="control-label">Toegevoegd op </label>
        <div class="input-group">
            <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
            <input type="text" class="form-control input-sm datepicker" name="Toegevoegd_op" placeholder="Toegevoegd op" value="<?php echo $emballage['toegevoegd_op']?>">
        </div>

        <h3>Emballage mee</h3>
        <?php $i = 0; ?>
        <?php for ($i = 0;
                   $i < count($emballage_mee);
                   $i++){ ?>
    <?php $inputState = false; ?>
        <div>
            <?php $tempName = str_replace('_', '', $emballage_mee[$i]['emballage']) ?>
            <?php $tempName = str_replace(' ', '', $tempName) ?>
            <label><?php echo $emballage_mee[$i]['emballage']; ?></label>
            <?php foreach ($emballage_emballagemee as $emballage_ASDASD): ?>
                <?php if ($emballage_mee[$i]['id'] === $emballage_ASDASD['emballagemee_id']): ?>
                    <input type="number" class="form-control input-sm"
                           name="<?php echo $tempName; ?>_mee"
                           placeholder="<?php echo $emballage_mee[$i]['emballage']; ?>"
                           value="<?php echo $emballage_ASDASD['aantal'] ?>">
                    <?php $inputState = true; ?>
                <?php endif ?>
            <?php endforeach ?>
            <?php if ($inputState === false): ?>
                <input type="number" class="form-control input-sm" name="<?php echo $tempName; ?>_mee"
                       placeholder="<?php echo $emballage_mee[$i]['emballage']; ?>" value="0">
            <?php endif; ?>
            <?php }; ?>
        </div>

        <h3>Emballage retour</h3>
        <?php $i = 0; ?>
        <?php for ($i = 0;
        $i < count($emballage_retour);
        $i++){ ?>
        <?php $inputState = false; ?>
        <div>
            <?php $tempName = str_replace('_', '', $emballage_retour[$i]['emballage']) ?>
            <?php $tempName = str_replace(' ', '', $tempName) ?>
            <label><?php echo $emballage_retour[$i]['emballage']; ?></label>
            <?php foreach ($emballage_emballageretour as $emballage_ASDASD): ?>
                <?php if ($emballage_retour[$i]['id'] === $emballage_ASDASD['emballageretour_id']): ?>
                    <input type="number" class="form-control input-sm"
                           name="<?php echo $tempName; ?>_retour"
                           placeholder="<?php echo $emballage_retour[$i]['emballage']; ?>"
                           value="<?php echo $emballage_ASDASD['aantal'] ?>">
                    <?php $inputState = true; ?>
                <?php endif ?>
            <?php endforeach ?>
            <?php if ($inputState === false): ?>
                <input type="number" class="form-control input-sm"
                       name="<?php echo $tempName; ?>_retour"
                       placeholder="<?php echo $emballage_retour[$i]['emballage']; ?>" value="0">
            <?php endif; ?>
            <?php }; ?>
        </div>
        <br>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>
        </div>
        </fieldset>
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

