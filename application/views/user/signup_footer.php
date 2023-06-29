<!--   Core JS Files   -->
<script src="<?php echo $theme_url;?>/assets/js/core/jquery.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/core/popper.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/core/bootstrap.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/sweetalert2.min.js"></script>
  <!--  Plugin for Sorting Tables -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery.tablesorter.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery.validate.min.js"></script>
  <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/bootstrap-datetimepicker.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/plugins/fullcalendar/daygrid.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/plugins/fullcalendar/timegrid.min.js"></script>
  <script src="<?php echo $theme_url;?>/assets/js/plugins/fullcalendar/interaction.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/nouislider.min.js"></script>

  <!-- Chart JS -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo $theme_url;?>/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo $theme_url;?>/assets/js/black-dashboard.min.js?v=1.1.1"></script>
  <!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo $theme_url;?>/assets/demo/demo.js"></script>
  <!-- Sharrre libray -->
  <script src="<?php echo $theme_url;?>/assets/demo/jquery.sharrre.js"></script>

 <!-- Forms Validations Plugin -->
 <script src="<?php echo $theme_url;?>/assets/js/plugins/jquery.validate.min.js"></script>
<script>
  
/**
 * App body
 */
var App = {
    dataUrl: "signup/ajax_call",
    initialize: function(){

    },
    bindEvents: function(){
    },
    register:function(){
        var params = {
            fullname: $('input[name="fullname"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            confirm_password: $('input[name="confirm_password"]').val()
        };
       
        if(!App.valid(params)) return;
        var data = {
                        action: 'register_user',
                        data:params
                    };
        //this.displayMessage('Login....',0);
        //App.showNotification('bottom','center','Login....',0);
        $.ajax({
            url: this.dataUrl,
            type: "POST",
            dataType: "json",
            data: data,
            success: function(res){
                console.log(res);
                //App.displayMessage("Please login.",3000);
                //App.showNotification('bottom','center',"Please login.",3000);
                if(res.data.status == 'success'){
                    App.showNotification('bottom','center',res.msg,3000);
                    window.location = "<?php echo site_url('index');?>";
                }
                else{
                    App.showNotification('bottom','center',res.msg,3000);
                }
            }
        })
    },
    valid:function (params){
        console.log(params)
        //password length 8 more check
        var fullname = params.fullname;
        var email = params.email;
        var pass = params.password;
        var confirm_pass = params.confirm_password;
        if(fullname == ""){
            App.showWarring('bottom','center','Please enter a Full Name.',3000);
            return false;
        }
        if(!App.IsEmail(email)){
            App.showWarring('bottom','center','Please enter a valid email address.',3000);
            return false;
        }
        
        if(pass.length < 6){
          
            App.showWarring('bottom','center','The length of the password is more than 6 characters.',3000);
            return false;
        }
        if(pass != confirm_pass){
          
          App.showWarring('bottom','center','Password and Confirm Password is not match.',3000);
          return false;
        }
        return true;
    }
    ,showNotification: function(from, align,msg,time) {
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
  ,showError: function(from, align,msg,time) {
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
  ,showWarring: function(from, align,msg,time) {
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
  ,IsEmail : function(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
  }
};

//Loading image show and search condition control
$(document).ajaxSend(function(event, request, settings) {
    $('#loading-indicator').show();
});
$(document).ajaxComplete(function(event, request, settings) {
    $('#loading-indicator').hide();
});
/**
 * App initialize
 */
App.initialize();

$('#signup-btn').on('click',function(){
    //event.preventDefault();
    App.register();
    return false;
})

</script>

</body>

</html>