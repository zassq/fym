<div class="container">
    <h1><?php echo lang('add_client') ?></h1>

    <form class="form-horizontal clearfix" method="post" role="form">

        <div class="row">
            <div class="col-md-6">
                <h2><?php echo lang('basic_info'); ?></h2>
                <div class="form-group<?php if(form_error('name')) echo ' has-error'; ?>">
                    <?php echo form_label(lang('company_name').'：<em>*</em>', 'name', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text', 'class' => 'form-control','id' => 'name', 'placeholder' => lang('company_name'), 'name' => 'name', 'value' => set_value('name'), 'required' => '')); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('address').'：', 'address', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'address', 'placeholder' => lang('address'), 'name' => 'address')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('contact').'：', 'contact', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'contact', 'placeholder' => lang('contact'), 'name' => 'contact')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-1：', 'phone1', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone1', 'placeholder' => lang('phone').'-1', 'name' => 'phone1')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-2：', 'phone2', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone2', 'placeholder' => lang('phone').'-2', 'name' => 'phone2')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-3：', 'phone3', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone3', 'placeholder' => lang('phone').'-3', 'name' => 'phone3')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('note').'：', 'note', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_textarea(array('class' => 'form-control','id' => 'note', 'placeholder' => lang('note'), 'name' => 'note', 'rows' => 5)); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2><?php echo lang('sale_info'); ?></h2>
                <div class="form-group">
                    <?php echo form_label(lang('sales_rep').'：', 'staff_id', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php if($userinfo->access == 'fullaccess' || $userinfo->access == 'manager'){ ?>
                            <?php echo form_dropdown('staff_id', $staff, '2', 'class="form-control" id="staff_id" onchange="javascript: $(\'#staff_name\').val($(this).find(\'option:selected\').text())"'); ?>
                        <?php }else{ ?>
                            <p class="form-control-static"><?php echo $userinfo->name;?><input type="hidden" name="staff_id" value="<?php echo $userinfo->id; ?>" /></p>
                        <?php } ?>
                        <input type="hidden" name="staff" id="staff_name" value="<?php if($userinfo->access == 'fullaccess' || $userinfo->access == 'manager') echo $staff['2']; else echo $userinfo->name; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('level1').'：', 'level1', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('level1', $level1, '1', 'class="form-control" id="level1"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('progress').'：', 'progress', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('progress', $progress, '1', 'class="form-control" id="progress"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('status').'：', 'status', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('status', $status, '1', 'class="form-control" id="status"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('area').'：', 'area', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'area', 'placeholder' => lang('area'), 'name' => 'area')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('hightech'); ?>：</label>
                    <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="is_hightech" id="is_hightech_yes" value="Y"> <?php echo lang('yes') ?>
                            </label>
                            <label class="btn btn-primary active">
                                <input type="radio" name="is_hightech" id="is_hightech_no" value="N" checked> <?php echo lang('no') ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="high_tech_cert_info">
                    <?php echo form_label(lang('high_tech_cert_code').'：', 'htcc', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'htcc', 'placeholder' => lang('high_tech_cert_code'), 'name' => 'high_tech_cert_code')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('software_company'); ?>：</label>
                    <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="is_soft_comp" id="is_soft_comp_yes" value="Y"> <?php echo lang('yes') ?>
                            </label>
                            <label class="btn btn-primary active">
                                <input type="radio" name="is_soft_comp" id="is_soft_comp_no" value="N" checked> <?php echo lang('no') ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="soft_comp_cert_info">
                    <?php echo form_label(lang('soft_comp_cert_code').'：', 'scc', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'scc', 'placeholder' => lang('soft_comp_cert_code'), 'name' => 'soft_comp_cert_code')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h2><?php echo lang('marketing_log') ?> | <a href="javascript:" class="btn btn-primary" onclick="javascript: add_new_ml();"><?php echo lang('add_new_ml') ?></a></h2>
            <div id="marketing_logs">
                <div class="form-group marketing_log_row" id="ml_row_1">
                    <div class="well clearfix row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label(lang('date').'：', 'ml_date_1', array('class' => 'col-sm-5 control-label')); ?>
                                <div class="col-sm-7 input-group date marketing_log_date">
                                    <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'ml_date_1', 'placeholder' => lang('date'), 'name' => 'ml_date[]', 'data-format' => "YYYY-MM-DD")); ?>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo form_label(lang('sales_rep').'：', 'ls_sales_rep_1', array('class' => 'col-sm-5 control-label')); ?>
                                <div class="col-sm-7">
                                    <?php echo form_dropdown('ml_staff_id[]', $staff, ($userinfo->usertype == 'A' ? '2' : $userinfo->id), 'class="form-control" onchange="javascript: $(\'#ml_staff_name_1\').val($(this).find(\'option:selected\').text())" id="ls_sales_rep_1"'); ?>
                                    <input type="hidden" name="ml_staff_name[]" id="ml_staff_name_1" value="<?php echo ($userinfo->usertype == 'A' ? $staff['2']: $staff[$userinfo->id]); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo form_label(lang('marketing_log').'：', 'ml_log_1', array('class' => 'col-sm-5 control-label')); ?>
                                <div class="col-sm-7">
                                    <?php echo form_textarea(array('class' => 'form-control','id' => 'ml_log_1', 'placeholder' => lang('marketing_log'), 'name' => 'ml_log[]', 'rows' => '1')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="control-label col-sm-1"><a href="javascript:" onclick="delet_ml_row('ml_row_1')" class="btn btn-danger btn-xs ml_delet_btn" title="<?php echo lang('delete');?>"><span class="glyphicon glyphicon-remove-sign"></span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_submit('save_client', lang('submit'), 'class="btn btn-primary btn-lg btn-block"') ?>
        <br/>
    </form>
</div>