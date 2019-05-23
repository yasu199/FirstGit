<?php
// 新規商品の追加
function new_item_insert($link, $shop_id, $item_name, $price, $quantity, $file, $status) {
    $shop_id = (int) $shop_id;
    $price = (int) $price;
    $quantity = (int) $quantity;
    $status = (int) $status;
    $file_name = $file['name'];
    mysqli_autocommit($link, false);
    $date = date('Y-m-d H:i:s');
    $sql = 'INSERT INTO item(shop_id, name, price, img, status, create_date, update_date) 
          VALUES (' . $shop_id . ', \'' . $item_name . '\', ' . $price . ', \'' . $file_name . '\', ' . $status . ', \'' . $date . '\', \'' . $date . '\')';
    $result = insert_db($link, $sql);
    if ($result) {
        $id = mysqli_insert_id($link);
        $sql = 'INSERT INTO quantity(item_id, quantity, create_date, update_date) 
                VALUES (' . $id . ', ' . $quantity . ', \'' . $date . '\', \'' . $date . '\')';
        $result = insert_db($link, $sql);
        if ($result) {
            mysqli_commit($link);
            $flag = TRUE;
        } else {
            mysqli_rollback($link);
            $flag = FALSE;
        }
    } else {
        mysqli_rollback($link);
        $flag = FALSE;
    }
    return $flag;
}
// 数量変更
function fix_qunatity($link, $item_id, $quantity) {
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    mysqli_autocommit($link, false);
    $sql = 'UPDATE item SET update_date = \'' . $date . '\' WHERE item_id = ' . $item_id;
    if (update_db($link, $sql)) {
        $sql = 'UPDATE quantity SET 
                quantity = ' . $quantity . ', update_date = \'' . $date . '\' WHERE item_id = ' . $item_id;
        if (update_db($link, $sql)) {
            mysqli_commit($link);
            $flag = TRUE;
        } else {
            mysqli_rollback($link);
        }
    } else {
        mysqli_rollback($link);
  }
    return $flag;
}
// ステータス変更処理
function fix_status($link, $item_id, $status) {
    $flag = FALSE;
    $status = (int) $status;
    $date = date('Y-m-d H:i:s');
    if ($status === 1) {
        $status = 2;
    } else {
        $status = 1;
    }
    $sql = 'UPDATE item SET status = ' . $status . ',
          update_date = \'' . $date . '\' WHERE item_id = ' . $item_id;
    if (update_db($link, $sql)) {
        $flag = TRUE;
    }
    return $flag;
}
// 商品削除時の処理
function item_delete($link, $item_id) {
    $flag = FALSE;
    mysqli_autocommit($link, false);
    $sql = 'DELETE FROM quantity WHERE item_id = ' . $item_id;
    if (delete_db($link, $sql)) {
        $sql = 'DELETE FROM item WHERE item_id = ' . $item_id;
        if (delete_db($link, $sql)) {
            $flag = TRUE;
            mysqli_commit($link);
        } else {
            mysqli_rollback($link);
        }
    }
    return $flag;
}
// 商品データの取得
function get_all_shop_data($link, $id) {
    $id = (int) $id;
    $sql = 'SELECT item.item_id, item.name, item.price, item.img, item.status, quantity.quantity 
            FROM item JOIN quantity ON item.item_id = quantity.item_id WHERE item.shop_id = ' . $id;
    return get_as_array($link, $sql);
}
// ==========================================================================
// ユーザ管理ページ
// データ取得
function get_all_user($link) {
    $sql = 'SELECT user_name, create_date FROM user';
    return get_as_array($link, $sql);
}
// ==============================================================
// ユーザー新規登録処理
// 顧客追加
function insert_user($link, $user_name, $passwd) {
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    // $passwd = password_hash($passwd, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO user(user_name, passwd, create_date, update_date) 
            VALUES (\'' . $user_name . '\', \'' . $passwd . '\', \'' . $date . '\', \'' . $date . '\')';
    if (insert_db($link, $sql)) {
        $flag = TRUE;
    }
    return $flag;
}
// ショップ追加
function insert_shop($link, $user_name, $passwd) {
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    // $passwd = password_hash($passwd, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO shop(shop_name, passwd, create_date) 
            VALUES (\'' . $user_name . '\', \'' . $passwd . '\', \'' . $date . '\')';
    if (insert_db($link, $sql)) {
        $flag = TRUE;
    }
    return $flag;
}
// ============================================================
// ログイン処理
function not_post($url) {
    if (get_request_method() !== 'POST') {
        header('Location: ' . $url);
        exit;
    }
}

// 顧客ページorshop id取得
// function get_customer_id($link, $user_name) {
//     $sql = 'SELECT user_id, user_name, passwd FROM user 
//             WHERE user_name = \'' . $user_name . '\'';
//     return get_as_array($link, $sql);
// }
function get_customer_id($link, $user_name, $passwd) {
    $sql = 'SELECT user_id, user_name FROM user 
            WHERE user_name = \'' . $user_name . '\' AND passwd = \'' . $passwd . '\'';
    return get_as_array($link, $sql);
}

// function get_shop_id($link, $user_name) {
//     $sql = 'SELECT shop_id, passwd FROM shop 
//             WHERE shop_name = \'' . $user_name . '\'';
//     return get_as_array($link, $sql);
// }

function get_shop_id($link, $user_name, $passwd) {
    $sql = 'SELECT shop_id FROM shop 
            WHERE shop_name = \'' . $user_name . '\' AND passwd = \'' . $passwd . '\'';
    return get_as_array($link, $sql);
}








// =======================================================
// ショップ画面
function check_item_db($link, $item_id) {
    $sql = 'SELECT item.status, item.name, quantity.quantity 
            FROM item JOIN quantity ON item.item_id = quantity.item_id WHERE item.item_id = ' . $item_id;
    return get_as_array($link, $sql);
}
// カートに追加済みか確認
function check_cart_exist($link, $user_id, $item_id) {
    $sql = 'SELECT user_id, item_id, amount FROM cart 
            WHERE user_id = ' . $user_id . ' AND item_id = ' . $item_id;
    return get_as_array($link, $sql);
}
// カートを更新
function update_cart($link, $user_id, $item_id, $amount) {
    $amount = $amount + 1;
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    $sql = 'UPDATE cart SET amount = ' . $amount . ', 
            update_date = \'' . $date . '\' WHERE user_id = ' . $user_id . ' AND item_id = ' . $item_id;
    if (update_db($link, $sql)) {
      $flag = TRUE;
    }
    return $flag;
}
// カートに追加
function insert_cart($link, $user_id, $item_id, $name) {
  $flag = FALSE;
  $date = date('Y-m-d H:i:s');
  $sql = 'INSERT INTO cart(user_id, item_id, amount, name, create_date, update_date) 
          VALUES (' . $user_id . ', ' . $item_id . ', 1, \'' . $name . '\', \'' . $date . '\', \'' . $date . '\')';
  if (insert_db($link, $sql)) { 
      $flag = TRUE;
  }
  return $flag;
}
// すべての商品データを取得
function get_all_data($link) {
  $sql = 'SELECT item.item_id, item.name, item.price, item.img, item.status, quantity.quantity 
          FROM item JOIN quantity ON item.item_id = quantity.item_id WHERE item.status = 1';
  return get_as_array($link, $sql);
}
// ====================================================================
// カート画面
// カート削除
function cart_delete($link, $cart_id) {
    $flag = FALSE;
    $sql = 'DELETE FROM cart WHERE cart_id = ' . $cart_id;
    if (delete_db($link, $sql)) {
        $flag = TRUE;
    }
    return $flag;
}

// 数量変更
function fix_amount($link, $cart_id, $amount) {
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    $sql = 'UPDATE cart SET amount = ' . $amount . ', update_date = \'' . $date . '\' WHERE cart_id = ' . $cart_id;
    if (update_db($link, $sql)) {    
        $flag = TRUE;
    }
    return $flag;
}

// 商品情報取得
// 削除された商品情報を取得
function get_deleted_item_cart($link, $user_id) {
    $sql = 'SELECT cart.cart_id, cart.item_id, item.item_id, cart.name FROM cart LEFT JOIN item ON item.item_id = cart.item_id WHERE cart.user_id = ' . $user_id . ' AND item.item_id IS null';
    return get_as_array($link, $sql);
}

// 必要な情報を取得
function get_cart_item_data($link, $user_id) {
    $sql = 'SELECT cart.cart_id, cart.item_id, cart.amount, item.name, item.price, item.img, item.status, quantity.quantity, item.shop_id 
            FROM cart JOIN item ON cart.item_id = item.item_id JOIN quantity ON cart.item_id = quantity.item_id WHERE cart.user_id = ' . $user_id;
    return get_as_array($link, $sql);
}

// 削除された商品のカート削除
function delete_cart_include_deleted_item($link, $data_delete) {
    $err_msg = array();
    foreach ($data_delete as $value) {
        $cart_id = $value['cart_id'];
        $name = $value['name'];
        if (cart_delete($link, $cart_id)) {
            $err_msg[] = $name . 'はSHOPから削除されたため、カートより除外しました';
        } else {
            $err_msg[] = $name. 'カートからの削除失敗';
        }
    }
    return $err_msg;
}

// ================================================================

  // カート削除、オーダーテーブル追加、 quantity変更
function order_shop($link, $user_id, $data) {
    $flag = FALSE;
    $date = date('Y-m-d H:i:s');
    mysqli_autocommit($link, false);
    foreach($data as $value) {
        $cart_id = (int) $value['cart_id'];
        $quantity = (int) $value['quantity'];
        $amount = (int) $value['amount'];
        $item_id = (int) $value['item_id'];
        $shop_id = (int) $value['shop_id'];
        $fix_quantity = $quantity - $amount;
        if (cart_delete($link, $cart_id)) {
          $sql = 'UPDATE item SET update_date = \'' . $date . '\' WHERE item_id = ' . $item_id;
          if (update_db($link, $sql)) {
              $sql = 'UPDATE quantity SET 
                        quantity = ' . $fix_quantity . ', update_date = \'' . $date . '\' WHERE item_id = ' . $item_id;
              if (update_db($link, $sql)) {
                  $sql = 'INSERT INTO `order`(shop_id, user_id, item_id, amount, order_date) VALUES 
                          (' . $shop_id . ', ' . $user_id . ', ' . $item_id . ', ' . $amount . ', \'' . $date . '\')';
                  if (insert_db($link, $sql)) {
                      $flag = TRUE;
                      mysqli_commit($link);
                  } else {
                      mysqli_rollback($link);
                  }
              } else {
                  mysqli_rollback($link);
              }
          } else {
              mysqli_rollback($link);
          }
        } else {
            mysqli_rollback($link);
        }
    }
    return $flag;
}
// 合計金額を取得
function item_total($data) {
    $sum = 0;
    foreach($data as $value) {
        $price = (int) $value['price'];
        $amount = (int) $value['amount'];
        $sum += $price * $amount;
    }
    return $sum;
}

// =======================================================================
// adminチェック
function check_admin($user_name, $passwd) {
    $flag = FALSE;
    if ($user_name === 'admin' && $passwd === 'admin') {
        $flag = TRUE;
    }
    return $flag;
}

function get_admin($user_name, $enter, $out) {
      if ($user_name === 'admin') {
          $_SESSION['user_name'] = $user_name;
          header('Location: ' . $enter);
          exit;
      } else {
          $_SESSION['login_err_flag'] = TRUE;
          header('Location: ' . $out);
          exit;
      }
}
// ログインチェック
function check_login_admin($user_name) {
    $flag = FALSE;
    if (isset($_SESSION[$user_name]) === TRUE && $_SESSION[$user_name] === 'admin') {
        $flag = TRUE;
    }
    return $flag;
}

function get_all_admin_data($link) {
    $sql = 'SELECT item.item_id, item.shop_id, item.name, item.price, item.img, item.status, quantity.quantity
            FROM item JOIN quantity ON item.item_id = quantity.item_id';
    return get_as_array($link, $sql);
}
 ?>
