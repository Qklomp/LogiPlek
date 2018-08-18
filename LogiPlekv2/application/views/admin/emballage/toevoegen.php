<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
        <li><a href="/emballage"> Emballage </a></li>
        <li class="active"> toevoegen</li>
    <?php else: ?>
        <li class="active"> Emballage registreren</li>
    <?php endif; ?>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>

<div class="col-lg-8 col-lg-offset-2">
    <div class="panel panel-default">

        <div class="panel-heading">
            <ul class="list-inline">
                <li><h2><?php echo $title ?> registreren</h2></li>
            </ul>
        </div>

        <div class="panel-body">
            <?php
            $attributes = array('class' => 'form-horizontal parsley','id '=>'form', 'onsubmit' => 'submitFormFunction()' );
            echo form_open('emballage/toevoegen', $attributes)
            ?>

            <!-- emballage algemene informatie -->

            <div class="container-fluid" id="emballageInfo">
                <h3>Algemene informatie</h3>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">Vrachtwagen</div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <select class="form-control input-sm selectNoPaddingStart"  name="Vrachtwagen"
                                id="Vrachtwagen" required data-parsley-required data-trigger="change">
                            <option value="">Selecteer vrachtwagen</option>
                            <?php foreach ($autos as $v): ?>
                                <option value="<?php echo $v['kenteken'] ?>"
                                    <?php set_select('kenteken', $v['kenteken'], FALSE) ?>
                                    <?php if ($v['kenteken'] === $vrachtwagen[0]['kenteken']) {
                                        echo ' selected';
                                    } ?>>
                                    <?php echo $v['kenteken'] ?>
                                </option>
                            <?php endforeach ?>
                            <option value="999">Bus</option>
                            <option value="998">Vrachtwagen</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">Klantnummer</div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <input class="form-control input-sm" name="Klantnummer" id="Klantnummer" required data-parsley-required">
                    </div>
                </div>

                <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">Toegevoegd op</div>
                        <div class="input-group col-xs-12 col-sm-12 col-md-6" id="datepickerDiv">
                            <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input type="text" class="form-control input-sm datepicker" name="Toegevoegd_op" id="Toegevoegd_op"
                                   placeholder="Toegevoegd op" data-date-end-date="0d" value="<?php echo date("d-m-Y", NOW());?>">
                        </div>
                    </div>
                <?php else : ?>
                    <input type="text" class="form-control input-sm datepicker hidden" name="Toegevoegd_op" id="Toegevoegd_op"
                           placeholder="Toegevoegd op" data-date-end-date="0d" value="<?php echo date("d-m-Y", NOW());?>">
                <?php endif; ?>

                <div class="row">
                    <div class="mobileShow emballage-mobile-button" id="klantOmlaag" onclick="Toggle('klantOmlaag')">
                        <i class="fa fa-chevron-down"></i> Verder
                    </div>
                </div>
            </div>

            <!-- emballage mee invoeren -->

            <div class="container-fluid" id="emballageMee">
                <div class="row">
                    <h3 class="col-md-6">Emballage mee</h3>
                </div>

                <?php foreach ($emballage_mee as $emballage): ?>
                    <?php $tempName = str_replace(' ', '', $emballage["emballage"]) ?>
                    <div class="row">
                        <div class="col-md-6"> <?php echo $emballage["emballage"] ?></div>
                        <div class="col-md-6">
                            <input class="form-control input-sm" name="<?php echo $tempName ?>_mee"
                                   id="<?php echo $emballage["emballage"] ?>mee" 
                                   type="number" min="0" value="0">
                        </div>
                    </div>

                <?php endforeach ?>

                <div class="row">
                    <div class="mobileShow emballage-mobile-button" id="emballageMeeOmhoog"
                         onclick="Toggle('emballageMeeOmhoog')"><i class="fa fa-chevron-up"></i> Terug
                    </div>
                    <div class="mobileShow emballage-mobile-button" id="emballageMeeOmlaag"
                         onclick="Toggle('emballageMeeOmlaag')"><i class="fa fa-chevron-down"></i> Verder
                    </div>
                </div>
            </div>

            <!-- emballage retour invoeren -->

            <div class="container-fluid" id="emballageRetour">
                <div class="row">
                    <h3 class="col-md-6">Emballage retour</h3>
                </div>

                <?php foreach ($emballage_retour as $emballage): ?>
                    <?php $tempName = str_replace(' ', '', $emballage["emballage"]) ?>
                    <div class="row">
                        <div class="col-md-6"> <?php echo $emballage["emballage"] ?></div>
                        <div class="col-md-6">
                            <input class="form-control input-sm" name="<?php echo $tempName ?>_retour"
                                   id="<?php echo $emballage["emballage"] ?>retour" 
                                   type="number" min="0" value="0">
                        </div>
                    </div>

                <?php endforeach ?>

                <div class="row">
                    <div class="mobileShow emballage-mobile-button" id="emballageRetourOmhoog"
                         onclick="Toggle('emballageRetourOmhoog')"><i class="fa fa-chevron-up"></i> Terug
                    </div>
                    <div class="emballage-mobile-button" id="emballageRetourOmlaag"
                         onclick="Toggle('emballageRetourOmlaag')"><i class="fa fa-chevron-down"></i> Afronden
                    </div>
                </div>
            </div>

            <!-- emballage controle -->

            <div class="container-fluid" id="emballageControle">
                <div class="row">
                    <h3 class="col-md-6">Emballage controleren</h3>
                </div>

                <!-- Algemene emballage informatie controle -->
                <div class="row">
                    <h4 class="col-md-6">Algemene informatie</h4>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"><b class="small">Klantnummer:</b></div>
                    <div class="col-xs-6 col-sm-6 col-md-6"><p class="small" id="KlantnummerValue">...</p></div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"><b class="small">Kenteken:</b></div>
                    <div class="col-xs-6 col-sm-6 col-md-6"><p class="small" id="KentekenValue">...</p></div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6"><b class="small">Datum:</b></div>
                    <div class="col-xs-6 col-sm-6 col-md-6"><p class="small" id="DatumValue">...</p></div>
                </div>

                <!-- Emballage mee informatie controle -->
                <div class="row">
                    <h4 class="col-md-6">Emballage mee</h4>
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 75%;">Emballage</th><th>Aantal</th>
                    </tr>
                    </thead>
                    <tbody id="emballageMeeControleContainer">

                    </tbody>
                </table>

                <!-- Emballage retour informatie controle -->
                <div class="row">
                    <h4 class="col-md-6">Emballage retour</h4>
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 75%;">Emballage</th><th>Aantal</th>
                    </tr>
                    </thead>
                    <tbody id="emballageRetourControleContainer">

                    </tbody>
                </table>

                <div class="row" id="emballageControleWarning">
                    <div class="alert alert-warning">Er moet iets ingevuld worden bij emballage mee of retour!</div>
                </div>

                <div class="row">
                    <div class="emballage-mobile-button" id="emballageControleTerug"
                         onclick="Toggle('emballageControleTerug')"><i class="fa fa-chevron-up"></i> Terug
                    </div>
                </div>
                <div class="row text-center" id="verzendDiv">
                    <hr>
                    <div class="col-md-12">
                        <button type="submit" id="verzendButton" class="btn btn-primary">Verzenden</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>