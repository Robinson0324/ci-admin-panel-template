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
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
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
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category">Total Shipments</h5>
                    <h2 class="card-title">Performance</h2>
                  </div>
                  <div class="col-sm-6">
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                      <label class="btn btn-sm btn-primary btn-simple active" id="0">
                        <input type="radio" name="options" checked>
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Earned Dashes</span>
                        <span class="d-block d-sm-none">
                          <i class="tim-icons icon-single-02"></i>
                        </span>
                      </label>
                      <label class="btn btn-sm btn-primary btn-simple" id="1">
                        <input type="radio" class="d-none d-sm-none" name="options">
                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Infected Computers</span>
                        <span class="d-block d-sm-none">
                          <i class="tim-icons icon-gift-2"></i>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="chartBig1"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-warning">
                      <i class="tim-icons icon-chat-33"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <p class="card-category">Unread Message</p>
                      <h3 class="unread_msg card-title"><?php echo $data['all_data']['unread_msg']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="tim-icons icon-refresh-01"></i> Update Now
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-primary">
                      <i class="tim-icons icon-shape-star"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <p class="card-category">All Prices(USD)</p>
                      <h3 class="all_dash card-title"><?php echo $data['all_data']['all_dash']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="tim-icons icon-sound-wave"></i> Last Research
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-success">
                      <i class="tim-icons icon-single-02"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <p class="card-category">All Bots</p>
                      <h3 class="all_bots card-title"><?php echo $data['all_data']['all_bots']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="tim-icons icon-trophy"></i> Customers feedback
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-danger">
                      <i class="tim-icons icon-molecule-40"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <p class="card-category">Paid Bots</p>
                      <h3 class="paid_bots card-title"><?php echo $data['all_data']['paid_bots']; ?></h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <hr>
                <div class="stats">
                  <i class="tim-icons icon-watch-time"></i> In the last hours
                </div>
              </div>
            </div>
          </div>
          
          
          
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Global Sales by Top Locations</h4>
                <p class="card-category">All products that were shipped</p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="table-responsive">
                      <table class="table">
                        <tbody>
                          
                            <?php 
                              foreach ($data['TopSales'] as $key => $value) {?>
                                  <tr>
                                    
                                    <td><?php echo $value['country']; ?></td>
                                    <td><?php echo $value['num']; ?></td>
                                    <td class="text-right">
                                      <?php echo $value['sum']; ?>USD
                                    </td>
                                   
                                  </tr>
                                 
                            <?php  } ?>

                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-md-6 ml-auto mr-auto">
                    <div id="worldMap" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  
   
  </div>
 