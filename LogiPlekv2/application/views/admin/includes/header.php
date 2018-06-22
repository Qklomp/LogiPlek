<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logiplek - <?php echo $title ?></title>

    <!--[if lt IE 9]>
    <script src="/js/hmtl5shiv.js"></script>
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.4">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="robots" content="noindex,nofollow">
    <meta charset="UTF-8">

    <!-- Bootstrap -->
    <link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/logiplek.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/distrivers.css" rel="stylesheet" media="screen">

    <!-- FAVS -->
    <link rel="icon" href="<?php echo asset_url() ?>img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo asset_url() ?>img/favicon.ico" type="image/x-icon"/>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
    <script>var base_url = '<?php echo base_url();?>';</script>
</head>
<body>

<!-- NAV -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand collapse-trigger" href="#" id="out"><i class="fa fa-angle-double-left"></i></a>
            <a class="navbar-brand" href="/dashboard/"><p>distrivers <span class="navbar-sub-brand">Logiplek</span></p>
            </a>
        </div>

        <div class="navbar-collapse collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/dashboard/"><i class="glyphicon glyphicon-th"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="fa fa-user"></i> <?php echo $voornaam; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/gebruiker/instellingen"><i class="fa fa-cog"></i> Instellingen</a></li>
                        <li><a href="/gebruiker/logout/"><i class="fa fa-power-off"></i> Uitloggen</a></li>
                    </ul>
                </li>
            </ul>
            <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                <div class="col-sm-4 col-md-3 navbar-right search-form">
                    <?php
                    $attributes = array('class' => 'navbar-form parsley');
                    echo form_open('/zoek', $attributes)
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Zoek" name="query" id="query" required
                               parsley-required>
                        <div class="input-group-btn">
                            <button class="btn btn-navbar" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            <?php endif; ?>
            <!-- END NAVBAR-COLLAPSE -->
        </div>
        <!-- END CONTAINER-FLUITD -->
    </div>
    <!-- END NAV -->
</div>

<!-- CONTAINER -->
<div class="container-fluid">

    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-sm-2 col-xs-1 sidebar">

            <ul class="nav nav-sidebar">

                <li <?php echo ($root === "Dashboard") ? 'class="active"' : '' ?>><a href="/dashboard/"><i
                                class="glyphicon glyphicon-th"></i><span class="nav-span">Dashboard</span></a></li>
                <hr>
                <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                    <li <?php echo ($root === "Brandstof") ? 'class="active"' : '' ?>><a href="/brandstof/"><i
                                    class="fa fa-tint"></i><span class="nav-span">Brandstof</span></a></li>
                    <!-- <li <?php echo ($root === "Onderhoud") ? 'class="active"' : '' ?>><a href="/onderhoud/"><i class="fa fa-wrench"></i><span class="nav-span">Onderhoud</span></a></li> -->
                    <!-- <li <?php echo ($root === "Planning") ? 'class="active"' : '' ?>><a href="#"><i class="fa fa-calendar-o"></i><span class="nav-span">Planning</span></a></li> -->
                    <li <?php echo ($root === "Ritregistratie") ? 'class="active"' : '' ?>><a href="/ritregistratie/"><i
                                    class="fa fa-list-alt"></i><span class="nav-span">Ritregistratie</span></a></li>
                    <li <?php echo ($root === "Emballage") ? 'class="active"' : '' ?>><a href="/emballage/"><i
                                    class="fa fa-road" aria-hidden="true"></i><span
                                    class="nav-span">Emballage</span></a></li>
              
                    <!-- Checks if user is admin-->
                    <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                        <hr>
                        <li <?php echo ($root === "Auto's") ? 'class="active"' : '' ?>><a href="/autos/"><i
                                        class="fa fa-truck"></i><span class="nav-span">Auto's</span></a></li>

                        <li <?php echo ($root === "Koeriers") ? 'class="active"' : '' ?>><a href="/koeriers/"><i
                                        class="fa fa-rocket"></i><span class="nav-span">Koeriers</span></a></li>
                        <li <?php echo ($root === "Personeel") ? 'class="active"' : '' ?>><a href="/personeel/"><i
                                        class="fa fa-users"></i><span class="nav-span">Personeel</span></a></li>
                        <li <?php echo ($root === "Routes") ? 'class="active"' : '' ?>><a href="/routes/"><i
                                        class="fa fa-road"></i><span class="nav-span">Routes</span></a></li>
                        <li <?php echo ($root === "Steunpunten") ? 'class="active"' : '' ?>><a href="/steunpunten/"><i
                                        class="glyphicon glyphicon-shopping-cart"></i><span
                                        class="nav-span">Steunpunten</span></a></li>

                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($this->session->userdata('functie_id') == 1 || $this->session->userdata('functie_id') == 2) : ?>
                    <li <?php echo ($root === "bericht") ? 'class="active"' : '' ?>><a href="/bericht"><i
                                    class="fa fa-inbox" aria-hidden="true"></i><span
                                    class="nav-span">Berichten (<?php echo count($this->bericht_model->get_ongelezen_berichten($this->session->userdata['id'])); ?>)</span></a></li>
                    <li <?php echo ($root === "emballage") ? 'class="active"' : '' ?>><a href="/emballage/toevoegen"><i
                                    class="fa fa-truck" aria-hidden="true"></i><span class="nav-span">Emballage registratie</span></a>
                    </li>
                <?php endif; ?>

                <?php if ($this->session->userdata('functie_id') == 4 || $this->session->userdata('functie_id') == 3) : ?>
                <hr>
                <li><a href="/bericht"><i class="fa fa-inbox"></i><span
                            class="nav-span">Berichten (<?php echo count($this->bericht_model->get_ongelezen_berichten($this->session->userdata['id']))?>)</span></a></li>
                <li><a href="http://webmail.distrivers.nl" target="_blank"><i class="fa fa-envelope"></i><span
                                class="nav-span">Webmail</span></a></li>
                <li><a href="http://www.gps-buddy.com/login" target="_blank"><i class="fa fa-crosshairs"></i><span
                                class="nav-span">GPS Buddy</span></a></li>
                <hr>
            </ul>
            <?php endif; ?>
            <!-- END SIDEBAR -->

        </div>

        <div class="col-sm-14 col-sm-offset-2 col-md-14 col-md-offset-2 col-lg-14 col-lg-offset-2 main">

            <noscript>
                <div class="text-center alert alert-danger">
                    <strong>Waarschuwing! </strong>
                    JavaScript is uitgeschakeld. Voor maximale gebruiksvriendelijkheid dient u JavaScript in te
                    schakelen.
                </div>
            </noscript>
              
          
         
