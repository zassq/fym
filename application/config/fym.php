<?php
/**
 *  Config items for fym application
 */
#$config

$config['fymauth_users_table'] = 'staff';
$config['fymauth_password_min_length'] = 4;
$config['fymauth_portable_hashes'] = true;
$config['fymauth_rmb_me_cookie_name'] = 'fmy_rmbme';

$config['access']['fullaccess'] ='管理员权限';
$config['access']['manager'] ='经理权限';
$config['access']['staff'] ='员工权限';

$config['usertype']['A'] = '管理员';
$config['usertype']['S'] = '员工';

$config['clients_listing_cols'] = array( 'name', 'progress', 'status', 'primary_project', 'primary_project_year','level1', 'area', 'staff' );
?>