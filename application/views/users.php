<div class="container">
    <h1><?php echo lang('user_mgt'); ?></h1>
    <p><a href="<?php echo site_url('users/addUser'); ?>" class="btn btn-primary"><?php echo lang('add_user') ?></a></p>

    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th><?php echo lang('id') ?></th>
            <th><?php echo lang('name') ?></th>
            <th><?php echo lang('username') ?></th>
            <th><?php echo lang('email') ?></th>
            <th><?php echo lang('usertype'); ?></th>
            <th><?php echo lang('access'); ?></th>
            <th><?php echo lang('note'); ?></th>
            <th><?php echo lang('action'); ?></th>
        </tr>
        <?php foreach($users as $user): ?>
            <?php if(($userinfo->access == 'manager' && $user->access != 'fullaccess') || $userinfo->access == 'fullaccess') : ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $usertype[$user->usertype]; ?></td>
                    <td><?php echo $access[$user->access]; ?></td>
                    <td><?php echo !empty($user->note)?$user->note : lang('nope'); ?></td>
                    <td><a href="<?php echo site_url('user_update/'.$user->id) ?>" class="btn btn-sm btn-default"><?php echo lang('edit') ?></a> <a href="<?php echo site_url('user_delete/'.$user->id) ?>" class="btn btn-sm btn-danger" onclick="javascript: if(!confirm('<?php echo lang('confirm_delete'); ?>')) return false;"><?php echo lang('delete') ?></a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
</div>