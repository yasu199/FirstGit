<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$err_msg = array();
$data = array();
$message = '';
$file_place = './image/';
$top = './top.php';
session_start();
$user_id = (int) login_check('user_id', $top);
$user_name = login_check('user_name', $top);
// データベース接続
$link = get_db_connect();
if (get_request_method() === 'POST') {
  // カート削除処理
    if (get_post_route('delete') === TRUE) {
        $cart_id = (int) get_post_data('cart_id');
        if (cart_delete($link, $cart_id)) {
            $message = 'カート内の商品を削除しました';
        } else {
            $err_msg[] = 'カート削除失敗';
        }
    }
    // 数量変更処理
    if (get_post_route('fix_amount') === TRUE) {
        $cart_id = (int) get_post_data('cart_id');
        $amount = get_post_data('amount');
        // 数量についてのエラー規定
        if (not_selected_err($amount)) {
            $err_msg[] = '商品の個数を設定してください';
        }
        if (large_zero_integer_check($amount)) {
            $err_msg[] = '個数は1以上の整数で入力ください';
        }
        if (max_number_check($amount, 100)) {
            $err_msg[] = '個数は100個以下までで設定ください';
        }
        if (count($err_msg) === 0) {
            $amount = (int) $amount;
            if (fix_amount($link, $cart_id, $amount)) {
                $message = '数量変更に成功しました';
            } else {
                $err_msg[] = '数量変更に失敗しました';
            }
        }
    }
}
// 商品情報取得
$data_delete = get_deleted_item_cart($link, $user_id);
if (count($data_delete) !== 0) {
    $err_msg = delete_cart_include_deleted_item($link, $data_delete);
}
$data = get_cart_item_data($link, $user_id);
// 合計金額を取得
$total = item_total($data);
// 商品購入処理
if (get_request_method() === 'POST') {
    if (get_post_route('buy') === TRUE) {
        if (count($data) !== 0) {
            if (count($data_delete) === 0) {
                $buy_check = check_buy_status_quantity($data);
                if ($buy_check[0]) {
                    $err_msg = $buy_check[1];
                }
                if (count($err_msg) === 0) {
                    // カート削除、オーダーテーブル追加、 quantity変更
                      if (order_shop($link, $user_id, $data)) {
                          close_db_connect($link);
                          $message = 'ご購入ありがとうございます！';
                          include_once '../../../include/view/view25/result_cart.php';
                          exit;
                      } else {
                          $err_msg[] = '購入処理失敗';
                      }
                }
            }
        } else {
            $err_msg[] = '商品がカートには入っていません';
        }
    }
}

close_db_connect($link);
include_once '../../../include/view/view25/cart.php';