<div class="page-custom-header">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">DB</li>
        <li class="breadcrumb-item active">Variables</li>
        <li class="breadcrumb-item active">Admin</li>
    </ul>
    <p class="label-custom-bg">
        <span style="color:#337AB7">Step 1</span> || DATABASE
    </p>
    <?php if(isset($msg1)) echo '<p  class="label-custom-md label-custom-warning">'.$msg1.'</p>'; ?>
</div>
<form class="form-horizontal" action="?step=2" method="post">
    <input type="hidden" name="step" value="2">
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">MySQL HostName :</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="database_host" placeholder="eg: localhost" >
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">MySQL UserName :</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="database_user" placeholder="eg: root" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">MySQL Password :</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="database_pass" placeholder="eg: root" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">MySQL DBName :</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="database" placeholder="eg: panel_db" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button name="continue" type="submit" class="btn btn-primary pull-right span5">Continue</button>
        </div>
    </div>
    </div><!-- End .row-fluid  -->
</form>