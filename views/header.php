<!DOCTYPE html>
<html lang="th">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=TITLE_SYSTEM_NAME?></title>
        <!--        Favicon     -->
<!--        <link rel="shortcut icon" type="image/x-icon" href="<?= URL; ?>public/images/favicon.ico" />
        <link rel="shortcut icon" type="image/ico" href="<?= URL; ?>public/images/favicon.ico" />
        <link rel="icon" href="<?= URL; ?>public/images/favicon.ico" sizes="64x64"/>-->
        <link rel="apple-touch-icon" sizes="57x57" href="<?= URL; ?>public/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= URL; ?>public/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= URL; ?>public/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= URL; ?>public/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= URL; ?>public/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= URL; ?>public/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= URL; ?>public/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= URL; ?>public/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= URL; ?>public/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= URL; ?>public/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= URL; ?>public/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= URL; ?>public/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= URL; ?>public/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?= URL; ?>public/images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= URL; ?>public/images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <link href="<?= URL; ?>public/bootstrap-3.3.5/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?= URL; ?>public/bootstrap-dialog/css/bootstrap-dialog.css" />
        <!--<link rel="stylesheet" href="<?= URL; ?>public/bootstrap-table/css/bootstrap-table.css" type="text/css"/>-->
        <link rel="stylesheet" href="<?= URL; ?>public/bootstrap-select/css/bootstrap-select.css" type="text/css"/>
        <link rel="stylesheet" href="<?= URL; ?>public/bootstrap-fileinput/css/fileinput.css" type="text/css"/>
        <link rel="stylesheet" href="<?= URL; ?>public/bootstrap-checkbox-x/css/checkbox-x.css" type="text/css"/>
        <link rel="stylesheet" href="<?= URL; ?>public/bootstrap-switch/css/bootstrap3/bootstrap-switch.css" type="text/css"/>

        <link rel="stylesheet" href="<?= URL; ?>public/css/pagecss.css" type="text/css"/>

        <script src="<?= URL; ?>public/js/jquery-2.1.3.js" type="text/javascript"></script>
        <script src="<?= URL; ?>public/js/jquery.validate.min.js" type="text/javascript"></script>        
        <!--<script src="<?= URL; ?>public/js/jquery-validate.bootstrap-tooltip.min.js" type="text/javascript"></script>-->        
        <script src="<?= URL; ?>public/js/jquery.twbsPagination.js" type="text/javascript"></script>

        <script src="<?= URL; ?>public/bootstrap-3.3.5/dist/js/bootstrap.js" type="text/javascript"></script>

        <script src="<?= URL; ?>public/bootstrap-dialog/js/bootstrap-dialog.js"></script>
        <!--<script src="<?= URL; ?>public/bootstrap-table/js/bootstrap-table.js"></script>-->
        <script src="<?= URL; ?>public/bootstrap-select/js/bootstrap-select.js"></script>
        <script src="<?= URL; ?>public/bootstrap-fileinput/js/fileinput.js"></script>
        <script src="<?= URL; ?>public/bootstrap-checkbox-x/js/checkbox-x.js"></script>
        <script src="<?= URL; ?>public/bootstrap-switch/js/bootstrap-switch.js"></script>
        <script src="<?= URL; ?>public/js/bootstrap-session-timeout/dist/bootstrap-session-timeout.js"></script>


        <script src="<?= URL; ?>public/js/pagejscript.js"></script>
        <?php
        require 'pagescript.php';
        ?>
    </head>
    <body style="padding-top: 70px;">
        <?php Session::init(); ?>
