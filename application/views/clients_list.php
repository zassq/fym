<div class="container">
    <h1><?php echo lang('client_list'); ?></h1>
    <p><a href="<?php echo site_url('clients/add'); ?>" class="btn btn-primary"><?php echo lang('add_client') ?></a></p>


    <?php if(!empty($clients)):?>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered sorting_table">
            <thead>
                <tr>
                    <th><?php echo lang('id') ?></th>
                    <th><?php echo lang('company_name') ?></th>
                    <th><?php echo lang('hightech') ?></th>
                    <th><?php echo lang('software_company') ?></th>
                    <th><?php echo lang('level1') ?></th>
                    <th><?php echo lang('area'); ?></th>
                    <th><?php echo lang('sales_rep'); ?></th>
                    <th><?php echo lang('marketing_log'); ?></th>
                    <th><?php echo lang('note'); ?></th>
                    <th><?php echo lang('action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client): ?>
                    <tr>
                        <td><?php echo $client->id; ?></td>
                        <td>
                            <a href="<?php echo site_url('client/'.$client->id); ?>"><?php echo $client->name; ?></a><br/>
                            <?php if(!empty($client->address)):?><span class="small"><?php echo $client->address; ?></span><br/><?php endif;?>
                            <?php if(!empty($client->contact)):?><span class="small"><?php echo lang('contact') ?>：<?php echo $client->contact; ?></span><br/><?php endif;?>
                            <?php if(!empty($client->phone1)):?><span class="small"><?php echo $client->phone1; ?></span><br/><?php endif;?>
                            <?php if(!empty($client->phone2)):?><span class="small"><?php echo $client->phone2; ?></span><br/><?php endif;?>
                            <?php if(!empty($client->phone3)):?><span class="small"><?php echo $client->phone3; ?></span><br/><?php endif;?>
                            <?php if(!empty($client->note)):?><span class="small"><?php echo nl2br($client->note); ?></span><br/><?php endif;?>
                        </td>
                        <td><span class="<?php echo $client->is_hightech == "Y" ? 'text-success' : 'text-danger'; ?>"><?php echo $client->is_hightech == "Y" ? lang('yes') : lang('no'); ?></span><?php if(!empty($client->hightech_cert_id)) echo '<br/><span class="small text-muted">'.lang('cert_code').'：<strong>'.$certs[$client->hightech_cert_id]->cert_code.'</strong></span>';?></td>
                        <td><span class="<?php echo $client->is_soft_comp == "Y" ? 'text-success' : 'text-danger'; ?>"><?php echo $client->is_soft_comp == "Y" ? lang('yes') : lang('no'); ?></span><?php if(!empty($client->soft_comp_cert_id)) echo '<br/><span class="small text-muted">'.lang('cert_code').'：<strong>'.$certs[$client->soft_comp_cert_id]->cert_code.'</strong></span>';?></td>
                        <td><?php echo !empty($client->level1) ? $level1[$client->level1] : lang('nope'); ?></td>
                        <td><?php echo !empty($client->area)?$client->area : lang('nope'); ?></td>
                        <td>
                            <?php echo $client->staff; ?><br/>
                            <span class="text-info small"><?php echo $progress[$client->progress];?><br></span>
                            <span class="text-warning small"><?php echo $status[$client->status];?></span>
                        </td>
                        <td><?php
                            if(isset($client->marketing_log)){
                                foreach($client->marketing_log as $ml_key=>$ml){
                                    ?>
                                    <p class="small"><strong class="text-success"><?php echo $ml->staff ?></strong> | <?php echo date(lang('date_format'), strtotime($ml->date)); ?>：<br/><?php echo $ml->detail; ?></p>
                                    <?php
                                }
                            }else echo lang('nope');
                            ?></td>
                        <td><?php echo !empty($client->note)?$client->note : lang('nope'); ?></td>
                        <td><a href="<?php echo site_url('client/'.$client->id) ?>" class="btn btn-sm btn-default"><?php echo lang('view') ?></a><!-- <a href="<?php echo site_url('client_delete/'.$client->id) ?>" class="btn btn-sm btn-danger" onclick="javascript: if(!confirm('<?php echo lang('confirm_delete'); ?>')) return false;"><?php echo lang('delete') ?></a> --></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <h2><?php echo lang('no_clients'); ?></h2>
    <?php endif; ?>
</div>