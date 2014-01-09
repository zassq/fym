<div class="container">
    <div class="col-md-12">
        <h1><?php echo lang('client_upload') ?></h1>
        <h2 class=""><?php echo lang('use_instruction') ?></h2>
        <p class="text-primary"><?php echo lang('clients_upload_instruction'); ?></p>
        <p class="small text-info">
            | <?php echo lang('company_name'); ?>
            | <?php echo lang('progress'); ?>
            | <?php echo lang('status'); ?>
            | <?php echo lang('area'); ?>
            | <?php echo lang('contact'); ?>
            | <?php echo lang('phone'); ?>1
            | <?php echo lang('phone'); ?>2
            | <?php echo lang('phone'); ?>3
            | <?php echo lang('note'); ?>
            | <?php echo lang('marketing_log'); ?>
            |
        </p>
        <hr/>
    </div>
    <div class="col-md-12">
        <h2><?php echo lang('upload_content'); ?></h2>
    </div>
    <div class="form-group" id="upload_outer">
        <div class="form-group clearfix">
            <label for="project_type" class="col-sm-2 control-label"><?php echo lang('project_type');?>：</label>
            <div class="col-sm-4">
                <?php echo form_dropdown('project_type', $projects, '1', 'class="form-control" id="project_type"'); ?>
            </div>
            <label for="sales_rep_id" class="col-sm-2 control-label"><?php echo lang('sales_rep');?>：</label>
            <div class="col-sm-4">
                <?php if($userinfo->access == 'fullaccess' || $userinfo->access == 'manager'): ?>
                <?php echo form_dropdown('sales_rep_id', $staff, $userinfo->id, 'class="form-control" id="sales_rep_id" onchange="javascript:$(\'#sales_rep\').val($(this).find(\'option:selected\').text());"'); ?>
                <?php else: ?>
                    <p class="form-control-static"><?php echo $userinfo->name;?></p>
                    <input type="hidden" name="sales_rep_id" value="<?php echo $userinfo->id; ?>" />
                <?php endif; ?>
                <input type="hidden" name="sales_rep" value="<?php echo $userinfo->name; ?>" id="sales_rep" />
            </div>
        </div>
        <div class="form-group clearfix">
            <label for="client_upload_file" class="col-sm-2 control-label"><?php echo lang('client_list') ?>：</label>
            <div class="col-sm-2">
                <span id="client_upload" class="btn btn-success">
                    <i class="glyphicon glyphicon-open"></i>
                    <span><?php echo lang('client_list');?></span>
                    <input type="file" class="form-control uploadBtn" name="client_list" id="client_upload_file" placeholder="<?php echo lang('client_list');?>"/>
                </span>
            </div>
        </div>
        <div class="form-group clearfix">
            <div id="upload_file_name_outer">
                <label for="" class="col-sm-2 control-label"><?php echo lang('file_name'); ?>:</label>
                <span class="form-control-static" id="upload_file_name"></span>
            </div>
        </div>
    </div>
    <div class="form-group clearfix">
        <span class="col-sm-2 control-label"><strong><?php echo lang('filter_status'); ?>:</strong></span>
        <span class="col-sm-12 text-warning" id="filter_status"><?php echo lang('await'); ?></span>
    </div>


    <div class="col-md-12">
        <div id="client_filter_list">
            <h2><?php echo lang('new_client_list_detail'); ?></h2>
            <form action="<?php echo site_url(); ?>export_from_upload" method="post">
                <table id="client_filter_list_table" class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <td><?php echo lang('select_export'); ?></td>
                        <td><?php echo lang('company_name'); ?></td>
                        <td><?php echo lang('already_client'); ?></td>
                        <td><?php echo lang('already_hightech'); ?></td>
                        <td><?php echo lang('action'); ?></td>
                    </tr>
                    </thead>
                    <tbody>

                    <tr><td colspan="5"><input type="submit" id="export_submit" class="btn btn-primary" value="<?php echo lang('export') ?>" /></td></tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>