<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 3:35 AM
 */
?>
<img src="<?php echo $data['theme_url'];?>/images/ajax-loader.gif" id="loading-indicator" style="display:none" />
<a href="#" class="scrollToTop"></a>
<a href="#" class="scrollToDown"></a>
<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><?php echo $data['lang_toggle_navigation'];?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand brand" href="#"><?php echo $data['title']; ?></a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav" id="top-menu">
                <li class="">
                    <a href="<?php echo $data['menu_url']."/dashboard";?>" ><i class="fa fa-fire fa-fw"></i>Dashboard</a>
                </li>
<!--                --><?php
//                    if($data['userdata']['role']!=='student'){
//                ?>
<!--                        <li class="">-->
<!--                            <a href="--><?php //echo $data['menu_url']."/subject";?><!--" ><i class="fa fa-fire fa-fw"></i>Subject</a>-->
<!--                        </li>-->
<!--                --><?php
//                }
//                ?>
<!---->
<!--                <li class="">-->
<!--                    <a href="--><?php //echo $data['menu_url']."/booking";?><!--" ><i class="fa fa-fire fa-fw"></i>Booking</a>-->
<!--                </li>-->

            </ul>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <?php echo $data['userdata']->member_email;?>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <?php  if($data['userdata']->member_role == "admin"):?>
                            <li>
                                <a href="<?php echo $data['menu_url']."/usermanage";?>"><i class="fa fa-users fa-fw"></i> <?php echo $data['lang_user_list'];?></a>
                            </li>
                        <?php  endif;?>
                        <li class=""></li>
                        <li><a href="<?php echo $data['menu_url']."/profile";?>"><i class="fa fa-user fa-fw"></i> <?php echo $data['lang_user_profile'];?></a>
                        </li>
                        <li class="divider"></li>
                        <li style="text-align: center;">
                            <form action="<?php echo base_url()."index.php/user/login/logout";?>" id="logout-form" method="post">
                                <input type="hidden" name="action" value="logout">
                                <button class="btn btn-danger" type="submit"><i class="fa fa-sign-out fa-fw"></i> <?php echo $data['lang_logout'];?></button>
                            </form>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        </nav>