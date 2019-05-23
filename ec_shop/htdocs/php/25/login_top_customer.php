<!--ログインで入力したものを受け取る-->
<?php 
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$login_page = './login_customer.php';
$shop_home = './shop_home.php';
$tool_admin = './tool_admin.php';
$err_msg = array();
not_post($login_page);
// セッション開始
session_start();

$user_name = get_post_data('user_name');
$passwd = get_post_data('passwd');
if (check_admin($user_name, $passwd)) {
    get_admin($user_name, $tool_admin, $login_page);
} else {
    $link = get_db_connect();
    $data = get_customer_id($link, $user_name, $passwd);
    close_db_connect($link);
    // ユーザー登録があるか確認
    // if (!password_verify($passwd, $data['passwd'])) {
    //     $_SESSION['login_err_flag'] = TRUE;
    //     header('Location: ' . $login_page);
    //     exit;
    // }
    if (count($data) === 0) {
        $_SESSION['login_err_flag'] = TRUE;
        header('Location: ' . $login_page);
        exit;
    }
    // 登録データが取得できた？
check_get_user($data, 'user_id', 'user_name', $shop_home, $login_page);
}
?>