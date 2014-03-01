<div class="container">
    <div class="col-md-12">
        <h1><?php echo lang('client_upload') ?></h1>
        <h2 class=""><?php echo lang('use_instruction') ?></h2>
        <p class="text-primary"><?php echo lang('clients_upload_instruction'); ?></p>
        <p class="small text-info">
            | <?php echo lang('company_name'); ?>
            | <?php echo lang('project'); ?>
            | <?php echo lang('progress'); ?>
            | <?php echo lang('status'); ?>
            | <?php echo lang('area'); ?>
            | <?php echo lang('phone'); ?>
            | <?php echo lang('address'); ?>
            | <?php echo lang('client_info'); ?>
            | <?php echo lang('note'); ?>
            | <?php echo lang('marketing_log'); ?>
            |
        </p>
        <hr/>
    </div>
    <div class="col-md-12">
        <h2><?php echo lang('upload_content'); ?></h2>
    </div>
    <form class="form-horizontal" action="<?php echo current_url();?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file" class="col-sm-2 control-label">选择文件</label>
            <div class="col-sm-10">
              <input type="file" id="file" name="file">
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="upload_submit" value="上传" />
            </div>
        </div>
    </form>
</div>