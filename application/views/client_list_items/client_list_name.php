<a href="<?php echo site_url('client/'.$id); ?>"><?php echo $name; ?></a><br/>
<?php if(!empty($address)):?><span class="small"><?php echo $address; ?></span><br/><?php endif;?>
<?php if(!empty($contact)):?><span class="small"><?php echo lang('contact') ?>：<?php echo $contact; ?></span><br/><?php endif;?>
<?php if(!empty($phone1)):?><span class="small"><?php echo $phone1; ?></span><br/><?php endif;?>
<?php if(!empty($phone2)):?><span class="small"><?php echo $phone2; ?></span><br/><?php endif;?>
<?php if(!empty($phone3)):?><span class="small"><?php echo $phone3; ?></span><br/><?php endif;?>