<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan |
        <?php echo $title ?>
    </title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="vendor/apexcharts/apexcharts.css">
    <link rel="stylesheet" href="assets/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/DataTables/Buttons-1.5.6/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
        integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/<?php echo $css ?>">
    <?php if ($title != 'Dashboard') { ?>
        <link rel="stylesheet" href="css/style.css">
    <?php } ?>
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <style>
        #repbln .selectize-control {
            width: 125px !important;
        }
    </style>
</head>

<body>


    <?php
    error_reporting(E_ALL ^ E_DEPRECATED and E_NOTICE);
    ?>