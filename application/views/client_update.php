<div class="container">
    <h1><?php echo lang('update_client') ?></h1>

    <form class="form-horizontal clearfix" method="post" role="form" onsubmit="javascript: return form_check('client_update');">

        <div class="row">
            <div class="col-md-6">
                <h2><?php echo lang('basic_info'); ?></h2>
                <div class="form-group<?php if(form_error('name')) echo ' has-error'; ?>">
                    <?php echo form_label(lang('company_name').'：<em>*</em>', 'name', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text', 'class' => 'form-control','id' => 'name', 'placeholder' => lang('company_name'), 'name' => 'client_info[name]', 'value' => $client->name, 'required' => '')); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('address').'：', 'address', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'address', 'placeholder' => lang('address'), 'name' => 'client_info[address]', 'value' => $client->address)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('contact').'：', 'contact', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'contact', 'placeholder' => lang('contact'), 'name' => 'client_info[contact]', 'value' => $client->contact)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-1：', 'phone1', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone1', 'placeholder' => lang('phone').'-1', 'name' => 'client_info[phone1]', 'value' => $client->phone1)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-2：', 'phone2', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone2', 'placeholder' => lang('phone').'-2', 'name' => 'client_info[phone2]', 'value' => $client->phone2)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('phone').'-3：', 'phone3', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'phone3', 'placeholder' => lang('phone').'-3', 'name' => 'client_info[phone3]', 'value' => $client->phone3)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('note').'：', 'note', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_textarea(array('class' => 'form-control','id' => 'note', 'placeholder' => lang('note'), 'name' => 'client_info[note]', 'rows' => 8, 'value' => $client->note)); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2><?php echo lang('sale_info'); ?></h2>
                <div class="form-group">
                    <?php echo form_label(lang('primary_project').'：', 'pp', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('client_info[primary_project]', $projects, isset($client->primary_project)? $client->primary_project : '1', 'class="form-control" id="pp"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('sales_rep').'：', 'staff_id', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php if($userinfo->access == 'fullaccess' || $userinfo->access == 'manager'){ ?>
                            <?php echo form_dropdown('client_info[staff_id]', $staff, $client->staff_id, 'class="form-control" id="staff_id" onchange="javascript: $(\'#staff_name\').val($(this).find(\'option:selected\').text())"'); ?>
                        <?php }else{ ?>
                            <p class="form-control-static"><?php echo $client->staff;?><input type="hidden" name="client_info[staff_id]" value="<?php echo $client->staff_id; ?>" /></p>
                        <?php } ?>
                        <input type="hidden" name="client_info[staff]" id="staff_name" value="<?php echo $client->staff; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('level1').'：', 'level1', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('client_info[level1]', $level1, $client->level1, 'class="form-control" id="level1"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('progress').'：', 'progress', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('client_info[progress]', $progress, $client->progress, 'class="form-control" id="progress"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('status').'：', 'status', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('client_info[status]', $status, $client->status, 'class="form-control" id="status"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo form_label(lang('area').'：', 'area', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'area', 'placeholder' => lang('area'), 'name' => 'client_info[area]', 'value' => $client->area)); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('hightech'); ?>：</label>
                    <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary<?php if($client->is_hightech == 'Y') echo ' active'; ?>">
                                <input type="radio" name="client_info[is_hightech]" id="is_hightech_yes" value="Y"<?php if($client->is_hightech == 'Y') echo ' checked="checked"'; ?>> <?php echo lang('yes') ?>
                            </label>
                            <label class="btn btn-primary<?php if($client->is_hightech == 'N') echo ' active'; ?>">
                                <input type="radio" name="client_info[is_hightech]" id="is_hightech_no" value="N"<?php if($client->is_hightech == 'N') echo ' checked="checked"'; ?>> <?php echo lang('no') ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group<?php if($client->is_hightech == 'Y') echo ' normal_show'; ?>" id="high_tech_cert_info">
                    <?php echo form_label(lang('high_tech_cert_code').'：', 'htcc', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-5">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'htcc', 'placeholder' => lang('high_tech_cert_code'), 'name' => 'high_tech_cert_code', 'value' => isset($certs['H']->cert_code) ? $certs['H']->cert_code : '')); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo form_dropdown('client_info[hightech_year]', (array('0' => lang('grant_year')) + $year_range), isset($client->hightech_year)? $client->hightech_year : '0', 'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo lang('software_company'); ?>：</label>
                    <div class="col-sm-9">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary<?php if($client->is_soft_comp == 'Y') echo ' active'; ?>">
                                <input type="radio" name="client_info[is_soft_comp]" id="is_soft_comp_yes" value="Y"<?php if($client->is_soft_comp == 'Y') echo ' checked="checked"'; ?>> <?php echo lang('yes') ?>
                            </label>
                            <label class="btn btn-primary<?php if($client->is_soft_comp == 'N') echo ' active'; ?>">
                                <input type="radio" name="client_info[is_soft_comp]" id="is_soft_comp_no" value="N"<?php if($client->is_soft_comp == 'N') echo ' checked="checked"'; ?>> <?php echo lang('no') ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group<?php if($client->is_soft_comp == 'Y') echo ' normal_show'; ?>" id="soft_comp_cert_info">
                    <?php echo form_label(lang('soft_comp_cert_code').'：', 'scc', array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'scc', 'placeholder' => lang('soft_comp_cert_code'), 'name' => 'soft_comp_cert_code', 'value' => isset($certs['S']->cert_code) ? $certs['S']->cert_code : '')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="proj_type_row">
            <h2><?php echo lang('project_type'); ?></h2>
            <div class="row">

                <?php foreach( $projects as $k => $p): ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="input-group col-md-12">
                                    <span class="input-group-addon">
                                        <input class="project_type_check" type="checkbox" name="project[<?php echo $k; ?>]" id="project_<?php echo $k; ?>"<?php if($k == $client->primary_project || (isset($project_client[$k]) && $k == $project_client[$k]->proj_id)) echo ' checked="chekced"';?> />
                                        <label class="text-info full-left" for="project_<?php echo $k; ?>"><?php echo $p; ?></label>
                                    </span>
                            <?php echo form_dropdown('project_year['.$k.']', (array('0' => lang('grant_year')) + $year_range), isset($project_client[$k]->proj_year) ? $project_client[$k]->proj_year : 0, 'class="form-control" id="project_year_'.$k.'"'); ?>
                            <input type="hidden" name="pc_id[<?php echo $k; ?>]" value="<?php echo isset($project_client[$k]->id) ? $project_client[$k]->id : 0; ?>" />
                        </div>
                    </div>
                </div>
                <?php if($k == 4): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>

            </div>
            <br/>
            <br/>
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                <a href="<?php echo site_url('client/'.$client->id); ?>" class="btn btn-danger btn-lg btn-block"><?php echo lang('cancel'); ?></a>
            </div>
            <div class="col-md-9 text-center">
                <?php echo form_submit('save_client', lang('submit'), 'class="btn btn-primary btn-lg btn-block"') ?>
            </div>
        </div>
        <br/>
    </form>
</div>