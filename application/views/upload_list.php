<div class="container">
    <h1>上传细节</h1>
    <p>上传时间：<?php echo $upload_info->upload_date;?></p>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th><?php echo lang('id') ?></th>
                <th>企业名称</th>
                <th>项目</th>
                <th>进度</th>
                <th>意向类别</th>
                <th>地区</th>
                <th>企业联系人信息</th>
                <th>企业信息</th>
                <th>备注</th>
            </tr>
            <?php foreach($upload_items as $_ui): ?>
                <tr>
                    <td><?php echo $_ui->id; ?></td>
                    <td><a href="<?php echo site_url('client/'.$_ui->id); ?>"><?php echo $_ui->name; ?></a></td>
                    <td><?php echo ($_ui->primary_project == '0') ? '无' : $projects[$_ui->primary_project];?></td>
                    <td><?php echo $progress[$_ui->progress];?></td>
                    <td><?php echo $status[$_ui->status];?></td>
                    <td><?php echo $_ui->area; ?></td>
                    <td><?php echo $_ui->contact; ?></td>
                    <td><?php echo $_ui->info; ?></td>
                    <td><?php echo $_ui->note; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>