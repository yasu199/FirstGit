<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$err_msg = array();
$data = array();
$message = '';
$i = 0;
$file_place = './image/';
$top = './top.php';
session_start();
$user_id = (int) login_check('user_id', $top);
$user_name = login_check('user_name', $top);
// データベース接続
$link = get_db_connect();

if (get_request_method() === 'POST') {
    $item_id = (int) get_post_data('item_id');
    $data = check_item_db($link, $item_id);
    $status = (int) $data[0]['status'];
    $quantity = (int) $data[0]['quantity'];
    $name = $data[0]['name'];
    if (check_status($status)) {
        $err_msg[] = '商品が売り切れてしまいました';
    }
    if (check_quantity($quantity)) {
        $err_msg[] = '商品が売り切れてしまいました';
    }
    if (check_item_exist($data)) {
        $err_msg[] = '商品が売り切れてしまいました';
    }
    if (count($err_msg) === 0) {
        $data = check_cart_exist($link, $user_id, $item_id);
        if (count($data) !== 0) {
            $amount = (int) $data[0]['amount'];
            if (update_cart($link, $user_id, $item_id, $amount)) {
                $message = 'カート追加成功';
            } else {
                $err_msg[] = 'カート追加失敗';
            }
        } else {
            if (insert_cart($link, $user_id, $item_id, $name)) {
                $message = '商品追加成功';
            } else {
                $err_msg[] = '商品追加失敗';
            }
        }
    }
}
// 商品情報を取得
$data = get_all_data($link);
$how_many = count($data);
close_db_connect($link);
include_once '../../../include/view/view25/shop_home.php';
