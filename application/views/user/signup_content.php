
<body class="login-page">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent fixed-top">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle d-inline">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="navbar-nav ml-auto">
   
          <li class="nav-item ">
          <a href="<?php echo base_url().'user/signup';?>" class="nav-link">
              <i class="tim-icons icon-laptop"></i> Register
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url().'user/login';?>" class="nav-link">
              <i class="tim-icons icon-single-02"></i> Login
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
 
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page ">
    <div class="full-page register-page">
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-5 ml-auto">
              <div class="info-area info-horizontal mt-5">
                <div class="icon icon-warning">
                  <i class="tim-icons icon-wifi"></i>
                </div>
                <div class="description">
                  <h3 class="info-title">Marketing</h3>
                  <p class="description">
                    We've created the marketing campaign of the website. It was a very interesting collaboration.
                  </p>
                </div>
              </div>
              <div class="info-area info-horizontal">
                <div class="icon icon-primary">
                  <i class="tim-icons icon-triangle-right-17"></i>
                </div>
                <div class="description">
                  <h3 class="info-title">Fully Coded in HTML5</h3>
                  <p class="description">
                    We've developed the website with HTML5 and CSS3. The client has access to the code using GitHub.
                  </p>
                </div>
              </div>
              <div class="info-area info-horizontal">
                <div class="icon icon-info">
                  <i class="tim-icons icon-trophy"></i>
                </div>
                <div class="description">
                  <h3 class="info-title">Built Audience</h3>
                  <p class="description">
                    There is also a Fully Customizable CMS Admin Dashboard for this product.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-7 mr-auto">
              <div class="card card-register card-white">
                <div class="card-header">
                  <img class="card-img" src="<?php echo $theme_url;?>/assets/img/card-primary.png" alt="Card image">
                  <h4 class="card-title">Register</h4>
                </div>
                <div class="card-body">
                  <form class="form">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-single-02"></i>
                        </div>
                      </div>
                      <input type="text" class="form-control" name = "fullname" placeholder="Full Name">
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-email-85"></i>
                        </div>
                      </div>
                      <input type="text" placeholder="Email" name = "email"  class="form-control">
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-lock-circle"></i>
                        </div>
                      </div>
                      <input type="password" class="form-control" name = "password"  placeholder="Password">
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="tim-icons icon-lock-circle"></i>
                        </div>
                      </div>
                      <input type="password"  class="form-control" name = "confirm_password"  placeholder="Confirm Password">
                    </div>
                    <!-- <div class="form-check text-left">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox">
                        <span class="form-check-sign"></span>
                        I agree to the
                        <a href="javascript:void(0)">terms and conditions</a>.
                      </label>
                    </div> -->
                  </form>
                </div>
                <div class="card-footer">
                  <a href="#" id="signup-btn"   class="btn btn-primary btn-round btn-lg">Get Started</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
  </div>

<img src="<?php echo $theme_url;?>/images/ajax-loader.gif" id="loading-indicator" style="display:none" />
