<?php
// <!-- 商品追加関係のエラーチェック規定 -->
// <!-- type=textの入力値があるかどうか確認 -->
function not_selected_err($value) {
    $flag = FALSE;
    if ($value === '') {
        $flag = TRUE;
    }
    return $flag;
}
// 空白文字だけでないか確認
function not_writed_err($value) {
    $flag = FALSE;
    if (preg_match('/^[\s|　]+$/', $value) === 1) {
        $flag = TRUE;
    }
    return $flag;
}
// 文字数確認
function max_strlen_check($value, $max) {
    $flag = FALSE;
    if (mb_strlen($value) > $max) {
        $flag = TRUE;
    }
    return $flag;
}

// 最小文字数をチェック
function min_strlen_check($value, $min) {
    $flag = FALSE;
    if (mb_strlen($value) < $min) {
        $flag = TRUE;
    }
    return $flag;
}
// 0以上の整数のみで構成されているか
function positive_integer_check($value) {
    $flag = FALSE;
    if (preg_match('/^[0-9]+$/', $value) !== 1 || preg_match('/^[0][0]/', $value) === 1) {
        $flag = TRUE;
    }
    return $flag;
}
// 数値の最大値を規定
function max_number_check($value, $max) {
    $flag = FALSE;
    if ($value > $max) {
        $flag = TRUE;
    }
    return $flag;
}
// ファイルのアップロード時のエラーチェック
function file_empty_err($file) {
    $flag = FALSE;
    if ($file['size'] === 0) {
        $flag = TRUE;
    }
    return $flag;
}
// html側で規定したファイルサイズのエラー
function file_upload_size_err($file) {
    $flag = FALSE;
    if ($file['error'] === 2) {
        $flag = TRUE;
    }
    return $flag;
}
// ファイルサイズのチェック
function file_size_err($file) {
    $flag = FALSE;
    if ($file['size'] > 102400) {
        $flag = TRUE;
    }
    return $flag;
}
// ファイル拡張子の確認
function file_type_err($file) {
    $flag = FALSE;
    $filename = $file['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext !== 'jpeg' && $ext !== 'png' && $ext !== 'jpg') {
        $flag = TRUE;
    }
    if (mime_content_type($file['tmp_name']) !== 'image/png' && mime_content_type($file['tmp_name']) !== 'image/jpeg') {
        $flag = TRUE;
    }
    return $flag;
}
// ファイル移動
function move_file($file, $file_place) {
    $flag = FALSE;
    if (!move_uploaded_file($file['tmp_name'], $file_place . $file['name'])) {
        $flag = TRUE;
    }
    return $flag;
}
// 公開非公開エラー規定
function not_selected_status_err($status) {
    $flag = FALSE;
    if ($status !== '1' && $status !== '2') {
        $flag = TRUE;
    }
    return $flag;
}

// 半角英数字チェック
function half_width_alphanumeric_check($str) {
    $flag = FALSE;
    if (preg_match('/^[0-9a-zA-Z]+$/', $str) !== 1) {
        $flag = TRUE;
    }
    return $flag;
}
// ユーザーがすでに存在しているか
function same_user_check($link, $user_name) {
    $flag = FALSE;
    $sql = 'SELECT * FROM user WHERE user_name = \'' . $user_name . '\'';
    $data = get_as_array($link, $sql);
    if (count($data) !== 0) {
        $flag = TRUE;
    }
    return $flag;
}
// 同一ショップ
function same_shop_check($link, $user_name) {
    $flag = FALSE;
    $sql = 'SELECT * FROM shop WHERE shop_name = \'' . $user_name . '\'';
    $data = get_as_array($link, $sql);
    if (count($data) !== 0) {
        $flag = TRUE;
    }
    return $flag;
}
// =======================================================
// ショップ画面
// ステータス確認
function check_status($status) {
    $flag = FALSE;
    if ($status === 2) {
        $flag = TRUE;
    }
    return $flag;
}
// 個数確認
function check_quantity($quantity) {
    $flag = FALSE;
    if ($quantity < 1) {
        $flag = TRUE;
    }
    return $flag;
}
// 商品削除確認
function check_item_exist($data) {
    $flag = FALSE;
    if (count($data) === 0) {
        $flag = TRUE;
    }
    return $flag;
}
// =================================================
// カート側
// 0より大きいの整数のみで構成されているか
function large_zero_integer_check($value) {
    $flag = FALSE;
    if (preg_match('/^[0-9]+$/', $value) !== 1 || preg_match('/^[0]/', $value) === 1 ) {
        $flag = TRUE;
    }
    return $flag;
}
// ==========================================================
// 商品購入時
// 購入時チェック
function check_buy_status_quantity($data) {
    $err_msg = array();
    foreach ($data as $value) {
        $quantity = $value['quantity'];
        $amount = $value['amount'];
        $name = $value['name'];
        $status = $value['status'];
        if ($status === '2') {
            $err_msg[] = $name . 'は売り切れてしまいました';
        } elseif ($amount > $quantity) {
            $err_msg[] = '商品在庫が不足しています！！' . $name . 'の在庫数：' . $quantity;
        }
    }
    if (count($err_msg) !== 0) {
        $return = array(TRUE, $err_msg);
    } else {
        $return = array(FALSE);
    }
    return $return;
}
// ===============================================================
// admin画面ショップ確認
function not_shop_exist($link, $shop_id) {
    $flag = FALSE;
    $sql = 'SELECT * FROM shop WHERE shop_id = ' . $shop_id;
    $data = get_as_array($link, $sql);
    if (count($data) === 0) {
        $flag = TRUE;
    }
    return $flag;
}
?>
