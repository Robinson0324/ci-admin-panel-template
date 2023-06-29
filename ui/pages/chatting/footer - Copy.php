<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>

<script type="text/javascript">
    $(document).ready(function(){
        /**
         * App body
         */
        var App = {
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
                $('#save').on('click',function(){
                    console.log('save clicked');
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
                console.log(response);
                App.showMessage(response.msg,3000);
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
</script>
