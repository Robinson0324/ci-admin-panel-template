
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
    <div class="full-page login-page " >
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="content" >
        <div class="container">
          <div class="col-lg-4 col-md-6 ml-auto mr-auto">
            <form class="form" id="LoginValidation">
              <div class="card card-login card-white">
                <div class="card-header">
                  <img src="<?php echo $theme_url;?>/assets/img/card-primary.png" alt="">
                  <h1 class="card-title">Log in</h1>
                </div>
                <div class="card-body">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="tim-icons icon-email-85"></i>
                      </div>
                    </div>
                   
                    <input type="text" class="form-control" placeholder="E-mail" name="email" type="email" autofocus required>
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="tim-icons icon-lock-circle"></i>
                      </div>
                    </div>
                    <input type="password" placeholder="Password" name="password" type="password" value="" class="form-control">
                  </div>
                </div>
                <div class="card-footer">
                  <button type='submit' id="login-btn" class="btn btn-primary btn-lg btn-block mb-3">Login</button>
<!--                  <div class="pull-left">-->
<!--                    <h6>-->
<!--                      <a href="--><?php //echo $signup_url;?><!--" class="link footer-link">Create Account</a>-->
<!--                    </h6>-->
<!--                  </div>-->
                  <!-- <div class="pull-right">
                    <h6>
                      <a href="javascript:void(0)" class="link footer-link">Need Help?</a>
                    </h6>
                  </div> -->
                </div>
              </div>
            </form>
          </div>
         
        </div>
      </div>

    </div>
  </div>

<img src="<?php echo $theme_url;?>/images/ajax-loader.gif" id="loading-indicator" style="display:none" />
