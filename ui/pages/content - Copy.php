<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 10/27/14
 * Time: 5:12 PM
 */
?>
<!-- Page Content -->
<div id="page-wrapper">
    <?php if(empty($data['page'])){ ?>

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><?php echo $data['lang_product_update'];?></h3>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">

        <div class="panel panel-info" id="revise-setting">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $data['lang_revise_setting'];?></h3>
            </div>
            <div class="panel-body">
                <?php
                //print_r($data);
                ?>
            </div>
        </div>
    </div>
    <?php
    }else{
        require_once FCPATH."/ui/pages/".$data['page']."/index.php";
    }
    ?>
</div>