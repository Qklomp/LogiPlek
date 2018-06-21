<ol class="breadcrumb" xmlns="http://www.w3.org/1999/html">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <?php if ($this->session->userdata('functie_id') == 0 || $this->session->userdata('functie_id') == 3) : ?>
        <li><a href="/emballage"> Emballage </a></li>
        <li><a href="/emballage/toevoegen">Toevoegen</a></li>
        <li class="active"> Controleren</li>
    <?php else: ?>
        <li class="active"> Emballage registreren</li>
    <?php endif; ?>
</ol>
<?php
$attributes = array('class' => 'form-horizontal parsley', 'id ' => 'form', 'onsubmit' => 'maak_vrachtwagen_cookie(' . ($this->session->userdata('functie_id')) . ')', 'onload' => 'MakeCookie');
echo form_open('emballage/toevoegen', $attributes)
?>
<form class="panel panel-default">

    <div class="panel-heading">
        <ul class="list-inline">
            <li><h2><?php echo $title ?> controleren</h2></li>
        </ul>
    </div>
    <br>
    <div class="container">
        <h3>Gegevens</h3>
        <div class="row">
            <div class="col-md-12">
                <label class="col-md-3">Klantnummer</label>
                <label class="col-md-3"><strong><?php echo $this->input->post('Klantnummer') ?></strong></label>
                <input type="hidden" name="Klantnummer" value="<?php echo $this->input->post('Klantnummer') ?>">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="col-md-3">Kenteken</label>
                <label class="col-md-3"><strong><?php echo $this->input->post('Vrachtwagen') ?></strong></label>
                <input type="hidden" name="Vrachtwagen" value="<?php echo $this->input->post('Vrachtwagen') ?>">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="col-md-3">Toegevoegd op</label>
                <label class="col-md-3"><strong><?php echo $this->input->post('Toegevoegd_op') ?></strong></label>
                <input type="hidden" name="Toegevoegd_op" value="<?php echo $this->input->post('Toegevoegd_op') ?>">
            </div>

        </div>

    </div>
    <div class="container">

        <div class="row">
            <?php $counter = 0; ?>
            <?php foreach ($this->input->post(null, true) as $key => $value) : ?>
                <?php if ($value != '0' && ($key != 'Vrachtwagen' && $key != 'Klantnummer')): ?>

                    <?php $dbKey = explode("_", $key); ?>
                    <?php if ($dbKey[1] === "mee") : ?>
                        <?php if ($counter === 0): ?>
                            <div class="container">
                                <h3>Emballage mee</h3>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <label class="col-md-3"><?php echo $dbKey[0] ?> </label>
                            <label class="col-md-3"><strong><?php echo $value ?></strong></label>
                            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
                            <br>
                            <?php $counter++ ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php $counter = 0; ?>
            <?php foreach ($this->input->post(null, true) as $key => $value) : ?>
                <?php if ($value != '0' && ($key != 'Vrachtwagen' && $key != 'Klantnummer')): ?>
                    <?php $dbKey = explode("_", $key); ?>
                    <?php if ($dbKey[1] === "retour") : ?>
                        <?php if ($counter === 0): ?>
                            <div class="container">
                                <h3>Emballage retour</h3>
                            </div>

                        <?php endif; ?>
                        <div class="col-md-12">
                            <label class="col-md-3"><?php echo $dbKey[0] ?></label>
                            <label class="col-md-3"><strong><?php echo $value ?></strong></label>
                            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
                            <br>
                            <?php $counter++; ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="col-md-1; btn btn-primary" id="ControleTerugButton" onclick=document.location.href=<?php base_url()?>"toevoegen">Terug</button>
            </div>

            <div class="col-md-6">
                <button type="submit" class="col-md-1; btn btn-primary" id="ControleVerzendButton">Verzenden</button>
            </div>
        </div>

    </div>
</form>

