<ol class="breadcrumb" xmlns="http://www.w3.org/1999/html">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li><a href="/emballage"> Emballage </a></li>
    <li class="active"> Retour Toevoegen</li>
</ol>

<?php echo (isset($toegevoegd)) ? '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn toegevoegd!</div>' : '' ?>
<?php echo (isset($aangepast)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn aangepast!</div>' : '' ?>
<?php echo (isset($verwijderd)) ? '<div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">×</button>De gegevens zijn verwijderd!</div>' : '' ?>

<?php
$attributes = array('class' => 'form-horizontal parsley');
echo form_open('emballage_retour/aanpassen', $attributes)
?>


<div class="panel panel-default">

    <div class="modal fade" id="deleteAlert" tabindex="-1" role="dialog" aria-labelledby="deleteAlert"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <p>Weet je zeker dat je deze emballage soort wilt verwijderen? </p>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
                    <a href="" id="delete" type="button" class="btn btn-danger">Verwijderen</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <ul class="list-inline">
            <li><h2><?php echo $title ?> beheren</h2></li>
        </ul>
    </div>
    <br>
    <fieldset>
        <div class="col-lg-12">
            <div>
                <?php foreach ($emballage_retour as $emballage): ?>
                    <div class="col-lg-4">
                        <div class="input-group input-group-sm">
                            <input type="hidden" class="form-control" name="emballage[id][]" value="<?php echo $emballage['id'] ?>">
                            <input type="text" class="form-control" name="emballage[emballage][]" value="<?php echo $emballage['emballage'] ?>">
                            <span class="input-group-addon">
                      <a href="" class="open-deleteAlert" data-id="<?php echo $emballage['id']?>" data-type="emballage_retour" data-toggle="modal" data-target="#deleteAlert"><i class="glyphicon glyphicon-trash"></i></a>
                    </span>
                        </div>
                    </div>
                <?php endforeach ?>
                <div id="emballage_mee_append">
                    <div class="col-lg-4" id="emballage_mee">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="emballage[emballage][]" value="">
                            <span class="input-group-addon">
                    <i class="glyphicon glyphicon-tag"></i>
                  </span>
                        </div>
                    </div>
                </div>
                <a href="#" class="pull-right btn btn-link btn-xs clone_it" data-target="emballage_mee"><i
                            class="glyphicon glyphicon-plus"></i> Voeg nog een type toe</a>
            </div>
            <div class="form-group text-center col-lg-12">
                <legend></legend>
                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Aanpassen</button>
            </div>
    </fieldset>
    </form>
    <div class="panel-footer">
        <ul class="list-inline">
            <li><a href="/emballage/" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-arrow-left"></i> Terug</a></li>
        </ul>
    </div>
</div>
