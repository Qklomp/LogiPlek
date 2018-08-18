<ol class="breadcrumb">
    <li><a href="" class="active"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
</ol>

<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Vrachtwagen</h3>
        </div>
        <div class="panel-body">
            <select class="form-control input-sm" type="text" name="Vrachtwagen"
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
            <div class="text-center">
                <br>
                <button type="button"
                        id="VrachtwagenSubmit"
                        onclick="set_vrachtwagen()"
                        class="btn btn-sm btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Opslaan
                </button>
            </div>
        </div>
        <div class="panel-footer" id="selectFooter">

        </div>
    </div>
</div>

<div class="col-lg-4">

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3>Snelkoppelingen</h3>
        </div>

        <div class="panel-body">

            <div class="panel panel-warning panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/emballage/toevoegen"><h3><i class="fa fa-truck" aria-hidden="true"></i> Emballage
                                    registreren</h3></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-info panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/brandstof/toevoegen"><h3><i class="fa fa-tint" aria-hidden="true"></i> Brandstof
                                    registreren</h3></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-success panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/bericht/"><h3><i class="fa fa-inbox" aria-hidden="true"></i> Berichten</h3></a>
                        </li>
                        <br>
                        <li>
                            <?php
                            $temp = $this->bericht_model->get_ongelezen_berichten_aantal($this->session->userdata['id']);
                            $ongelezen_aantal = $temp['aantal'];

                            if ($ongelezen_aantal === '0') {
                                echo "U heeft geen nieuwe berichten";
                            } else if ($ongelezen_aantal === '1') {
                                echo "U heeft 1 ongelezen bericht";
                            } else {
                                echo "U heeft " . $ongelezen_aantal . " ongelezen berichten";
                            } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="panel-footer">

        </div>
    </div>
</div>

