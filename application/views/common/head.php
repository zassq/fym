<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/assets/images/favicon.png">
    <base href="<?php echo site_url(); ?>"/>
    <title>客户管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="/assets/css/bootstrap-theme.min.css" rel="stylesheet"> -->

    <!-- Custom styles for this template -->
    <link href="/assets/css/main.css" rel="stylesheet">
    <?php if(isset($load_extra) && is_array($load_extra)){
        foreach($load_extra as $le){
            switch($le){
            case 'dataTables': ?>
            <link href="/assets/css/bootstrap-dataTables.css" rel="stylesheet">
            <?php break;
            case 'datatimepicker': ?>
            <link href="/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
            <?php break;
            case 'clients_filter': ?>

                <?php break;
            }
        }
    }?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<noscript>
    <div class="noscript">
        <div class="noscript_inner"><?php echo lang('no_script'); ?></div>
    </div>
    <div class="noscript_bg">&nbsp;</div>
</noscript>
<!--[if lt IE 8]>
<div class="noscript">
    <div class="noscript_inner iewarning">
        <h2><?php echo lang('ie_warning'); ?></h2>
        <div class="clearfix">
            <a href="http://www.google.com/intl/zh-CN/chrome/" target="_blank" class="chrome pull-left"><img src="/assets/images/chrome.png" alt="Chrome"/><br /><?php echo lang('chrome'); ?></a>
            <a href="http://www.firefox.com.cn/download/" target="_blank" class="firefox pull-left"><img src="/assets/images/firefox.png" alt="Chrome"/><br /><?php echo lang('firefox'); ?></a>
        </div>
    </div>
</div>
<div class="noscript_bg"></div>
<![endif]-->

<div class="body">
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('users/dash'); ?>"><img src="/assets/images/logo.png" /></a>
        </div>
        <?php if(isset($logged_in)):  ?>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li<?php if($here == 'clients') echo ' class="active"'; ?>>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('clients_mgt') ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('clients/listing'); ?>"><?php echo lang('client_list') ?></a></li>
                        <li><a href="<?php echo site_url('clients/add'); ?>"><?php echo lang('add_client') ?></a></li>
                    </ul>
                </li>
                <li><a href="<?php echo site_url('client_filter'); ?>"><?php echo lang('client_listing') ?></a></li>
                <?php if($userinfo->access == 'fullaccess' || $userinfo->access == 'manager'): ?>
                    <li<?php if($here == 'users') echo ' class="active"'; ?>><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('user_mgt') ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo site_url('users'); ?>"><?php echo lang('user_list') ?></a></li>
                            <?php #if($userinfo->usertype == 'A' && $userinfo->access == 'fullaccess'): ?>
                                <li><a href="<?php echo site_url('users/addUser'); ?>"><?php echo lang('add_user') ?></a></li>
                            <?php #endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo site_url('view_profile'); ?>" class="static bold" href="javascript:"><?php echo lang('welcome'); ?> <?php echo $userinfo->name ?></a></li>
                <li><a href="<?php echo site_url('users/logout') ?>"><?php echo lang('logout') ?></a></li>
            </ul>
        </div><!--/.nav-collapse -->

       <?php endif; ?>
    </div>
</div>


