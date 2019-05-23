<!-- 顧客側 -->
<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';

$err_msg = array();
$login_err_flag = '';
$shop_home = './shop_home.php';
$tool_admin = './tool_admin.php';
// セッションを開始
session_start();
// admin確認
if (check_login_admin('user_name')) {
    header_other_page($tool_admin);
} else {
    // ログイン確認
    check_login('user_id', $shop_home);
    // エラーフラグを確認
    $login_err_flag = check_login_err_flag('login_err_flag');
    include_once '../../../include/view/view25/login_customer.php';
}