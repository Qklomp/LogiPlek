
<script src="<?php echo asset_url() ?>js/Klant.js"></script>

<?php
$attributes = array('class' => 'form-horizontal parsley');
echo form_open('emballasge/toevoegen', $attributes)
?>
    <div class="container">
        <div class="row">
            <h1 lass="col-md-6">Emballage registratie</h1>
        </div>
    </div>
    <hr>
    <!-- Vrachtwagen kenteken selecteren -->

    <div class="container">

        <div class="row">
            <div class="col-md-6">Vrachtwagen</div>
            <div class="col-md-6">
                <div class="ui-select">
                    <div class="ui-btn ui-icon-carat-d ui-btn-icon-right ui-corner-all ui-shadow">
                        <select class="form-control" onchange="Toggle()" type="text" name="Vrachtwagen" id="Vrachtwagen">
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
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- klantnummer invoeren -->


    <div class="container collapse" id="klantnummer" >
        <hr>
        <div class="row">
            <div class="col-md-6">Klantnummer</div>
            <div class="col-md-6">
                <input onchange="Toggle()" class="form-control" name="Klantnummer" id="Klantnummer">
            </div>
        </div>
        <div class="row">
            <div id="txtHint"></div>
        </div>
    </div>



    <!-- emballage mee invoeren -->


    <div class="container collapse" id = "emballageMee">
        <hr>
        <div class="row">
            <h3 class="col-md-6">Emballage mee</h3>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">Rolcontainer</div>
            <div class="col-md-6">
                <input class="form-control" name="RolcontainerMee" id="RolcontainerMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Tussenrek</div>
            <div class="col-md-6">
                <input class="form-control" name="TussenrekMee" id="TussenrekMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="DistriversMee" id="DistriversMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Zuivelkrat</div>
            <div class="col-md-6">
                <input class="form-control" name="ZuivelkratMee" id="ZuivelkratMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Box Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="BoxDistriversMee" id="BoxDistriversMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Viskrat Almelo</div>
            <div class="col-md-6">
                <input class="form-control" name="ViskratMee" id="ViskratMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">W en G</div>
            <div class="col-md-6">
                <input class="form-control" name="WenGMee" id="WenGMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Veilingfust / CBL Zwart</div>
            <div class="col-md-6">
                <input class="form-control" name="VeilingfustMee" id="VeilingfustMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Colli achter voordeur</div>
            <div class="col-md-6">
                <input class="form-control" name="ColliachterDeurMee" id="ColliachterDeurMee" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Colli op afdeling</div>
            <div class="col-md-6">
                <input class="form-control" name="ColliopAfdelingMee" id="ColliopAfdelingMee" onchange="Toggle()">
            </div>
        </div>

    </div>


    <!-- emballage retour invoeren -->


    <div class="container collapse" id="emballageRetour">
        <hr>
        <div class="row">
            <h3 class="col-md-6">Emballage Retour</h3>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">Rolcontainer</div>
            <div class="col-md-6">
                <input class="form-control" name="RolcontainerRetour" id="RolcontainerRetour" onchange="Toggle()">
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">Tussenrek</div>
            <div class="col-md-6">
                <input class="form-control" name="TussenrekRetour" id="TussenrekRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="DistriversRetour" id="DistriversRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Zuivelkrat</div>
            <div class="col-md-6">
                <input class="form-control" name="ZuivelkratRetour" id="ZuivelkratRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Box Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="BoxDistdriversRetour" id="BoxDistdriversRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Viskrat Almelo</div>
            <div class="col-md-6">
                <input class="form-control" name="ViskratRetour" id="ViskratRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">W en G</div>
            <div class="col-md-6">
                <input class="form-control" name="WenGRetour" id="WenGRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Veilingfust / CBL Zwart</div>
            <div class="col-md-6">
                <input class="form-control" name="VeilingvustRetour" id="VeilingvustRetour" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld fles los €0.25</div>
            <div class="col-md-6">
                <input class="form-control" name="StatiegeldFles0.25" id="StatiegeldFles0.25" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld fles los €0.10</div>
            <div class="col-md-6">
                <input class="form-control" name="StatiegeldFles0.1" id="StatiegeldFles0.1" onchange="Toggle()">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld krat vol</div>
            <div class="col-md-6">
                <input class="form-control" name="StatiegeldKratVol" id="StatiegeldKratVol" onchange="Toggle()">
            </div>
        </div>

    </div>

    <div class="container collapse" id="verzendButton">
        <hr>

        <div class="row">

            <div class="col-md-12">
                <button class="btn"
                ">Verzenden</button>
            </div>
        </div>
    </div>


</form>
