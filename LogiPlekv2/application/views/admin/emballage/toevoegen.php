<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <?php if ($this->session->userdata('functie_id') == 0 || $this->session->userdata('functie_id') == 3) : ?>
        <li><a href="/emballage"> Emballage </a></li>
        <li class="active"> toevoegen</li>
    <?php else: ?>
        <li class="active"> Emballage registreren</li>
    <?php endif; ?>

</ol>

<script src="<?php echo asset_url() ?>js/logiplek/emballage/toevoegen.js"></script>
<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>

<?php
$attributes = array('class' => 'form-horizontal parsley');
echo form_open('emballage/toevoegen', $attributes)
?>
<div class="panel panel-default">

    <div class="panel-heading">
        <ul class="list-inline">
            <li><h2><?php echo $title ?> registreren</h2></li>
        </ul>
    </div>
    <br>

    <!-- Vrachtwagen kenteken selecteren -->

    <div class="container" id="vrachtwagen">


        <div class="row">
            <div class="col-md-6">Vrachtwagen</div>
            <div class="col-md-6">
                <div class="ui-select">
                    <div class="ui-btn ui-icon-carat-d ui-btn-icon-right ui-corner-all ui-shadow">
                        <select class="form-control" onchange="Toggle()" type="text" name="Vrachtwagen"
                                id="Vrachtwagen">
                            <option <?php echo set_select('kenteken', '', TRUE); ?>>Selecteer vrachtwagen</option>
                            <?php foreach ($autos as $v): ?>
                                <option value="<?php echo $v['kenteken'] ?>"
                                    <?php set_select('kenteken', $v['kenteken'], FALSE) ?>>
                                    <?php echo $v['kenteken'] ?>
                                </option>
                            <?php endforeach ?>
                            <option value="999">Bus</option>
                            <option value="998">Vrachtwagen</option>
                        </select>
                        <p id="errorVrachtwagen"></p>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- klantnummer invoeren -->


    <div class="container " id="klantnummer">

        <div class="row">
            <div class="col-md-6">Klantnummer</div>
            <div class="col-md-6">
                <input onchange="Toggle()" class="form-control" name="Klantnummer" id="Klantnummer">
            </div>
        </div>
        <p id="errorKlantnummer"></p>
    </div>
    <?php if ($this->session->userdata('functie_id') == 0 || $this->session->userdata('functie_id') == 3) : ?>
        <div class="container " id="Ingevoerd_op">
            <div class="row">
                <div class="col-md-6">Toegevoegd op</div>
                <div class="input-group col-md-6">
                    <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" class="form-control input-sm datepicker" name="Toegevoegd_op"
                           placeholder="Toegevoegd op" value="<?php $newDate = date("d-m-Y", NOW());
                    echo $newDate ?>">
                </div>
            </div>
        </div>
        <br>
    <?php endif; ?>
    <!--button -->
    <div class="container">
        <div class="row">
            <div class="mobileShow col-md-12" id="klantOmlaag" onclick="mobileToggle('klantOmlaag')"><i
                        class="fa fa-chevron-down"></i> Verder
            </div>
        </div>

    </div>


    <!-- emballage mee invoeren -->


    <div class="container" style="display: none;" id="emballageMee">
        <div class="row">
            <h3 class="col-md-6">Emballage mee</h3>
        </div>

        <br>
        <?php foreach ($emballage_mee as $emballage): ?>
            <?php $tempName = str_replace(' ', '', $emballage["emballage"]) ?>
            <div class="row">
                <div class="col-md-6"> <?php echo $emballage["emballage"] ?></div>
                <div class="col-md-6">
                    <input class="form-control" name="<?php echo $tempName ?>_mee"
                           id="<?php echo $emballage["emballage"] ?>mee" onchange="Toggle()"
                           type="number" min="0" value="0">
                </div>

            </div>

        <?php endforeach ?>

        <div class="container">
            <div class="row">
                <div class="mobileShow col-md-12" style="display: none;" id="emballageMeeOmhoog"
                     onclick="mobileToggle('emballageMeeOmhoog')"><i class="fa fa-chevron-up"></i> Terug
                </div>
                <div class="mobileShow col-md-12" style="display: none;" id="emballageMeeOmlaag"
                     onclick="mobileToggle('emballageMeeOmlaag')"><i class="fa fa-chevron-down"></i> Verder
                </div>
            </div>

        </div>
    </div>

    <!-- emballage retour invoeren -->


    <div class="container" style="display: none;" id="emballageRetour">
        <div class="row">
            <h3 class="col-md-6">Emballage Retour</h3>
        </div>

        <br>

        <?php foreach ($emballage_retour as $emballage): ?>
            <?php $tempName = str_replace(' ', '', $emballage["emballage"]) ?>
            <div class="row">
                <div class="col-md-6"> <?php echo $emballage["emballage"] ?></div>
                <div class="col-md-6">
                    <input class="form-control" name="<?php echo $tempName ?>_retour"
                           id="<?php echo $emballage["emballage"] ?>retour" onchange="Toggle()"
                           type="number" min="0" value="0">
                </div>
            </div>


        <?php endforeach ?>


        <div class="container">
            <div class="row">
                <div class="mobileShow col-md-12" style="display: none;" id="emballageRetourOmhoog"
                     onclick="mobileToggle('emballageRetourOmhoog')"><i class="fa fa-chevron-up"></i> Terug
                </div>
            </div>
        </div>


        <div class="container" style="display: none;" id="verzendButton">
            <hr>

            <div class="row">

                <div class="col-md-12">
                    <button class="btn">Verzenden</button>
                </div>
            </div>
        </div>


        </form>
        <br>
        <br>
    </div>
