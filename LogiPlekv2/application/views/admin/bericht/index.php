<ol class="breadcrumb">
    <li><a href="/dashboard/"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
    <li class="active">Berichten</li>
</ol>

<div class="panel panel-default">

    <div class="panel-heading">
        <ul class="list-inline">
            <li><h2><?php echo $title ?></h2></li>
        </ul>
    </div>
    <?php print_r($contacten); ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3" style="min-height: 1000px">
                <ul class="nav nav-sidebar">
                    <?php foreach ($contacten as $key => $value): ?>
                        <li onclick="get_berichten(<?php  echo $id?>)"><?php echo $value?> </></li>
                        <hr>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-md-9" style="background-color: #70a426; min-height: 1000px">
            </div>
        </div>

    </div>
</div>
