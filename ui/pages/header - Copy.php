<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 4:35 PM
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($data['title'])){echo $data['title'];}?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $data['theme_url'];?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Docs CSS -->
    <link href="<?php echo $data['theme_url'];?>/css/docs.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo $data['theme_url'];?>/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo $data['theme_url'];?>/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $data['theme_url'];?>/css/custom-default.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $data['theme_url'];?>/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
    if(!empty($data['page'])){
        require_once FCPATH."/ui/pages/".$data['page']."/header.php";
    }

    ?>


</head>

<body>
<ul class='custom-menu' id="content_menu">
</ul>

<div id="wrapper">
