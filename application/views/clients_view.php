<div class="container">
    <h1><?php echo lang('client_info') ?></h1>
    <div class="col-md-6">
        <h2><?php echo lang('basic_info') ?></h2>
        <dl class="dl-horizontal">
            <dt><?php echo lang('company_name') ?></dt>
            <dd><?php echo $client->name; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('address') ?></dt>
            <dd><?php echo $client->address; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('contact') ?></dt>
            <dd><?php echo $client->contact; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('phone') ?> 1</dt>
            <dd><?php echo $client->phone1; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('phone') ?> 2</dt>
            <dd><?php echo $client->phone2; ?></dd>
        </dl>
        <dl class="dl-horizontal">
            <dt><?php echo lang('phone') ?> 3</dt>
            <dd><?php echo $client->phone3; ?></dd>
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
    </div>

</div>