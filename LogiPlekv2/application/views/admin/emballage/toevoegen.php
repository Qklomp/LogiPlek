<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li class="active">Emballage/toevoegen/</li>
</ol>

<script src="<?php echo asset_url() ?>js/Klant.js"></script>
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

    <div class="container">


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
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- klantnummer invoeren -->


    <div class="container collapse" id="klantnummer">
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


    <div class="container collapse" id="emballageMee">
        <hr>
        <div class="row">
            <h3 class="col-md-6">Emballage mee</h3>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">Rolcontainer</div>
            <div class="col-md-6">
                <input class="form-control" name="Rolcontainer_Mee" id="RolcontainerMee" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Tussenrek</div>
            <div class="col-md-6">
                <input class="form-control" name="Tussenrek_Mee" id="TussenrekMee" onchange="Toggle()" type="number"
                       min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="Distrivers_Mee" id="DistriversMee" onchange="Toggle()" type="number"
                       min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Zuivelkrat</div>
            <div class="col-md-6">
                <input class="form-control" name="Zuivelkrat_Mee" id="ZuivelkratMee" onchange="Toggle()" type="number"
                       min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Box Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="BoxDistrivers_Mee" id="BoxDistriversMee" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Viskrat Almelo</div>
            <div class="col-md-6">
                <input class="form-control" name="ViskratAlmelo_Mee" id="ViskratMee" onchange="Toggle()" type="number"
                       min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">W en G</div>
            <div class="col-md-6">
                <input class="form-control" name="WenG_Mee" id="WenGMee" onchange="Toggle()" type="number" min="0"
                       value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Veilingfust / CBL Zwart</div>
            <div class="col-md-6">
                <input class="form-control" name="Veilingfust/CBLZwart_Mee" id="VeilingfustMee" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Colli achter voordeur</div>
            <div class="col-md-6">
                <input class="form-control" name="Colliachtervoordeur_Mee" id="ColliachterDeurMee" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Colli op afdeling</div>
            <div class="col-md-6">
                <input class="form-control" name="Colliopafdeling_Mee" id="ColliopAfdelingMee" onchange="Toggle()"
                       type="number" min="0" value="0">
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
                <input class="form-control" name="Rolcontainer_Retour" id="RolcontainerRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">Tussenrek</div>
            <div class="col-md-6">
                <input class="form-control" name="Tussenrek_Retour" id="TussenrekRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="Distrivers_Retour" id="DistriversRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Zuivelkrat</div>
            <div class="col-md-6">
                <input class="form-control" name="Zuivelkrat_Retour" id="ZuivelkratRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Box Distrivers</div>
            <div class="col-md-6">
                <input class="form-control" name="BoxDistrivers_Retour" id="BoxDistdriversRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Viskrat Almelo</div>
            <div class="col-md-6">
                <input class="form-control" name="ViskratAlmelo_Retour" id="ViskratRetour" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">W en G</div>
            <div class="col-md-6">
                <input class="form-control" name="WenG_Retour" id="WenGRetour" onchange="Toggle()" type="number" min="0"
                       value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Veilingfust / CBL Zwart</div>
            <div class="col-md-6">
                <input class="form-control" name="Veilingfust/CBLZwart_Retour" id="VeilingvustRetour"
                       onchange="Toggle()" type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld fles los €0.25</div>
            <div class="col-md-6">
                <input class="form-control" name="Statiegeldfleslos€0,25_Retour" id="StatiegeldFles0.25"
                       onchange="Toggle()" type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld fles los €010</div>
            <div class="col-md-6">
                <input class="form-control" name="Statiegeldfleslos€0,10_Retour" id="StatiegeldFles0.1"
                       onchange="Toggle()" type="number" min="0" value="0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">Statiegeld krat vol</div>
            <div class="col-md-6">
                <input class="form-control" name="Statiegeldkratvol_Retour" id="StatiegeldKratVol" onchange="Toggle()"
                       type="number" min="0" value="0">
            </div>
        </div>

    </div>

    <div class="container collapse" id="verzendButton">
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
