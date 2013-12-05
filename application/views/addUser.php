<div class="container">
    <h2><?php echo lang('add_user'); ?></h2>

    <?php if($error) echo '<div class="error">'. $error .'</div>'; ?>
    <form class="form-horizontal clearfix" method="post" role="form">
        <div class="form-group<?php if(form_error('username')) echo ' has-error'; ?>">
            <?php echo form_label(lang('username').'：<em>*</em>', 'username', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_input(array('type' => 'text', 'class' => 'form-control','id' => 'username', 'placeholder' => lang('username'), 'name' => 'username', 'value' => set_value('username'))); ?>
                <?php echo form_error('username'); ?>
            </div>
        </div>
        <div class="form-group<?php if(form_error('password')) echo ' has-error'; ?>">
            <?php echo form_label(lang('password').'：<em>*</em>', 'password', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_password(array('class' => 'form-control','id' => 'password', 'placeholder' => lang('password'), 'name' => 'password', 'value' => set_value('password'))); ?>
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
        <br/>
        <div class="form-group<?php if(form_error('name')) echo ' has-error'; ?>">
            <?php echo form_label(lang('name').'：<em>*</em>', 'name', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_input(array('type' => 'text', 'class' => 'form-control','id' => 'name', 'placeholder' => lang('name'), 'name' => 'name', 'value' => set_value('name'))); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group<?php if(form_error('email')) echo ' has-error'; ?>">
            <?php echo form_label(lang('email').'：<em>*</em>', 'email', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_input(array('type' => 'email', 'class' => 'form-control','id' => 'email', 'placeholder' => lang('email'), 'name' => 'email', 'value' => set_value('email'))); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('usertype').'：<em>*</em>', 'usertype', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_dropdown('usertype', $usertype, 'S', 'class="form-control"'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('access').'：<em>*</em>', 'access', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_dropdown('access', $access, 'staff', 'class="form-control"'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('note').'：', 'note', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_textarea(array('class' => 'form-control','id' => 'note', 'placeholder' => lang('note'), 'name' => 'note', 'row' => 5)); ?>
            </div>
        </div>
        <?php echo form_submit('saveUser', lang('submit'), 'class="btn btn-primary btn-lg btn-block"') ?>
        <br/>
    </form>
</div>