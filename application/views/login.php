<div class="container">
    <h1 class="signin_h1"><a href="<?php echo site_url(); ?>"><img src="/assets/images/logo.png" /><span>   客户管理系统</span></a></h1>
    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">请登录</h2>
        <?php if($error) echo '<div class="bs-callout bs-callout-danger"><p>'. $error .'</p></div>'; ?>
        <?php echo validation_errors('<div class="bs-callout bs-callout-danger">', '</div>'); ?>
        <input type="text" class="form-control" placeholder="用户名" name="username" value="<?php echo set_value('username') ?>" required autofocus>
        <input type="password" class="form-control" placeholder="密码" name="password" value="<?php echo set_value('password') ?>" required>
        <label class="checkbox">
            <input type="checkbox" value="remember-me" name="rmbme"> 七天内免登录
        </label>
        <input class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="<?php echo lang('login'); ?>"/>
    </form>

</div>