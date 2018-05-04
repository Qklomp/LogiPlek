<ol class="breadcrumb">
    <li><a href="" class="active"><i class="glyphicon glyphicon-home"></i> Logiplek</a></li>
</ol>

<div class="col-lg-4">

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3>Snelkoppelingen</h3>
        </div>

        <div class="panel-body">

            <div class="panel panel-warning panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/autos/"><h3><i class="fa fa-truck"></i> <?php echo count($autos) ?> auto's</h3></a></li>
                        <li><a href="/autos/toevoegen" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
                        <li><a href="/autos/printen" target="_blank" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-info panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/koeriers/"><h3><i class="fa fa-rocket"></i> <?php echo count($koeriers) ?> koeriers</h3></a></li>
                        <li><a href="/koeriers/toevoegen" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
                        <li><a href="/koeriers/printen" target="_blank" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-success panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/personeel/"><h3><i class="fa fa-users"></i> <?php echo count($personeel) ?> personeelsleden</h3></a></li>
                        <li><a href="/personeel/toevoegen" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
                        <li><a href="/personeel/printen" target="_blank" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-primary panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/routes/"><h3><i class="fa fa-road"></i> <?php echo count($routes) ?> routes</h3></a></li>
                        <li><a href="/routes/toevoegen" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
                        <li><a href="/routes/printen" target="_blank" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-danger panel-dash">
                <div class="panel-heading">
                    <ul class="list-inline">
                        <li><a href="/steunpunten/"><h3><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo count($steunpunten) ?> steunpunten</h3></a></li>
                        <li><a href="/steunpunten/toevoegen" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-plus"></i> Toevoegen</span></a></li>
                        <li><a href="/steunpunten/printen" target="_blank" class="btn btn-xs btn-link"><i class="glyphicon glyphicon-print"></i> Printen</span></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default col-lg-5 text-center">
                <div class="panel-body">
                    <a href="http://webmail.distrivers.nl" target="_blank"><h5><i class="glyphicon glyphicon-envelope"></i> Webmail</h5></a>
                </div>
            </div>

            <div class="panel panel-default col-lg-5 col-lg-offset-2 text-center">
                <div class="panel-body">
                    <a href="http://www.gps-buddy.com/login"><h5><i class="fa fa-crosshairs"></i> GPS Buddy</h5></a>
                </div>
            </div>
        </div>
        <div class="panel-footer">

        </div>
    </div>

</div>

<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Updates</h3>
        </div>
        <div class="panel-body">
            <?php foreach ($updates as $update): ?>
                <p><strong><?php echo nl_date($update['datum'])?> </strong> <?php echo $update['update'] ?></p>
                <hr>
            <?php endforeach ?>
        </div>
        <div class="panel-footer">
            <a href="/updates/">Bekijk alle updates</a>
        </div>
    </div>
</div>
