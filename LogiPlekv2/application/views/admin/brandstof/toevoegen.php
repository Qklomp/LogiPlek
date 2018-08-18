<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
        <li><a href="/brandstof"> Brandstof </a></li>
        <li class="active"> toevoegen</li>
    <?php else: ?>
        <li class="active"> Brandstof registreren</li>
    <?php endif; ?>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>

<div class="panel panel-default table-responsive">

    <div class="panel-heading">
        <ul class="list-inline ">
            <li><h2><?php echo $title ?></h2></li>
        </ul>
    </div>

    <div class="panel-body">
        <div class="col-lg-6 col-lg-offset-3">
            <?php
            $attributes = array('class' => 'parsley');
            echo form_open('brandstof/toevoegen', $attributes)
            ?>

            <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
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

                            <?php for ($i = 0; $i < 10; $i++): ?>
                                <tr>
                                    <td>
                                        <input class="form-control input-sm datepicker" type="text"
                                               name="dagrapport[<?php echo $i ?>][datum]"
                                               value="<?php echo date('d-m-Y') ?>">
                                    </td>
                                    <td>
                                        <select class="form-control input-sm autonummer" type="text"
                                                name="dagrapport[<?php echo $i ?>][autonummer]" value="">
                                            <option <?php echo set_select('dagrapport[<?php echo $i ?>][autonummer]', '', TRUE); ?>></option>
                                            <?php foreach ($autos as $v): ?>
                                                <option id="<?php echo $v['id'] ?>"
                                                        data-target="beginstand<?php echo $i ?>"
                                                        value="<?php echo $v['autonummer'] ?>" <?php set_select('dagrapport[' . $i . '][autonummer]', $v['autonummer'], FALSE) ?>><?php echo $v['autonummer'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control input-sm"
                                                name="dagrapport[<?php echo $i ?>][chauffeur]">
                                            <option <?php echo set_select('dagrapport[<?php echo $i ?>][chauffeur]', '', TRUE); ?>></option>
                                            <?php foreach ($personeel as $v): ?>
                                                <option value="<?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?>" <?php set_select('dagrapport[' . $i . '][chauffeur]', $v['voornaam'] . ' ' . $v['achternaam'], FALSE) ?>><?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm verbruik" id="beginstand<?php echo $i ?>"
                                               data-id="<?php echo $i ?>" type="text"
                                               name="dagrapport[<?php echo $i ?>][beginstand]" value="">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm verbruik" id="eindstand<?php echo $i ?>"
                                               data-id="<?php echo $i ?>" type="text"
                                               name="dagrapport[<?php echo $i ?>][eindstand]" value="">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm verbruik" id="liters<?php echo $i ?>"
                                               data-id="<?php echo $i ?>" type="text"
                                               name="dagrapport[<?php echo $i ?>][liters]" value="">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" id="verbruik<?php echo $i ?>" type="text"
                                               name="dagrapport[<?php echo $i ?>][verbruik]" value="">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="text"
                                               name="dagrapport[<?php echo $i ?>][koeling]" value="">
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" type="text"
                                               name="dagrapport[<?php echo $i ?>][adblue]" value="">
                                    </td>
                                </tr>
                            <?php endfor ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="form-group text-center">
                        <legend></legend>
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen
                        </button>
                    </div>
                </fieldset>
            <?php else : ?>
                <fieldset>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Datum</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm datepicker" type="text"
                                       name="dagrapport[0][datum]"
                                       value="<?php echo date('d-m-Y') ?>"
                                       required data-parsley-required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Kenteken</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <select class="form-control input-sm autonummer selectNoPaddingStart" type="text"
                                        name="dagrapport[0][autonummer]" value=""
                                        required data-parsley-required data-trigger="change">
                                    <option <?php echo set_select('dagrapport[0][autonummer]', '', TRUE); ?>></option>
                                    <?php foreach ($autos as $v): ?>
                                        <option id="<?php echo $v['id'] ?>" data-target="beginstand0"
                                                value="<?php echo $v['autonummer'] ?>"
                                            <?php set_select('dagrapport[0][autonummer]', $v['autonummer'], FALSE) ?>
                                            <?php if ($v['kenteken'] === $vrachtwagen[0]['kenteken']) {
                                                echo ' selected';
                                            } ?>>
                                            <?php echo $v['kenteken'] ?>
                                        </option>
                                    <?php endforeach ?>


                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Chauffeur</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <select class="form-control input-sm selectNoPaddingStart"
                                        name="dagrapport[0][chauffeur]"
                                        required data-parsley-required data-trigger="change">
                                    <option <?php echo set_select('dagrapport[0][chauffeur]', '', FALSE); ?>></option>
                                    <?php foreach ($personeel as $v): ?>
                                        <option value="<?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?>" <?php set_select('dagrapport[0][chauffeur]', $v['voornaam'] . ' ' . $v['achternaam'], FALSE) ?>
                                            <?php if ($v['voornaam'] . ' ' . $v['achternaam'] == $this->session->userdata('voornaam') . ' ' . $this->session->userdata('achternaam'))
                                                echo 'selected'; ?>
                                        ><?php echo $v['voornaam'] . ' ' . $v['achternaam'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Beginstand</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm verbruik" id="beginstand0"
                                       data-id="0" type="text"
                                       name="dagrapport[0][beginstand]" value=""
                                       required data-parsley-required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Eindstand</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm verbruik" id="eindstand0"
                                       data-id="0" type="text"
                                       name="dagrapport[0][eindstand]" value=""
                                       required data-parsley-required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Liters</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm verbruik" id="liters0"
                                       data-id="0" type="text"
                                       name="dagrapport[0][liters]" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Verbruik</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm" id="verbruik0" type="text"
                                       name="dagrapport[0][verbruik]" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Koeling</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm" type="text"
                                       name="dagrapport[0][koeling]" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">Adblue</div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <input class="form-control input-sm" type="text"
                                       name="dagrapport[0][adblue]" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <legend></legend>
                        <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Toevoegen
                        </button>
                    </div>
                </fieldset>
            <?php endif; ?>


            </form>
        </div>
    </div>
    <div class="panel-footer">
        <ul class="list-inline">
            <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                <li><a href="/brandstof/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i>
                        Terug</a></li>
            <?php endif; ?>


        </ul>
    </div>
</div>
                  