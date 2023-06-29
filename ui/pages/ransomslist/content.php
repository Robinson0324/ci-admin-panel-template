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
            <a class="navbar-brand" href="javascript:void(0)">Ransoms List</a>
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
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category">Total Infected</h5>
                    <h2 class="card-title">Ransoms List</h2>
                  </div>
                </div>
              </div>
<!--            <div class="card-bod pad-10px">-->
<!--                <form class="form" id="saveprofile">-->
<!--                    <div class="row">-->
<!---->
<!--                        <div class="col-md-2">-->
<!--                            <div class="form-group">-->
<!--                                <label>Country</label>-->
<!--                                <input id="filter-country" type="text" class="form-control" placeholder="Country" value="--><?//= $data['filters']['country'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-2">-->
<!--                            <div class="form-group">-->
<!--                                <label>IP Address</label>-->
<!--                                <input id="filter-ip" type="text" class="form-control" placeholder="IP Address" value="--><?//= $data['filters']['ipaddress'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-2">-->
<!--                            <div class="form-group">-->
<!--                                <label>CRC32</label>-->
<!--                                <input id="filter-crc32" type="text" class="form-control" placeholder="CRC32" value="--><?//= $data['filters']['crc32'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label>Registration Date</label>-->
<!--                                <input id="filter-registration" type="text" class="form-control" placeholder="Registration" value="--><?//= $data['filters']['createdAt'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label>Decrypt Price</label>-->
<!--                                <input id="filter-decryptprice" type="text" class="form-control" placeholder="Decrypt Price" value="--><?//= $data['filters']['price'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-2">-->
<!--                            <div class="form-group">-->
<!--                                <label>OS</label>-->
<!--                                <input id="filter-os" type="text" class="form-control" placeholder="OS" value="--><?//= $data['filters']['os'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label>Test File</label>-->
<!--                                <input id="filter-testfile" type="text" class="form-control" placeholder="Test File" value="--><?//= $data['filters']['test'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-3">-->
<!--                            <div class="form-group">-->
<!--                                <label>Status</label>-->
<!--                                <input id="filter-status" type="text" class="form-control" placeholder="Status" value="--><?//= $data['filters']['status'];?><!--">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-4">-->
<!--                            <div class="pad-t-20px">-->
<!--                                <p id="btn-reset" class="btn btn-fill float-right" onclick="onReset()">Reset</p>-->
<!--                                <p id="btn-filter" class="btn btn-fill btn-primary float-right" onclick="onFilter()">Filter</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Ransoms Table</h4>
                <p class="card-category">All products that were shipped</p>
              </div>
              <div class="card-body">

                  <div class="card-body">
                      <table id="datatable" class="table table-striped text-center" >
                          <thead >
                          <tr>
                              <th>Country(IP)</th>
                              <th>CRC32/OS</th>
                              <th>Price/Discount</th>
                              <th>Encrypt time</th>
                              <th>AV / DAV</th>
                              <th>Decryptor</th>
                              <th>HDD</th>
                              <th>Status</th>
                              <th>Upload Decryptor</th>
                              <th>DecrytorCode</th>
                          </tr>
                          </thead>
                      </table>

                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  
   
  </div>
 