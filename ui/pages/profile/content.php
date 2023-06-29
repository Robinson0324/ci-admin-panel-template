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
            <a class="navbar-brand" href="javascript:void(0)">User Profile</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a href="<?php echo base_url()."dashboard";?>" class="nav-link text-primary">
                  <i class="tim-icons icon-minimal-left"></i> Back to Dashboard
                </a>
              </li>
<!--              <li class="nav-item ">-->
<!--                <a href="--><?php //echo base_url().'user/signup';?><!--" class="nav-link">-->
<!--                  <i class="tim-icons icon-laptop"></i> Register-->
<!--                </a>-->
<!--              </li>-->
<!--              <li class="nav-item ">-->
<!--                <a href="--><?php //echo base_url().'user/login';?><!--" class="nav-link">-->
<!--                  <i class="tim-icons icon-single-02"></i> Login-->
<!--                </a>-->
<!--              </li>-->

            </ul>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Edit Profile</h5>
              </div>
              <div class="card-body">
                <form class="form" id="saveprofile">
                  <div class="row">
<!--                    <div class="col-md-5 pr-md-1">-->
<!--                      <div class="form-group">-->
<!--                        <label>Company (disabled)</label>-->
<!--                        <input type="text" class="form-control" disabled="" value="Creative Code Inc.">-->
<!--                      </div>-->
<!--                    </div>-->
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>Username</label>
                        <input id="username" type="text" class="form-control" value= <?php echo $data['userdata']->member_name;  ?> >
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>Email address</label>
                        <input id="email" type="email" class="form-control" placeholder="mike@email.com" value=<?php echo $data['userdata']->member_email?>>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-md-1">
                      <div class="form-group">
                        <label>First Name</label>
                        <input id="firstname" type="text" class="form-control" value=<?php echo $data['userdata']->member_first_name ?>>
                      </div>
                    </div>
                    <div class="col-md-6 pl-md-1">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input id="lastname" type="text" class="form-control" value=<?php echo $data['userdata']->member_last_name?>>
                      </div>
                    </div>

                  </div>

                    <div class="row">
                        <div class="col-md-10 pr-md-1">
                            <div class="form-group">
                                <label>DASH Address</label>
                                <input id="dashaddress" type="text" class="form-control" value=<?php echo $data['userdata']->dash_address?>>
                            </div>
                        </div>
                    </div>
<!--                  <div class="row">-->
<!--                    <div class="col-md-12">-->
<!--                      <div class="form-group">-->
<!--                        <label>Address</label>-->
<!--                        <input type="text" class="form-control" placeholder="Home Address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="row">-->
<!--                    <div class="col-md-4 pr-md-1">-->
<!--                      <div class="form-group">-->
<!--                        <label>City</label>-->
<!--                        <input type="text" class="form-control" value="Mike">-->
<!--                      </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-4 px-md-1">-->
<!--                      <div class="form-group">-->
<!--                        <label>Country</label>-->
<!--                        <input type="text" class="form-control" value="Andrew">-->
<!--                      </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-4 pl-md-1">-->
<!--                      <div class="form-group">-->
<!--                        <label>Postal Code</label>-->
<!--                        <input type="number" class="form-control" placeholder="ZIP Code">-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                  <div class="row">-->
<!--                    <div class="col-md-8">-->
<!--                      <div class="form-group">-->
<!--                        <label>About Me</label>-->
<!--                        <textarea rows="4" cols="80" class="form-control">Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</textarea>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
                </form>
              </div>
              <div class="card-footer">
                <button id="btn-save-profile" class="btn btn-fill btn-primary">Save</button>
              </div>
            </div>
<!--              <div class="row">-->
<!--                  <div class="col-md-8 col-md-offset-2" style="padding-top: 30px;">-->
<!--                      <div id="error" class="alert alert-danger hidden" role="alert"></div>-->
<!--                  </div>-->
<!--              </div>-->
          </div>


          <div class="col-md-4">
            <div class="card card-user">
              <div class="card-body">
                <p class="card-text">
                  <div class="author">
                    <div class="block block-one"></div>
                    <div class="block block-two"></div>
                    <div class="block block-three"></div>
                    <div class="block block-four"></div>
                    <a href="javascript:void(0)">
                      <img class="avatar" src="<?php echo base_url()."upload/avatar/".$data['userdata']->member_avatar?>" alt="...">
                      <h5 class="title"><?php echo $data['userdata']->member_name?></h5>
                    </a>
                    <p class="description">
                      Balance : <?php echo $data['userdata']->budget?> USD
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <span class="btn btn-rose btn-round btn-file">
                              <span class="fileinput-new">Change Avatar</span>
                              <input type="file" name="uploadavatar" class="uploadavatar" />
                            </span>
                        </div>

                        <div class="col-md-6">
                            <?php if($data['userdata']->request_dash == 1){?>
                                <span class="btn btn-rose btn-round btn-file btn-primary">
                                  <span class="">Requested Already</span>
                                </span>
                            <?php } else { ?>
                                <span class="btn btn-rose btn-round btn-file" onclick="onRequestBudget('<?php echo $data['userdata']->member_email;?>')">
                                  <span class="">Request Budget</span>
                                </span>
                            <?php } ?>
                        </div>
                    </div>

                  </div>
                </p>
<!--                <div class="card-description">-->
<!--                  Do not be scared of the truth because we need to restart the human foundation in truth And I love you like Kanye loves Kanye I love Rick Owens’ bed design but the back is...-->
<!--                </div>-->
              </div>
<!--              <div class="card-footer">-->
<!--                <div class="button-container">-->
<!--                  <button href="javascript:void(0)" class="btn btn-icon btn-round btn-facebook">-->
<!--                    <i class="fab fa-facebook"></i>-->
<!--                  </button>-->
<!--                  <button href="javascript:void(0)" class="btn btn-icon btn-round btn-twitter">-->
<!--                    <i class="fab fa-twitter"></i>-->
<!--                  </button>-->
<!--                  <button href="javascript:void(0)" class="btn btn-icon btn-round btn-google">-->
<!--                    <i class="fab fa-google-plus"></i>-->
<!--                  </button>-->
<!--                </div>-->
<!--              </div>-->

            </div>
          </div>

          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">
                      <h5 class="title">Change Password</h5>
                  </div>
                  <div class="card-body">
                      <form class="form" id="saveprofile">
                          <div class="row">
                             <div class="col-md-6 pr-md-1">
                                  <div class="form-group">
                                      <label>Old Password</label>
                                      <input id="user_pass_old" type="password" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-6 pr-md-1">
                                  <div class="form-group">
                                      <input id="user_email" type="hidden" class="form-control" value="<?php echo $data['userdata']->member_email?>">
                                  </div>
                              </div>
                              <div class="col-md-6 pr-md-1">
                                  <div class="form-group">
                                      <label>New Password</label>
                                      <input id="user_pass_new" type="password" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-6 pr-md-1">
                                  <div class="form-group">
                                      <label>Confirm Password</label>
                                      <input id="user_pass_confirm" type="password" class="form-control">
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
                  <div class="card-footer">
                      <button id="btn-change-password" class="btn btn-fill btn-primary">Change Password</button>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-8 col-md-offset-2" style="position:fixed; bottom: 5%;padding-top: 30px;">
                      <div id="error" class="alert alert-danger hidden" role="alert"></div>
                  </div>
              </div>
          </div>
        </div>
      </div>
      
  
   
  </div>
 