<div class="container">
    <h1><?php echo lang('client_list'); ?></h1>
    <p><a href="<?php echo site_url('clients/add'); ?>" class="btn btn-primary"><?php echo lang('add_client') ?></a></p>

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
                        <td><a href="<?php echo site_url('client/'.$client->id); ?>"><?php echo $client->name; ?></a></td>
                        <td><?php echo $client->is_hightech == "Y" ? lang('yes') : lang('no'); ?></td>
                        <td><?php echo $client->is_soft_comp == "Y" ? lang('yes') : lang('no'); ?></td>
                        <td><?php echo !empty($client->level1) ? $level1[$client->level1] : lang('nope'); ?></td>
                        <td><?php echo !empty($client->area)?$client->area : lang('nope'); ?></td>
                        <td><?php echo $client->staff; ?></td>
                        <td><?php
                            if(isset($client->marketing_log)){
                                foreach($client->marketing_log as $ml_key=>$ml){
                                    ?>
                                    <p class="small"><strong class="text-success"><?php echo $ml->staff ?></strong> :: <?php echo $ml->date; ?><br/><?php echo $ml->detail; ?></p>
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
</div>