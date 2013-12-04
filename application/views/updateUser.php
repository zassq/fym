<div class="container">
    <h2><?php echo lang('update_user'); ?></h2>

    <?php if($error) echo '<div class="error">'. $error .'</div>'; ?>
    <form class="form-horizontal clearfix" method="post" role="form">
        <div class="form-group<?php if(form_error('username')) echo ' has-error'; ?>">
            <?php echo form_label(lang('username').'：', '', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $staff->username;?></p>
            </div>
        </div>
        <br/>
        <div class="form-group<?php if(form_error('name')) echo ' has-error'; ?>">
            <?php echo form_label(lang('name').'：<em>*</em>', 'name', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_input(array('type' => 'text', 'class' => 'form-control','id' => 'name', 'placeholder' => lang('name'), 'name' => 'name', 'value' => set_value('name', $staff->name))); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group<?php if(form_error('email')) echo ' has-error'; ?>">
            <?php echo form_label(lang('email').'：<em>*</em>', 'email', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_input(array('type' => 'email', 'class' => 'form-control','id' => 'email', 'placeholder' => lang('email'), 'name' => 'email', 'value' => set_value('email', $staff->email))); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('usertype').'：<em>*</em>', 'usertype', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_dropdown('usertype', $usertype, $staff->usertype, 'class="form-control"'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('access').'：<em>*</em>', 'access', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_dropdown('access', $access, $staff->access, 'class="form-control"'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('note').'：', 'note', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php echo form_textarea(array('class' => 'form-control','id' => 'note', 'placeholder' => lang('note'), 'name' => 'note', 'row' => 5, 'value' => $staff->note)); ?>
            </div>
        </div>
        <?php echo form_submit('saveUser', lang('submit'), 'class="btn btn-primary btn-lg btn-block"') ?>
    </form>
</div>