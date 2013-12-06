

<div class="jumbotron">
    <div class="container">
        <h1><?php echo lang('welcome_to_system'); ?></h1>
        <p><?php echo lang('bible');?></p>
    </div>
</div>

<div class="container">
    <h2><?php echo lang('my_dash'); ?></h2>
    <br/>
    <div class="row">
        <div class="col-md-6" id="user_client">
            <h3><?php echo lang('my_client'); ?> | <a href="<?php echo site_url('clients/add'); ?>" class="btn btn-primary"><?php echo lang('add_client') ?></a></h3>
            <div class="loading">
                <h3><img src="/assets/images/loading.gif" alt="loading"/> <span class="text-fy"><?php echo lang('loading'); ?></span></h3>
            </div>
            <div class="displayTable table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <td><?php echo lang('company_name'); ?></td>
                            <td><?php echo lang('progress'); ?></td>
                            <td><?php echo lang('status'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <p><a class="btn btn-default" href="<?php echo site_url('clients/listing'); ?>"><?php echo lang('view_all'); ?></a></p>
            </div>
        </div>
        <div class="col-md-6" id="user_history">
            <h3><?php echo lang('my_history'); ?></h3>
            <div class="loading">
                <h3><img src="/assets/images/loading.gif" alt="loading"/> <span class="text-fy"><?php echo lang('loading'); ?></span></h3>
            </div>
            <div class="displayTable table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <td><?php echo lang('date'); ?></td>
                        <td><?php echo lang('action'); ?></td>
                        <td><?php echo lang('detail'); ?></td>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>