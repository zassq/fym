<?php
if(isset($marketing_log) && !empty($marketing_log)){
    foreach($marketing_log as $ml_key=>$ml){
        ?>
        <p class="small"><strong class="text-success"><?php echo $ml->staff ?></strong> | <?php echo date(lang('date_format'), strtotime($ml->date)); ?>：<br/><?php echo nl2br($ml->detail); ?></p>
    <?php
    }
}else echo lang('nope');
?>