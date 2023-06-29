<div class="page-custom-header">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">DB</li>
        <li class="breadcrumb-item">Variables</li>
        <li class="breadcrumb-item active">Admin</li>
    </ul>
    <p class="label-custom-bg">
        <span style="color:#337AB7">Step 2</span> || Variables
    </p>
    <?php if(isset($msg2)) echo '<p  class="label-custom-md label-custom-warning">'.$msg2.'</p>'; ?>
</div>
<form class="form-horizontal" action="?step=3" method="post">
    <input type="hidden" name="step" value="3" />
    
    <div class="row">
        <div class="col-sm-6">
            <p class="label-custom-sm">Base url (with http://)</p>
        </div>
        <div class="col-sm-6">
            <input class="label-custom-sm" type="text" name="base_url" placeholder="Base Url" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p class="label-custom-sm">Login Key</p>
        </div>
        <div class="col-sm-6">
            <input class="label-custom-sm" type="text" name="login_key" placeholder="Login Key" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <p class="label-custom-sm">Site/Pages title (allowed: only a-z A-Z 0-9 _-)</p>
        </div>
        <div class="col-sm-6">
            <input class="label-custom-sm" type="text" name="title_of_the_pages" placeholder="Site title" value="">
        </div>
    </div>
    
    
    
    <div class="row">
        <div class="col-sm-6">
            <p class="label-custom-sm"></p>
        </div>
        <div class="col-sm-6">
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button name="continue" type="submit" class="btn btn-primary pull-right span5">Continue</button>
        </div>
    </div>
</form>