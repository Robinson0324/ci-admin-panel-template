<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $data['theme_url'];?>/assets/img/apple-icon.png">
  <!-- <link rel="icon" type="image/png" href="<?php echo $data['theme_url'];?>/assets/img/favicon.png">-->
  <title>
      <?php echo $data['title'];?>
  </title>

    <!--     Fonts and icons     -->
    <link href="<?php echo $data['theme_url'];?>/assets/css/all.css" rel="stylesheet">
    <link href="<?php echo $data['theme_url'];?>/assets/css/icon.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
    <!-- Nucleo Icons -->
    <link href="<?php echo $data['theme_url'];?>/assets/css/nucleo-icons.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link href="<?php echo $data['theme_url'];?>/assets/css/black-dashboard.min.css?v=1.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo $data['theme_url'];?>/assets/demo/demo.css" rel="stylesheet" />

<!--    <link rel="stylesheet" href="--><?php //echo $data['theme_url'];?><!--/assets/nc-demo_outline/demo/css/reset.css"> <!-- CSS reset -->
<!--    <link rel="stylesheet" href="--><?php //echo $data['theme_url'];?><!--/assets/nc-demo_outline/demo/css/style.css">-->
  <?php
    if(!empty($data['page'])){
        require_once FCPATH."/ui/pages/".$data['page']."/header.php";
    }
  ?>
</head>

<body class="sidebar-mini ">
  <div class="wrapper">