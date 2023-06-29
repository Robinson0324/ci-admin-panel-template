<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>

<script type="text/javascript">
    var App;
    $(document).ready(function(){
        /**
         * App body
         */
        App = {
            dataUrl : "main/ajax_call",
            user: {
                user_email: '',
                old_pass: '',
                new_pass: ''
            },
            params: null,
            initialize: function(){
                this.bindEvents();
                this.user.email = $('#user_email').val();
            },
            bindEvents:function(){
                $('#btn-change-password').on('click',function(){
                    console.log('change password clicked');
                    if(App.validPassword()){
                        App.params = {
                            action:'change_password',
                            data: App.user
                        };
                        App.ajaxCall(App.params);
                    }
                })
                //message hide
                $('#error').on('click',function(){
                    $(this).hide();
                })

                $('#btn-save-profile').on('click',function(){
                    console.log('save clicked');
                    App.params = {
                        action : "save_profile",
                        data : {
                            username : $('#username').val(),
                            email: $('#email').val(),
                            first: $('#firstname').val(),
                            last: $('#lastname').val(),
                            dashaddress : $('#dashaddress').val(),
                        },
                    };
                    App.ajaxCall(App.params);
                })

                $('.uploadavatar').on('change', function(event){
                    files = event.target.files;
                    if(files.length > 0 ){

                        var formData = new FormData();
                        formData.append("file", files[0]);

                        var xhttp = new XMLHttpRequest();

                        // Set POST method and ajax file path
                        xhttp.open("POST", "../api/upload.php", true);

                        // call on request changes state
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {

                                var response = this.responseText;
                                App.params = {
                                    action : "update_avatar",
                                    data : {
                                        email: $('#user_email').val(),
                                        avatar: response,
                                    },
                                };
                                App.ajaxCall(App.params);
                            }
                        };

                        // Send request with data
                        xhttp.send(formData);

                    }else{
                        alert("Please select a file");
                    }
                });
            },
            validPassword:function (){
                //password length 8 more check
                this.user.user_email = $('#user_email').val();
                this.user.old_pass = $('#user_pass_old').val();
                this.user.new_pass = $('#user_pass_new').val();
                var confirm_pass = $('#user_pass_confirm').val();
                if(this.user.old_pass.length < 8){
                    $('#user_pass_old').focus();
                    this.showMessage('The length of the password must be at least 8 characters!',3000);
                    return false;
                }
                if(this.user.new_pass.length < 8){
                    $('#user_pass_new').focus();
                    this.showMessage('The length of the password must be at least 8 characters!',3000);
                    return false;
                }
                //confirmation check
                if(this.user.new_pass != confirm_pass){
                    $('#user_pass_confirm').focus();
                    this.showMessage('Passwords do not match!',3000);
                    return false;
                }
                return true;
            },
            onSuccess: function(response){
                console.log('res success');
                if(response.msg == "Avatar updated successfully!"){
                    location.reload();
                    return;
                }
                console.log(response);
                App.showMessage(response.msg,3000);
                setTimeout(function(){location.reload()} , 3000);
            },
            onError: function(err){
                console.log('res err');
                console.log(err);
                App.showMessage('password change error!',0);
            },
            ajaxCall:function(params){
                $.ajax({
                    url: this.dataUrl,
                    type: "POST",
                    dataType: "json",
                    data: params,
                    success: App.onSuccess,
                    error: App.onError
                })
            },
            showMessage: function(msg,time){
                $('#error').stop(true).hide();
                if(time==0){
                    $('#error').empty().removeClass("hidden").fadeIn("fast").append(msg);
                }else{
                    $('#error').empty().removeClass("hidden").fadeIn("fast").append(msg).fadeOut(time,function(){
                        $('#error').addClass('hidden');
                    });
                }

            }
        };

        App.initialize();


    })
    function onRequestBudget(email){
        App.params = {
            action : "request_budget",
            data : {
                email: email,
            },
        };
        App.ajaxCall(App.params);
    }
</script>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-46172202-12');
  </script>

  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
  </script>