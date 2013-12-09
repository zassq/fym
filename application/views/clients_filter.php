<div class="container">
    <div class="col-md-12">
        <h1><?php echo lang('client_listing') ?></h1>
        <h2 class=""><?php echo lang('use_instruction') ?></h2>
        <p class="text-primary"><?php echo lang('clients_filter_instruction'); ?></p>
        <br />
    </div>
    <div class="form-group" id="upload_outer">
        <div class="col-md-4">
            <label for="new_client_list" class="col-sm-6 control-label"><?php echo lang('new_client_list') ?>：</label>
            <div class="col-sm-6">
            <span id="client_upload" class="btn btn-success">
                <i class="glyphicon glyphicon-open"></i>
                <span><?php echo lang('new_client_list');?></span>
                <input type="file" class="form-control" name="new_client_list" id="new_client_list" placeholder="<?php echo lang('new_client_list');?>"/>
            </span>
            </div>
        </div>
        <div class="col-md-8" id="upload_file_name_outer">
            <label for="" class="col-sm-4 control-label"><?php echo lang('file_name'); ?>:</label>
            <span class="form-control-static" id="upload_file_name"></span>
        </div>
    </div>
    <br />
    <br />
    <div class="col-md-12">
        <div class="form-group">
            <span class="col-sm-2 control-label"><strong><?php echo lang('filter_status'); ?>:</strong></span>
            <span class="col-sm-12 text-warning" id="filter_status"><?php echo lang('await'); ?></span>
        </div>
    </div>
    <br />
    <br />
    <div class="col-md-12">
        <div id="client_filter_list">
            <h2><?php echo lang('new_client_list_detail'); ?></h2>
            <table id="client_filter_list_table" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <td><?php echo lang('select'); ?></td>
                        <td><?php echo lang('company_name'); ?></td>
                        <td><?php echo lang('already_client'); ?></td>
                        <td><?php echo lang('already_hightech'); ?></td>
                        <td><?php echo lang('action'); ?></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
