<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Logination| A Free open source User Management System | Free Login signup system.</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('web-assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('web-assets/css/sb-admin.css'); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url('web-assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via  -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <div id="page-wrapper">

            <div class="container-fluid">
                <?php
                if ($user_info) {
                    ?>
                    <a href="<?php echo base_url('profile'); ?>">My account</a> | <a href="<?php echo base_url('logout'); ?>">Logout</a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo base_url('register'); ?>">Register</a> | <a href="<?php echo base_url('login'); ?>">Login</a>
                    <?php                    
                }