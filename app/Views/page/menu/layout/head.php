<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>front/dashboard_new/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= base_url() ?>front/images/leapverse.png">
    <title>Leapverse Question Bank</title>

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>front/dashboard_new/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>front/dashboard_new/assets/css/argon-dashboard.css?v=2.0.4"
        rel="stylesheet" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard/assets/css/components.css">
    <link rel="stylesheet" href="<?= base_url() ?>front/dashboard_new/assets/css/style.css">

    <!-- data dataTables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css">
    <script src="<?= base_url(); ?>back/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>tinymce/tinymce.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- <link rel="stylesheet"
        href="<?php echo base_url(); ?>back/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->

    <!-- Full Calender -->
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>

    <style>
        .box {
            background: #314465;
            /* background: linear-gradient(90deg, rgba(255, 166, 0, 1) 0%, rgba(236, 255, 0, 1) 100%); */

            height: 50%;
        }

        div.dt-container.dt-empty-footer tbody>tr:last-child>* {
            border-bottom: 0 !important;
        }

        table.dataTable>thead>tr>th,
        table.dataTable>tbody>tr>th,
        table.dataTable>tbody>tr>td {
            text-align: center !important;
        }

        table.dataTable>.t-left>tr>td {
            text-align: left !important;
        }

        .custom-event {
            background-color: #28a745;
            /* Match booked day background */
            color: white;
            text-align: center;
            padding: 5px;
            font-weight: bold;
            font-size: 0.9rem;
            border-radius: 4px;
            width: 100%;
            height: 100%;
        }
    </style>

</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="position-absolute w-100 #86b4de box"></div>
    <aside
        class="sidenav bg-white shadow-leap navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-2 fixed-start ms-4  shadow-leap"
        id="sidenav-main">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <div class="sidenav-header d-block align-items-center mt-2 mb-2 text-center">
            <img src="<?= base_url() ?>front/images/leapverse.png" class="navbar-br and-img" alt="main_logo" width="40%"
                height="80%">
        </div>
        <!-- <hr class="horizontal dark mb-0 mt-0"> -->