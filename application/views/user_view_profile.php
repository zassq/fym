<div class="container">
    <h1><?php echo $userinfo->name; ?></h1>

    <?php if($error) echo '<div class="error">'. $error .'</div>'; ?>
    <form class="form-horizontal clearfix" method="post" role="form">
        <div class="form-group">
            <?php echo form_label(lang('username').'：', '', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <p class="form-control-static"><strong><?php echo $userinfo->username;?></strong></p>
            </div>
        </div>
        <br/>
        <div class="form-group">
            <?php echo form_label(lang('email').'：', '', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $userinfo->email;?></p>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('usertype').'：', '', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $usertype[$userinfo->usertype];?></p>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('access').'：', '', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $access[$userinfo->access];?></p>
            </div>
        </div>
        <br/>
        <br/>
        <h2><?php echo lang('update_password') ?></h2>
        <div class="form-group<?php if(form_error('password')) echo ' has-error'; ?>">
            <?php echo form_label(lang('new_password').'：<em>*</em>', 'password', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_password(array('class' => 'form-control','id' => 'password', 'placeholder' => lang('new_password'), 'name' => 'password', 'value' => set_value('password'))); ?>
                <?php echo form_error('password'); ?>
            </div>
        </div>
        <div class="form-group<?php if(form_error('password2')) echo ' has-error'; ?>">
            <?php echo form_label(lang('confirm_password').'：<em>*</em>', 'password2', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_password(array('class' => 'form-control','id' => 'password2', 'placeholder' => lang('confirm_password'), 'name' => 'password2', 'value' => set_value('password2'))); ?>
                <?php echo form_error('password2'); ?>
            </div>
        </div>
        <?php echo form_submit('saveUser', lang('submit'), 'class="btn btn-primary btn-lg"') ?>
        <br/>
    </form>
</div>