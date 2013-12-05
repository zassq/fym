<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo $client->name; ?></h1>
            <p><a href="<?php echo site_url('client_update/'.$client->id); ?>" class="btn btn-primary"><?php echo lang('update_client') ?></a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('company_details') ?></strong></span>
                <span class="col-md-8">
                    <?php if(!empty($client->address)) echo $client->address."<br />"; ?>
                    <?php if(!empty($client->contact)):?><span class="small"><?php echo lang('contact') ?></span>：<?php echo $client->contact; ?><br/><?php endif;?>
                    <?php if(!empty($client->phone1)) echo $client->phone1."<br />"; ?>
                    <?php if(!empty($client->phone2)) echo $client->phone2."<br />"; ?>
                    <?php if(!empty($client->phone3)) echo $client->phone3."<br />"; ?>
                    <?php if(!empty($client->note)) echo $client->note.""; ?>
                </span>
            </p>
        </div>
        <div class="col-md-6">
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('sales_rep') ?></strong></span>
                <span class="col-md-8"><?php echo $client->staff; ?></span>
            </p>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('level1') ?></strong></span>
                <span class="col-md-8"><?php echo $level1[$client->level1]; ?></span>
            </p>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('progress') ?></strong></span>
                <span class="col-md-8"><?php echo $progress[$client->progress]; ?></span>
            </p>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('status') ?></strong></span>
                <span class="col-md-8"><?php echo $status[$client->status]; ?></span>
            </p>
            <?php if(!empty($client->area)): ?>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('area') ?></strong></span>
                <span class="col-md-8"><?php echo $client->area; ?></span>
            </p>
            <?php endif; ?>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('hightech') ?></strong></span>
                <span class="col-md-8"><?php if($client->is_hightech == 'Y'){echo '<span class="text-success">'.lang('yes').'</span>';if(isset($certs['H'])) echo ' | <span class="small">'.lang('hight_tech_cert_code').'</span>：'.$certs['H']->cert_code;}else echo '<span class="text-danger">'.lang('no').'</span>'; ?></span>
            </p>
            <p class="clearfix">
                <span class="col-md-4"><strong><?php echo lang('software_company') ?></strong></span>
                <span class="col-md-8"><?php if($client->is_soft_comp == 'Y'){echo '<span class="text-success">'.lang('yes').'</span>';if(isset($certs['S'])) echo ' | <span class="small">'.lang('soft_comp_cert_code').'</span>：'.$certs['S']->cert_code;}else echo '<span class="text-danger">'.lang('no').'</span>'; ?></span>
            </p>
        </div>
    </div>
    <!-- <div class="col-md-6">
        <h2><?php echo $client->name; ?></h2>
        <dl class="dl-horizontal">
            <dt><?php echo lang('company_details') ?></dt>
            <dd>
                <?php if(!empty($client->address)) echo $client->address."<br />"; ?>
                <span class="small"><?php echo lang('contact') ?></span>：<?php echo $client->contact; ?><br/>
                <?php if(!empty($client->phone1)) echo $client->phone1."<br />"; ?>
                <?php if(!empty($client->phone2)) echo $client->phone2."<br />"; ?>
                <?php if(!empty($client->phone3)) echo $client->phone3."<br />"; ?>
                <?php if(!empty($client->note)) echo $client->note.""; ?>
            </dd>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="dl-horizontal">
            <dt><?php echo lang('sales_rep') ?></dt>
            <dd><?php echo $client->staff; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('level1') ?></dt>
            <dd><?php echo $level1[$client->level1]; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('progress') ?></dt>
            <dd><?php echo $progress[$client->progress]; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('status') ?></dt>
            <dd><?php echo $status[$client->status]; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('area') ?></dt>
            <dd><?php echo $client->area; ?></dd>
        </dl>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <h2><?php echo lang('marketing_log');?></h2>
            <?php if($ml_items && count($ml_items) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered sorting_table">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td><?php echo lang('date');?></td>
                            <td><?php echo lang('sales_rep');?></td>
                            <td><?php echo lang('marketing_log');?></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($ml_items as $k=>$ml_item):?>
                            <tr>
                                <td><?php echo $k+1;?></td>
                                <td><?php echo date(lang('date_format'), strtotime($ml_item->date));?></td>
                                <td><?php echo $ml_item->staff;?></td>
                                <td><?php echo $ml_item->detail;?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p><?php echo lang('no_marketing_log');?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo lang('new_market_log'); ?> | <a href="javascript:" class="btn btn-primary" onclick="javascript: add_new_ml();"><?php echo lang('add_new_ml') ?></a></h2>
            <form action="<?php echo site_url('client_add_ml'); ?>" method="post">
                <input type="hidden" name="cid" value="<?php echo $client->id;?>" />
                <div id="marketing_logs" class="col-md-12">
                    <div class="form-group marketing_log_row" id="ml_row_1">
                        <div class="well clearfix row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php echo form_label(lang('date').'：', 'ml_date_1', array('class' => 'col-sm-4 control-label')); ?>
                                    <div class="col-sm-8 input-group date marketing_log_date">
                                        <?php echo form_input(array('type' => 'text','class' => 'form-control','id' => 'ml_date_1', 'placeholder' => lang('date'), 'name' => 'ml_date[]', 'data-format' => "YYYY-MM-DD")); ?>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label(lang('sales_rep').'：', 'ls_sales_rep_1', array('class' => 'col-sm-7 control-label')); ?>
                                    <div class="col-sm-5">
                                        <?php #echo form_dropdown('ml_staff_id[]', $staff, ($userinfo->usertype == 'A' ? '2' : $userinfo->id), 'class="form-control" onchange="javascript: $(\'#ml_staff_name_1\').val($(this).find(\'option:selected\').text())" id="ls_sales_rep_1"');
                                        echo $userinfo->name;?>
                                        <input type="hidden" name="ml_staff_id[]" value="<?php echo $userinfo->id;?>"/>
                                        <input type="hidden" name="ml_staff_name[]" id="ml_staff_name_1" value="<?php echo $staff[$userinfo->id]; ?>" />
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
                <?php echo form_submit('save_ml', lang('submit'), 'class="btn btn-primary btn-lg btn-block"') ?>
            </form>
        </div>
    </div>
</div>