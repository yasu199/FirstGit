<?php
require_once '../../../include/conf/const.php';
require_once '../../../include/model/model25/common_function.php';
require_once '../../../include/model/model25/ec_function.php';
require_once '../../../include/model/model25/err_check_function.php';
$err_msg = array();
$file_place = './image/';
$data = array();
$message = '';
$top = './top.php';
session_start();
$shop_id = login_check('shop_id', $top);
// データベース接続
$link = get_db_connect();

if (get_request_method() === 'POST') {
    // 新規追加or設定変更か判別
    // 新規追加の場合はhiddenでinsertを飛ばす
    if (get_post_route('insert') === TRUE) {
        $item_name = get_post_data('item_name');
        $price = get_post_data('price');
        $quantity = get_post_data('quantity');
        $file = get_file_data('img');
        $status = get_post_data('status');
        // 商品名についてエラー確認
        if (not_selected_err($item_name)) {
          $err_msg[] = '商品名を入力してください';
        }
        if (not_writed_err($item_name)) {
          $err_msg[] = '商品名を入力してください';
        }
        if (max_strlen_check($item_name, 15)) {
          $err_msg[] = '商品名は15文字以内で入力してください';
        }
        // 値段についてのエラーチェック
        if (not_selected_err($price)) {
          $err_msg[] = '商品の値段を設定してください';
        }
        if (positive_integer_check($price)) {
          $err_msg[] = '値段は0以上の整数のみで入力ください';
        }
        if (max_number_check($price, 1000000)) {
          $err_msg[] = '値段は100万円以下までで設定ください';
        }
        // 商品の数量についてのエラー規定
        if (not_selected_err($quantity)) {
          $err_msg[] = '商品の個数を設定してください';
        }
        if (positive_integer_check($quantity)) {
          $err_msg[] = '個数は0以上の整数のみで入力ください';
        }
        if (max_number_check($quantity, 100)) {
          $err_msg[] = '個数は100個以下までで設定ください';
        }
        // ファイルアップロード時のエラー規定
        if (file_upload_size_err($file)) {
          $err_msg[] = 'ファイルサイズは100キロバイト以下でお願いします';
        } elseif (file_empty_err($file)) {
          $err_msg[] = 'アップロードファイルを選択してください';
        } elseif (file_size_err($file)) {
          $err_msg[] = 'ファイルサイズは100キロバイト以下でお願いします';
        } elseif (file_type_err($file)) {
          $err_msg[] = '拡張子はjpegもしくはpngのみ受け付けます';
        }
        // ステータス未選択エラー
        if (not_selected_status_err($status)) {
          $err_msg[] = 'ステータスを設定してください';
        }
        // エラーなければファイルを保存
        if (count($err_msg) === 0) {
          if (move_file($file, $file_place)) {
            $err_msg[] = 'ファイル移動に失敗しました';
          }
        }
        // データベースに新規商品を追加(item,quantityテーブル)
        if (count($err_msg) === 0) {
          if (new_item_insert($link, $shop_id, $item_name, $price, $quantity, $file, $status)) {
            $message = '商品追加成功';
          } else {
            $err_msg[] = 'データベース商品追加失敗';
          }
        }
    }
    // 在庫数変更時の処理
    if (get_post_route('fix_quantity') === TRUE) {
      $item_id = (int) get_post_data('item_id');
      $quantity = get_post_data('quantity');
      // 商品の数量についてのエラー規定
      if (not_selected_err($quantity)) {
        $err_msg[] = '商品の個数を設定してください';
      }
      if (positive_integer_check($quantity)) {
        $err_msg[] = '個数は0以上の整数のみで入力ください';
      }
      if (max_number_check($quantity, 100)) {
        $err_msg[] = '個数は100個以下までで設定ください';
      }
      if (count($err_msg) === 0) {
        $quantity = (int) $quantity;
        if (fix_qunatity($link, $item_id, $quantity)) {
          $message = '在庫変更成功';
        } else {
          $err_msg[] = '在庫変更失敗';
        }
      }
    }
    // ステータス変更時の処理
    if (get_post_route('fix_status') === TRUE) {
      $item_id = (int) get_post_data('item_id');
      $status = get_post_data('status');
      if (not_selected_status_err($status)) {
        $err_msg[] = 'ステータスを設定してください';
      }
      if (count($err_msg) === 0) {
        if (fix_status($link, $item_id, $status)) {
          $message = 'ステータス変更に成功しました';
        } else {
          $err_msg[] = 'ステータス変更に失敗しました';
        }
      }
    }
    // 削除時の処理
    if (get_post_route('delete') === TRUE) {
      $item_id = (int) get_post_data('item_id');
      if (item_delete($link, $item_id) === TRUE) {
        $message = '商品削除成功';
      } else {
        $err_msg[] = '商品削除失敗';
      }
    }
}
// 商品データ取得
$data = get_all_shop_data($link, $shop_id);
close_db_connect($link);

include_once '../../../include/view/view25/tool.php';