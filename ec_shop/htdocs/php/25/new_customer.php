<!-- 新規追加用 -->
<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';

$err_msg = array();
$message = '';

$link = get_db_connect();
if (get_request_method() === 'POST') {
    $user_name = get_post_data('user_name');
    $passwd = get_post_data('passwd');
    // user_nameのエラーチェック
    // if ($user_name === 'admin') {
    //     $err_msg[] = 'すでに同一のユーザー名が存在しています';
    // }
    if (half_width_alphanumeric_check($user_name)) {
        $err_msg[] = 'ユーザーネームは半角英数字のみです';
    }
    if (max_strlen_check($user_name, 10) || min_strlen_check($user_name, 6)) {
        $err_msg[] = 'ユーザーネームは6文字以上10文字以下です';
    }
    if (half_width_alphanumeric_check($passwd)) {
        $err_msg[] = 'パスワードは半角英数字のみです';
    }
    if (max_strlen_check($passwd, 10) || min_strlen_check($passwd, 6)) {
        $err_msg[] = 'パスワードは6文字以上10文字以下です';
    }
    if (count($err_msg) === 0) {
        // 顧客情報の追加
        if (same_user_check($link, $user_name)) {
            $err_msg[] = 'すでに同一のユーザー名が存在しています';
        }
        if (count($err_msg) === 0) {
            if (insert_user($link, $user_name, $passwd)) {
                $message = '新規追加が完了しました';
            } else {
                $err_msg[] = '新規追加に失敗しました';
            }
        }
    }
}
close_db_connect($link);
include_once '../../../include/view/view25/new_customer.php';
