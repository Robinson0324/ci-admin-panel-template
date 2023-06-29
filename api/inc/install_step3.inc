<div class="page-custom-header">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">DB</li>
        <li class="breadcrumb-item active">Variables</li>
        <li class="breadcrumb-item">Admin</li>
    </ul>
    <p class="label-custom-bg">
        <span style="color:#337AB7">Step 3</span> || Main-Admin
    </p>
    <?php if(isset($msg3)) echo '<p  class="label-custom-md label-custom-warning">'.$msg3.'</p>'; ?>
</div>
<form class="form-horizontal" action="?step=finish" method="post">
    <input type="hidden" name="step" value="finish" />
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">Admin Name:</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="user" placeholder="User Name" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">Admin Email:</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" type="text" name="email" placeholder="User Email" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <p class="label-custom-md">Admin Password:</p>
        </div>
        <div class="col-sm-8">
            <input class="label-custom-md" readonly type="text" name="password" placeholder="123456789" value="123456789">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button name="continue" type="submit" class="btn btn-primary pull-right span5">Finish</button>
        </div>
    </div>
</from>