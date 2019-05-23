<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$data = array();
$top = './top.php';
session_start();
// admin確認
if (check_login_admin('user_name')) {
    $check = login_check('user_name', $top);
} else {
    $check = login_check('shop_id', $top);
}
if ($check === 'admin') {
    $url = 'tool_admin.php';
} else {
    $url = 'tool.php';
}
$link = get_db_connect();
// 商品データ取得
$data = get_all_user($link);

close_db_connect($link);

include_once '../../../include/view/view25/tool_user.php';