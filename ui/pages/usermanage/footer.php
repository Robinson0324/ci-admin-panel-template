<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 2:42 AM
 */

?>
<!-- -->
<script>
/**
 * App body
 */
var App = {
    dataUrl: "main/ajax_call",
    params: {
        action : 'get_user_list',
        data: {}
    },
    initialize: function(){
        this.getUserList();
    },
    bindEvents: function(){
        $('.delete').on('click',function(){
            var user_email = $(this).closest('tr').find('.email').text();
            console.log(user_email);
            var user = {
                user_email: user_email
            };
            App.deleteUser(user);
        })
        $('.agree').on('click',function(){
            var user_email = $(this).closest('tr').find('.email').text();
            console.log(user_email);
            var user = {
                user_email: user_email
            };
            App.allowUser(user);
        })
        $('.password-reset').on('click',function(){
            var user_email = $(this).closest('tr').find('.email').text();
            console.log(user_email);
            var user = {
                user_email: user_email
            };
            App.resetUserPassword(user);
        })
    },
    getUserList: function(){

        this.params.action = 'get_user_list';
        this.params.data = {};
        this.ajaxCall( this.params);
    },
    deleteUser: function(user){

        this.params.action = 'delete_user';
        this.params.data = user;

        this.ajaxCall( this.params);
    },
    allowUser: function(user){

        this.params.action = 'allow_user';
        this.params.data = user;

        this.ajaxCall( this.params);
    },
    addNewUser: function(user){
        this.params.action = 'add_new_user';
        this.params.data = user;
        console.log(this.params.data);
        this.ajaxCall( this.params);
    },
    resetUserPassword: function(user){
        this.params.action = 'reset_user_password';
        this.params.data = user;

        this.ajaxCall( this.params);
    },
    resetRequest: function(user){
        this.params.action = "reset_request";
        this.params.data = user;

        this.ajaxCall( this.params);
    },
    validPassword:function (){
        //password length 8 more check
        var new_pass = $('#user_pass_new').val();
        var confirm_pass = $('#user_pass_confirm').val();
        if(new_pass.length < 8){
            $('#user_pass_old').focus();
            this.showMessage('Password length must be 8 characters more ',3000);
            return false;
        }
        //confirmation check
        if(new_pass != confirm_pass){
            $('#user_pass_confirm').focus();
            this.showMessage('Confirm password not match!',3000);
            return false;
        }
        return true;
    },
    onSuccess: function(response){
        console.log(App.params);
        switch (App.params.action){
            case 'get_user_list':
//                console.log('get user list success');
//                console.log(response);
//                App.drawTable(response);
                break;
            case 'delete_user':
                console.log('deleted succcess');
                console.log(response);
                if(typeof response.msg !== "undefined"){
                    var msg = response.msg;
                    App.showMessage(msg,3000);
                    setTimeout(function(){location.reload()} , 3000);
                    if(typeof response.list !== "undefined"){

                        console.log("user list exist!");
                        var list = response.list;
                        App.drawTable(list);
                    }else{
                        console.log("user list no exist!");
                    }
                }else{
                    var msg = "Response message type is invalid";
                    App.showMessage(msg,3000);
                }
                break;
            case 'allow_user':
                console.log('user allowed succcess');
                console.log(response);
                if(typeof response.msg !== "undefined"){
                    var msg = response.msg;
                    App.showMessage(msg,3000);
                    if(typeof response.list !== "undefined"){

                        console.log("user list exist!");
                        var list = response.list;
                        App.drawTable(list);
                    }else{
                        console.log("user list no exist!");
                    }
                }else{
                    var msg = "Response message type is invalid";
                    App.showMessage(msg,3000);
                }
                break;
            case 'add_new_user':
                console.log('add new user succcess');
                console.log(response);
                if(typeof response.msg !== "undefined"){
                    var msg = response.msg;
                    App.showMessage(msg,3000);
                    setTimeout(function(){location.reload()} , 3000);
                    if(typeof response.list !== "undefined"){
                        var list = response.list;
                        App.drawTable(list);
                    }
                }else{
                    var msg = "Response message type is invalid";
                    App.showMessage(msg,3000);
                }
                break;
            case 'reset_user_password':
                console.log('reset password succcess');
                console.log(response);
                var msg = response.msg;
                App.showMessage(msg,3000);
                break;
            case 'reset_request':
                var msg = response.msg;
                App.showMessage(msg,3000);
                setTimeout(function(){location.reload()} , 3000);
                break;
            default :
                console.log('default: error');
                console.log(response);
                break;
        }

    },
    onError: function(err){
        console.log(err);
    },
    ajaxDone: function(response){
        console.log('ajax done');
        console.log(response);
    },
    ajaxCall: function(params){
        $.ajax({
            url: this.dataUrl,
            type: "POST",
            dataType: "json",
            data: params,
            success: this.onSuccess,
            error: this.onError,
        })
            .done(this.ajaxDone);
    },
    drawTable: function(list){
        var html = '';
        $.each(list,function(i,user){
            html += '<tr><td>'+ i +'</td>';
            html += '<td><span class="email">'+user.user_email+'</span></td>';
            html += '<td><span class="registered">'+user.user_registered+'</span></td>';
            html += '<td><span class="role">'+user.user_role+'</span></td>';
            if(user.user_role !== null){
                switch (user.user_role){
                    case 'admin':
                        if(user.user_status == 1){
                            html += '<td>' +
                                '<div class="col-md-12 column">' +
                                '<div class="btn-group">' +
                                '<button class="btn btn-sm btn-success password-reset" type="button"><?php echo $data['lang_password_reset'];?></button>' +
                                '<button class="btn btn-sm btn-danger delete" type="button" disabled><?php echo $data['lang_user_delete'];?></button>' +
                                '</div>' +
                                '</div>' +
                                '</td>';
                        }else{
                            html += '<td>' +
                                '<div class="col-md-12 column">' +
                                '<div class="btn-group">' +
                                '<button class="btn btn-sm btn-success password-reset" type="button"><?php echo $data['lang_password_reset'];?></button>' +
                                '<button class="btn btn-sm btn-info agree" type="button"><?php echo $data['lang_user_allow'];?></button>' +
                                '</div>' +
                                '</div>' +
                                '</td>';
                        }
                        break;
                    case 'user':
                    case 'student':
                    case 'tutor':
                        if(user.user_status == 1){
                            html += '<td>' +
                                '<div class="col-md-12 column">' +
                                '<div class="btn-group">' +
                                '<button class="btn btn-sm btn-success password-reset" type="button"><?php echo $data['lang_password_reset'];?></button>' +
                                '<button class="btn btn-sm btn-danger delete" type="button"><?php echo $data['lang_user_delete'];?></button>' +
                                '</div>' +
                                '</div>' +
                                '</td>';
                        }else{
                            html += '<td>' +
                                '<div class="col-md-12 column">' +
                                '<div class="btn-group">' +
                                '<button class="btn btn-sm btn-success password-reset" type="button"><?php echo $data['lang_password_reset'];?></button>' +
                                '<button class="btn btn-sm btn-info agree" type="button"><?php echo $data['lang_user_allow'];?></button>' +
                                '</div>' +
                                '</div>' +
                                '</td>';
                        }
                        break;
                    default :
                        break;
                }
            }else{
                html += '<td><span class="role">None</span></td>';
            }

            html += '</tr>';

        })
        $('#user_list_tb').html(html);
        this.bindEvents();
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

$(document).ready(function(){
    $('#save').on('click',function(){
        console.log("Save Clicked!");
        App.showMessage('Saving...',0);
        //validation check
        if(App.validPassword()){
            //make user info
            var user = {
                user_email: $('#user_email').val(),
                user_pass: $('#user_pass_new').val(),
                user_role: $('#user_role').val()
            };
            App.addNewUser(user);
        }
    })
    //message hide
    $('#error').on('click',function(){
        $(this).hide();
    })

})
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

function onDelete( id ){
    var confirmRes = confirm("Are you sure remove this user? User Id : " + id);
    if(confirmRes){
        var param = {
            id : id,
        }
        App.deleteUser(param);
    }
}

function onResetPassword( email ){
    var confirmRes = prompt("Input password will be reset for this user? User Email : " + email);
//    console.log(confirmRes);
    if(confirmRes){
        var param = {
            email : email,
            password : confirmRes,
        }
        App.resetUserPassword(param);
    }
}

function onPay( budget ,  email ){
    var confirmRes = confirm("You really payed " + budget + " USD for this user? User email : " + email);
    if(confirmRes){
        var param={
            email : email,
        }

        App.resetRequest(param);
    }
}
</script>
