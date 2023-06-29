<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 9/28/14
 * Time: 8:35 PM
 */
?>

<!--    <div class="row">-->
<!--        <div class="col-lg-12">-->
<!--            <h2 class="page-header">--><?php //echo $data['lang_user_management'];?><!--</h2>-->
<!--        </div>-->
<!--        <!-- /.col-lg-12 -->
<!--    </div>-->
    <!-- /.row -->
<div class="pad-50px">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 4px;"><?php echo $data['lang_user_list'];?></h4>
                    <div class="btn-group pull-right">
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th><?php echo $data['lang_register_date'];?></th>
                                <th><?php echo $data['lang_role'];?></th>
                                <th>Key</th>
                                <th>DASH Address</th>
                                <th>Budget</th>
                                <th class="text-center"><?php echo $data['lang_action'];?></th>
                            </tr>
                            </thead>
                            <tbody id="user_list_tb">
                                <?php foreach($data['users'] as $user) { ?>
                                    <tr>
                                        <td><?php echo $user->member_id?></td>
                                        <td><?php echo $user->member_email?></td>
                                        <td><?php echo $user->register_date?></td>
                                        <td><?php echo $user->member_role?></td>
                                        <td><?php echo $user->member_key?></td>
                                        <td><?php echo $user->dash_address?></td>
                                        <td><?php echo $user->budget?> USD</td>
                                        <td>
                                            <div class="row text-center">

                                                <div class="col-md-4 pad-10px tooltip-c">
                                                    <button class="btn" id="btn-resetpassword" onclick="onResetPassword('<?php echo $user->member_email?>')">
                                                        <i class="tim-icons icon-settings"></i>
                                                    </button>
                                                    <span class="tooltiptext-c">Reset Password</span>
                                                </div>
                                                <div class="col-md-4 pad-10px tooltip-c">
                                                    <button class="btn btn-pinterest" onclick="onDelete(<?php echo $user->member_id?>)">
                                                        <i class="tim-icons icon-trash-simple"></i>
                                                    </button>
                                                    <span class="tooltiptext-c">Delete</span>
                                                </div>

                                                <?php if($user->request_dash == 1){?>
                                                    <div class="col-md-4 pad-10px tooltip-c">
                                                        <button class="btn" style="display:block;" id="btn-pay" onclick="onPay(<?php echo $user->budget;?> , '<?php echo $user->member_email;?>')">
                                                            <i class="tim-icons icon-money-coins"></i>
                                                        </button>
                                                        <span class="tooltiptext-c">Payed for this user.</span>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->

    <div class="row clearfix">
        <div class="col-md-12 column" id="search-form-container" >
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo $data['lang_add_new_user'];?>
                    </h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="user_email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="user_email" value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_role" class="col-sm-4 control-label"><?php echo $data['lang_role'];?></label>
                            <div class="col-sm-4">
                                <select class="form-control" id="user_role">
                                    <option value="User">user</option>
                                    <option value="Admin">admin</option>
<!--                                    <option value="user">--><?php //echo $data['lang_user'];?><!--</option>-->
<!--                                    <option value="admin">--><?php //echo $data['lang_manager'];?><!--</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_pass_new" class="col-sm-4 control-label"><?php echo $data['lang_new_password'];?></label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="user_pass_new" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_pass_confirm" class="col-sm-4 control-label"><?php echo $data['lang_confirm_password'];?></label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="user_pass_confirm" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-4">
                                <button type="button" id="save" class="btn btn-normal btn-success"><?php echo $data['lang_save'];?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="position:fixed; bottom: 5%; padding-top: 30px;">
            <div id="error" class="alert alert-danger hidden" role="alert"></div>
        </div>
    </div>
</div>
