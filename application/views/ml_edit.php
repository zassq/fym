<div class="container">
    <h2><?php echo lang('marketing_log_edit'); ?></h2>
    <form action="" method="post" class="form-horizontal" role="form">
        <div class="form-group">
            <?php echo form_label(lang('date').'：', 'ml_date_1', array('class' => 'col-sm-3 col-md-2 control-label')); ?>
            <div class="col-sm-6 col-md-5 input-group date marketing_log_date">
                <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'ml_date_1', 'placeholder' => lang('date'), 'name' => 'ml_date', 'data-format' => "YYYY-MM-DD", 'value' => $ml_item->date)); ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('sales_rep').'：', 'ls_sales_rep_1', array('class' => 'col-sm-3 col-md-2 control-label')); ?>
            <div class="col-sm-6 col-md-5">
                <p class="form-control-static"><?php echo $userinfo->name; ?></p>
            </div>
        </div>
        <div class="form-group">
            <?php echo form_label(lang('marketing_log').'：', 'ml_log_1', array('class' => 'col-sm-3 col-md-2 control-label')); ?>
            <div class="col-sm-6 col-md-5">
                <?php echo form_textarea(array('class' => 'form-control','id' => 'ml_log_1', 'placeholder' => lang('marketing_log'), 'name' => 'ml_log', 'rows' => '10', 'value' => $ml_item->detail)); ?>
            </div>
        </div>
        <div class="col-sm-9 col-md-7"><input type="submit" name="ml_submit" value="<?php echo lang('save');?>" class="btn btn-primary btn-block" /></div>
    </form>
</div>