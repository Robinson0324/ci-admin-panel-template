<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/6/14
 * Time: 3:34 AM
 */
?>
    <div class="navbar-minimize-fixed">
      <button class="minimize-sidebar btn btn-link btn-just-icon">
        <i class="tim-icons icon-align-center visible-on-sidebar-regular text-muted"></i>
        <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini text-muted"></i>
      </button>
    </div>
    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            RP
          </a>
          <a href="javascript:void(0)" class="simple-text logo-normal">
            RPanel
          </a>
        </div>
        <ul class="nav">
          <li class="<?php if($data['page']=== "dashboard") echo "active";?>">
            <a href="<?php echo $data['menu_url']."/dashboard";?>">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
            <li class="<?php if($data['page']=== "ransomslist") echo "active";?>">
                <a href="<?php echo $data['menu_url']."/ransomslist";?>">
                    <i class="tim-icons icon-bank"></i>
                    <p>Ransoms List</p>
                </a>
            </li>
            <li class="<?php if($data['page']=== "transactionlist") echo "active";?>">
                <a href="<?php echo $data['menu_url']."/transactionlist";?>">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <p>Transaction List</p>
                </a>
            </li>
            <li class="<?php if($data['page']=== "chatting") echo "active";?>">
                <a href="<?php echo $data['menu_url']."/chatting";?>">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>Messages</p>
                </a>
            </li>

            <li class="<?php if($data['page']=== "profile") echo "active";?>">
                <a href="<?php echo $data['menu_url']."/profile";?>">
                    <i class="tim-icons icon-settings-gear-63"></i>
                    <p>Profile Settings</p>
                </a>
            </li>

            <li class="">
                <a href="<?php echo base_url()."index.php/user/login/logout";?>">
                    <i class="tim-icons icon-button-power"></i>
                    <p>Logout</p>
                </a>
            </li>
            <?php if($data['userdata']->member_role == "Admin"){?>
            <div class="logo">

            </div>

            <li class="<?php if($data['page']=== "usermanage") echo "active";?>">
                <a href="<?php echo $data['menu_url']."/usermanage";?>">
                    <i class="tim-icons icon-single-02"></i>
                    <p>User Management</p>
                </a>
            </li>
            <?php } ?>
<!--          <li class="--><?php //if($data['page']=== "profile") echo "active";?><!--">-->
<!--            <a data-toggle="collapse" href="#Settings">-->
<!--              <i class="tim-icons icon-settings-gear-63"></i>-->
<!--              <p>-->
<!--                Settings-->
<!--                <b class="caret"></b>-->
<!--              </p>-->
<!--            </a>-->
<!--            <div class="collapse" id="Settings">-->
<!--              <ul class="nav">-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['menu_url']."/profile";?><!--">-->
<!--                      <span class="sidebar-mini-icon">UP</span>-->
<!--                      <span class="sidebar-normal"> User Profile </span>-->
<!--                  </a>-->
<!--                </li>-->
<!---->
<!--                <li>-->
<!--                  <a href="--><?php //echo base_url()."index.php/user/login/logout";?><!--">-->
<!--                    <span class="sidebar-mini-icon">LO</span>-->
<!--                    <span class="sidebar-normal"> Logout </span>-->
<!--                  </a>-->
<!--                </li>-->
<!---->
<!--              </ul>-->
<!--            </div>-->
<!--          </li>-->

<!--          <li>-->
<!--            <a data-toggle="collapse" href="#formsExamples">-->
<!--              <i class="tim-icons icon-notes"></i>-->
<!--              <p>-->
<!--                Forms-->
<!--                <b class="caret"></b>-->
<!--              </p>-->
<!--            </a>-->
<!--            <div class="collapse" id="formsExamples">-->
<!--              <ul class="nav">-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/forms/regular.html">-->
<!--                    <span class="sidebar-mini-icon">RF</span>-->
<!--                    <span class="sidebar-normal"> Regular Forms </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/forms/extended.html">-->
<!--                    <span class="sidebar-mini-icon">EF</span>-->
<!--                    <span class="sidebar-normal"> Extended Forms </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/forms/validation.html">-->
<!--                    <span class="sidebar-mini-icon">V</span>-->
<!--                    <span class="sidebar-normal"> Validation Forms </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/forms/wizard.html">-->
<!--                    <span class="sidebar-mini-icon">W</span>-->
<!--                    <span class="sidebar-normal"> Wizard </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </div>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a data-toggle="collapse" href="#tablesExamples">-->
<!--              <i class="tim-icons icon-puzzle-10"></i>-->
<!--              <p>-->
<!--                Tables-->
<!--                <b class="caret"></b>-->
<!--              </p>-->
<!--            </a>-->
<!--            <div class="collapse" id="tablesExamples">-->
<!--              <ul class="nav">-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/tables/regular.html">-->
<!--                    <span class="sidebar-mini-icon">RT</span>-->
<!--                    <span class="sidebar-normal"> Regular Tables </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/tables/extended.html">-->
<!--                    <span class="sidebar-mini-icon">ET</span>-->
<!--                    <span class="sidebar-normal"> Extended Tables </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/tables/datatables.net.html">-->
<!--                    <span class="sidebar-mini-icon">DT</span>-->
<!--                    <span class="sidebar-normal"> DataTables.net </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </div>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a data-toggle="collapse" href="#mapsExamples">-->
<!--              <i class="tim-icons icon-pin"></i>-->
<!--              <p>-->
<!--                Maps-->
<!--                <b class="caret"></b>-->
<!--              </p>-->
<!--            </a>-->
<!--            <div class="collapse" id="mapsExamples">-->
<!--              <ul class="nav">-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/maps/google.html">-->
<!--                    <span class="sidebar-mini-icon">GM</span>-->
<!--                    <span class="sidebar-normal"> Google Maps </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/maps/fullscreen.html">-->
<!--                    <span class="sidebar-mini-icon">FM</span>-->
<!--                    <span class="sidebar-normal"> Full Screen Map </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--                <li>-->
<!--                  <a href="--><?php //echo $data['theme_url'];?><!--/examples/maps/vector.html">-->
<!--                    <span class="sidebar-mini-icon">VM</span>-->
<!--                    <span class="sidebar-normal"> Vector Map </span>-->
<!--                  </a>-->
<!--                </li>-->
<!--              </ul>-->
<!--            </div>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a href="--><?php //echo $data['theme_url'];?><!--/examples/widgets.html">-->
<!--              <i class="tim-icons icon-settings"></i>-->
<!--              <p>Widgets</p>-->
<!--            </a>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a href="--><?php //echo $data['theme_url'];?><!--/examples/charts.html">-->
<!--              <i class="tim-icons icon-chart-bar-32"></i>-->
<!--              <p>Charts</p>-->
<!--            </a>-->
<!--          </li>-->
<!--          <li>-->
<!--            <a href="--><?php //echo $data['theme_url'];?><!--/examples/calendar.html">-->
<!--              <i class="tim-icons icon-time-alarm"></i>-->
<!--              <p>Calendar</p>-->
<!--            </a>-->
<!--          </li>-->
        </ul>
      </div>
    </div>