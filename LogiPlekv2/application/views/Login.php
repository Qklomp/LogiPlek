<?php
/**
 * Created by PhpStorm.
 * User: Jeroen Hoegen
 * Date: 16-4-2018
 * Time: 09:45
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Logiplek</title>

    <!--[if lt IE 9]>
    <script src="/js/hmtl5shiv.js"></script>
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="robots" content="noindex,nofollow">
    <meta charset="UTF-8">

    <!-- Bootstrap -->
    <link href="<?php echo asset_url() ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/logiplek.css" rel="stylesheet" media="screen">
    <link href="<?php echo asset_url() ?>css/distrivers.css" rel="stylesheet" media="screen">

    <!-- FAVS -->
    <link rel="icon" href="<?php echo asset_url() ?>img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo asset_url() ?>img/favicon.ico" type="image/x-icon" />

</head>
<body>
<img src="<?php echo asset_url() ?>img/distr/header_1.jpg" id="bg" alt="">

<div class="container">

    <?php echo (isset($fout)) ? '<div class="alert alert-dismissable alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>Onjuist e-mailadres of wachtwoord!</div>' : '' ?>

    <?php
    echo validation_errors();
    $attrs = array('class' => 'form-signin');
    echo form_open('login/validate', $attrs);
    ?>

    <h2 class="form-signin-heading">Log in</h2>

    <?php
    $data = array(
        'class' => 'form-control',
        'placeholder' => 'E-mail',
        'name' => 'email'
    );
    echo form_input($data);

    $data = array(
        'class' => 'form-control',
        'placeholder' => 'Wachtwoord',
        'name' => 'wachtwoord'
    );
    echo form_password($data);

    $data = array(
        'class' => 'btn btn-lg btn-primary btn-block',
        'value' => 'Login',
        'name' => 'submit'
    );
    echo form_submit($data);
    ?>

</div>
<div id="footer">
    <span class="muted credit pull-right">&copy 2018 Jeroen Hoegen & Quincy Klomp</span>
</div>
</body>
</html>